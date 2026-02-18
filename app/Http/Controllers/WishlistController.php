<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Deal;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class WishlistController extends Controller
{
    public function index()
    {
        return view('wishlist');
    }

    public function data(Request $request)
    {
        // Build list from deals where inventory_id IS NULL (wishlist items)
        $query = Deal::with('customer')->whereNull('inventory_id')->where('vehicle_description', '!=', 'No Vehicle Entered');

        if ($request->filled('fromDate')) {
            $query->whereDate('updated_at', '>=', $request->input('fromDate'));
        }

        if ($request->filled('toDate')) {
            $query->whereDate('updated_at', '<=', $request->input('toDate'));
        }

        if ($request->filled('user')) {
            // user filter should match any related user role fields on the deal
            $userId = $request->input('user');
            $query->where(function ($q) use ($userId) {
                $q->where('sales_person_id', $userId)
                  ->orWhere('sales_manager_id', $userId)
                  ->orWhere('finance_manager_id', $userId);
            });
        }

        // team filter: match users by role name; include deals where any related user fields match
        if ($request->filled('team')) {
            $team = $request->input('team');
            $userIds = User::whereHas('roles', function ($q) use ($team) {
                $q->where('name', $team);
            })->pluck('id')->toArray();

            if (!empty($userIds)) {
                $query->where(function ($q) use ($userIds) {
                    $q->whereIn('sales_person_id', $userIds)
                      ->orWhereIn('sales_manager_id', $userIds)
                      ->orWhereIn('finance_manager_id', $userIds);
                });
            } else {
                // if no users found for team, return empty
                return Response::json(['items' => []]);
            }
        }

        // collect filter values for inventory matching and deal-level fallback filters
        $filterYear = $request->input('year');
        $filterMake = $request->input('make');
        $filterModel = $request->input('model');
        $filterYearFrom = $request->input('year_from');
        $filterYearTo = $request->input('year_to');
        $filterPriceMin = $request->input('price_min');
        $filterPriceMax = $request->input('price_max');
        // additional non-inventory filters that may be present in the UI
        $filterSalesStatus = $request->input('sales_status');
        $filterLeadType = $request->input('lead_type');
        $filterInventoryType = $request->input('inventory_type');
        $filterDealType = $request->input('deal_type');
        $filterSource = $request->input('source');

        // Apply these filters to the query where the corresponding columns exist on deals
        if ($filterSalesStatus && Schema::hasColumn('deals', 'status')) {
            $query->where('status', $filterSalesStatus);
        }
        if ($filterLeadType && Schema::hasColumn('deals', 'lead_type')) {
            $query->where('lead_type', $filterLeadType);
        }
        if ($filterInventoryType && Schema::hasColumn('deals', 'inventory_type')) {
            $query->where('inventory_type', $filterInventoryType);
        }
        if ($filterDealType && Schema::hasColumn('deals', 'deal_type')) {
            $query->where('deal_type', $filterDealType);
        }
        if ($filterSource && Schema::hasColumn('deals', 'source')) {
            $query->where('source', $filterSource);
        }

        // Deal-level fallbacks for inventory-like filters: match against vehicle_description or related customer's tradein fields
        if ($filterYear) {
            $query->where(function($q) use ($filterYear) {
                $q->where('vehicle_description', 'like', "%{$filterYear}%")
                  ->orWhereHas('customer', function($c) use ($filterYear) {
                      $c->where('tradein_year', $filterYear);
                  });
            });
        }
        if ($filterMake) {
            $query->where(function($q) use ($filterMake) {
                $q->where('vehicle_description', 'like', "%{$filterMake}%")
                  ->orWhereHas('customer', function($c) use ($filterMake) {
                      $c->where('tradein_make', 'like', "%{$filterMake}%");
                  });
            });
        }
        if ($filterModel) {
            $query->where(function($q) use ($filterModel) {
                $q->where('vehicle_description', 'like', "%{$filterModel}%")
                  ->orWhereHas('customer', function($c) use ($filterModel) {
                      $c->where('tradein_model', 'like', "%{$filterModel}%");
                  });
            });
        }

        // Year range: try customer tradein_year where available, otherwise match textual year in vehicle_description
        if ($filterYearFrom) {
            $query->where(function($q) use ($filterYearFrom) {
                $q->Where('vehicle_description', 'like', "%{$filterYearFrom}%")
                ->orWhereHas('customer', function($c) use ($filterYearFrom) {
                    $c->where('tradein_year', '>=', $filterYearFrom);
                });
            });
        }
        if ($filterYearTo) {
            $query->where(function($q) use ($filterYearTo) {
                $q->whereHas('customer', function($c) use ($filterYearTo) {
                    $c->where('tradein_year', '<=', $filterYearTo);
                })->orWhere('vehicle_description', 'like', "%{$filterYearTo}%");
            });
        }

        // Price filters: apply to deals.price if present, otherwise will be handled when matching inventory
        if ($filterPriceMin && Schema::hasColumn('deals', 'price')) {
            $query->where('price', '>=', $filterPriceMin);
        }
        if ($filterPriceMax && Schema::hasColumn('deals', 'price')) {
            $query->where('price', '<=', $filterPriceMax);
        }

        // Finally fetch deals after applying all deal-level filters
        $deals = $query->orderBy('updated_at', 'desc')->get();

        $items = $deals->map(function ($deal) use($filterYear, $filterMake, $filterModel, $filterYearFrom, $filterYearTo, $filterPriceMin, $filterPriceMax) {
            $desc = trim($deal->vehicle_description ?? '');

            // Basic matching heuristics against inventory
            $invQuery = Inventory::query();
            if ($desc !== '') {
                $invQuery->where(function ($q) use ($desc) {
                    if (strlen($desc) === 17) {
                        $q->where('vin', $desc);
                    }

                    $q->orWhere('stock_number', $desc)
                      ->orWhere('description', 'like', "%{$desc}%")
                      ->orWhereRaw("concat(year,' ',make,' ',model) like ?", ["%{$desc}%"]);
                });
            } else {
                // no vehicle description — try to match by customer's tradein_vin if present
                $tradeVin = $deal->customer?->tradein_vin ?? null;
                if ($tradeVin) {
                    $invQuery->where('vin', $tradeVin);
                }
            }

            // apply inventory filters if provided
            if ($filterYear) {
                $invQuery->where('year', $filterYear);
            }
            if ($filterMake) {
                $invQuery->where('make', 'like' ,"%{$filterMake}%");
            }
            if ($filterModel) {
                $invQuery->where('model', 'like' ,"%{$filterModel}%");
            }
            if ($filterYearFrom) {
                $invQuery->where('year', '>=', $filterYearFrom);
            }
            if ($filterYearTo) {
                $invQuery->where('year', '<=', $filterYearTo);
            }
            if ($filterPriceMin) {
                $invQuery->where('price', '>=', $filterPriceMin);
            }
            if ($filterPriceMax) {
                $invQuery->where('price', '<=', $filterPriceMax);
            }

            $matches = $invQuery->limit(10)->get();

            $matchLabel = 'No Match Yet';
            $link = url('/inventory');

            if ($matches->count() === 1) {
                $m = $matches->first();
                $matchLabel = sprintf('%s (%s)', trim("{$m->year} {$m->make} {$m->model}"), $m->stock_number ?? '');
                $link = url('/inventory?single=' . $m->id);
            } elseif ($matches->count() > 1) {
                $matchLabel = $matches->count() . ' Matches';
                $link = url('/inventory?search=' . urlencode($desc ?: ($deal->customer?->tradein_vin ?? '')));
            }

            // if inventory filters were provided and there are no matches, skip this deal
            $anyInventoryFilter = $filterMake || $filterModel || $filterYearFrom || $filterYearTo || $filterPriceMin || $filterPriceMax;
            if ($anyInventoryFilter && $matches->isEmpty()) {
                return null;
            }

            return [
                'id' => $deal->id,
                'customer_name' => $deal->customer?->full_name ?? 'Unknown',
                'work_list_name' => $deal->deal_number ?? ($deal->vehicle_description ?? 'Wishlist'),
                'list_updated' => $deal->updated_at?->toDateTimeString() ?? $deal->created_at?->toDateTimeString(),
                'list_matched' => $matchLabel,
                'inventory_link' => $link,
            ];
        })->values();

        return Response::json(['items' => $items]);
    }
}
