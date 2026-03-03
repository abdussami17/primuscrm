<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Deal;
use App\Models\DealershipInfo;
use App\Models\SequenceCriteria;
use App\Models\SequenceCriteriaGroup;
use App\Models\SmartSequence;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SmartSequenceCriteriaEvaluator
{
    /**
     * Map of criteria field names to their corresponding database column or relationship path.
     */
    protected static array $fieldMapping = [
        // Customer direct fields
        'firstname'          => 'customers.first_name',
        'middlename'         => 'customers.middle_name',
        'lastname'           => 'customers.last_name',
        'customername'       => null, // computed: first_name + last_name
        'email'              => 'customers.email',
        'alternateemail'     => null, // from customer_emails relation
        'cellphone'          => 'customers.cell_phone',
        'workphone'          => 'customers.work_phone',
        'homephone'          => 'customers.phone',
        'address'            => 'customers.address',
        'streetaddress'      => 'customers.address',
        'city'               => 'customers.city',
        'province'           => 'customers.state',
        'postalcode'         => 'customers.zip_code',
        'country'            => 'customers.country',
        'notes'              => 'customers.notes',
        'language'           => 'customers.preferences->language',
        'businessname'       => 'customers.preferences->business_name',
        'consent'            => 'customers.consent_marketing',
        'optout'             => 'customers.consent_marketing', // inverse

        // Customer user-type fields  
        'assignedto'         => 'customers.assigned_to',
        'assignedmanager'    => 'customers.assigned_manager',
        'secondaryassigned'  => 'customers.secondary_assigned',
        'bdcagent'           => 'customers.bdc_agent',
        'financemanager'     => 'customers.finance_manager',

        // Customer interest / trade-in
        'make'               => 'customers.interested_make',
        'model'              => 'customers.interested_model',
        'year'               => 'customers.interested_year',
        'tradeinyear'        => 'customers.tradein_year',
        'tradeinsellingprice' => 'customers.tradein_value',

        // Customer dates
        'createddate'        => 'customers.created_at',
        'lastcontacteddate'  => 'customers.last_contacted_at',
        'updated'            => 'customers.updated_at',
        'birthday'           => 'customers.preferences->birthday',

        // Customer dropdown / status fields
        'leadsource'         => 'customers.lead_source',
        'leadstatus'         => 'customers.status',
        'inventorytype'      => 'customers.inventory_type',
        'source'             => 'customers.lead_source',

        // Deal-level fields (via most recent deal)
        'salestatus'         => 'deals.sales_status',
        'dealtype'           => 'deals.deal_type',
        'salestype'          => 'deals.source',
        'leadtype'           => 'deals.lead_type',
        'sellingprice'       => 'deals.price',
        'solddate'           => 'deals.sold_date',
        'deliverydate'       => 'deals.delivery_date',
        'statustype'         => 'deals.status',

        // Inventory fields  
        'vin'                => 'inventories.vin',
        'stocknumber'        => 'inventories.stock_number',
        'odometer'           => 'inventories.odometer',
        'bodystyle'          => 'inventories.body_style',
        'exteriorcolor'      => 'inventories.exterior_color',
        'interiorcolor'      => 'inventories.interior_color',
        'fueltype'           => 'inventories.fuel_type',
        'engine'             => 'inventories.engine',
        'drivetype'          => 'inventories.drive_type',
        'doors'              => 'inventories.doors',
        'transmission'       => 'inventories.transmission',
        'franchise'          => 'inventories.franchise',
        'lotlocation'        => 'inventories.lot_location',
        'saleprice'          => 'inventories.sale_price',
        'internetprice'      => 'inventories.internet_price',
        'trim'               => 'inventories.trim',

        // Task fields
        'tasktype'           => 'tasks.task_type',
        'taskduedate'        => 'tasks.due_date',
        'priority'           => 'tasks.priority',
    ];

    /**
     * Fields that come from the deals table.
     */
    protected static array $dealFields = [
        'salestatus', 'dealtype', 'salestype', 'leadtype', 'sellingprice',
        'solddate', 'deliverydate', 'statustype',
    ];

    /**
     * Fields that come from inventory (via deal)
     */
    protected static array $inventoryFields = [
        'vin', 'stocknumber', 'odometer', 'bodystyle', 'exteriorcolor',
        'interiorcolor', 'fueltype', 'engine', 'drivetype', 'doors',
        'transmission', 'franchise', 'lotlocation', 'saleprice', 'internetprice', 'trim',
    ];

    /**
     * Fields that come from tasks  
     */
    protected static array $taskFields = [
        'tasktype', 'taskduedate', 'priority',
    ];

    /**
     * Get all customers matching a smart sequence's criteria groups.
     */
    public function getMatchingCustomers(SmartSequence $sequence): Collection
    {
        $sequence->loadMissing(['criteriaGroups.criteria']);

        $groups = $sequence->criteriaGroups;

        if ($groups->isEmpty()) {
            return collect();
        }

        // Build a query that evaluates all criteria groups
        // AND groups must ALL match, OR groups need at least one to match
        $query = Customer::query()
            ->whereNull('customers.deleted_at');

        // Determine if we need joins
        $needsDeals = false;
        $needsInventory = false;
        $needsTasks = false;

        foreach ($groups as $group) {
            foreach ($group->criteria as $criterion) {
                if (in_array($criterion->field_name, self::$dealFields)) {
                    $needsDeals = true;
                }
                if (in_array($criterion->field_name, self::$inventoryFields)) {
                    $needsDeals = true;
                    $needsInventory = true;
                }
                if (in_array($criterion->field_name, self::$taskFields)) {
                    $needsTasks = true;
                }
            }
        }

        // Add required joins
        if ($needsDeals) {
            $query->leftJoin('deals', function ($join) {
                $join->on('customers.id', '=', 'deals.customer_id')
                    ->whereNull('deals.deleted_at');
            });
        }

        if ($needsInventory) {
            $query->leftJoin('inventories', 'deals.inventory_id', '=', 'inventories.id');
        }

        if ($needsTasks) {
            $query->leftJoin('tasks', function ($join) {
                $join->on('customers.id', '=', 'tasks.customer_id')
                    ->whereNull('tasks.deleted_at');
            });
        }

        $query->select('customers.*');

        // Separate AND and OR groups
        $andGroups = $groups->where('logic_type', 'AND');
        $orGroups = $groups->where('logic_type', 'OR');

        // Apply AND groups (each must match)
        foreach ($andGroups as $group) {
            $query->where(function (Builder $q) use ($group) {
                $this->applyGroupCriteria($q, $group);
            });
        }

        // Apply OR groups (at least one must match)
        if ($orGroups->isNotEmpty()) {
            $query->where(function (Builder $q) use ($orGroups) {
                foreach ($orGroups as $group) {
                    $q->orWhere(function (Builder $subQ) use ($group) {
                        $this->applyGroupCriteria($subQ, $group);
                    });
                }
            });
        }

        // Deduplicate customers if joins caused multiples
        $query->distinct();

        return $query->get();
    }

    /**
     * Apply all criteria within a group to the query.
     * Within a group, all criteria are joined by AND.
     */
    protected function applyGroupCriteria(Builder $query, SequenceCriteriaGroup $group): void
    {
        foreach ($group->criteria as $criterion) {
            $this->applyCriterion($query, $criterion);
        }
    }

    /**
     * Apply a single criterion to the query.
     */
    protected function applyCriterion(Builder $query, SequenceCriteria $criterion): void
    {
        $fieldName = $criterion->field_name;
        $operator = $criterion->operator;
        $values = $criterion->values ?? [];

        // Get the database column for this field
        $column = $this->resolveColumn($fieldName);

        if ($column === null) {
            // Handle computed fields
            $this->applyComputedCriterion($query, $fieldName, $operator, $values);
            return;
        }

        switch ($operator) {
            case SequenceCriteria::OP_IS:
                if (count($values) === 1) {
                    $query->where($column, '=', $values[0]);
                } elseif (count($values) > 1) {
                    $query->whereIn($column, $values);
                }
                break;

            case SequenceCriteria::OP_IS_NOT:
                if (count($values) === 1) {
                    $query->where($column, '!=', $values[0]);
                } elseif (count($values) > 1) {
                    $query->whereNotIn($column, $values);
                }
                break;

            case SequenceCriteria::OP_IS_BETWEEN:
                if (count($values) >= 2) {
                    $query->whereBetween($column, [$values[0], $values[1]]);
                }
                break;

            case SequenceCriteria::OP_IS_NOT_BETWEEN:
                if (count($values) >= 2) {
                    $query->whereNotBetween($column, [$values[0], $values[1]]);
                }
                break;

            case SequenceCriteria::OP_IS_GREATER_EQUAL:
                if (!empty($values[0])) {
                    $query->where($column, '>=', $values[0]);
                }
                break;

            case SequenceCriteria::OP_IS_LESS_EQUAL:
                if (!empty($values[0])) {
                    $query->where($column, '<=', $values[0]);
                }
                break;

            case SequenceCriteria::OP_IS_BLANK:
                $query->where(function (Builder $q) use ($column) {
                    $q->whereNull($column)->orWhere($column, '=', '');
                });
                break;

            case SequenceCriteria::OP_IS_NOT_BLANK:
                $query->where(function (Builder $q) use ($column) {
                    $q->whereNotNull($column)->where($column, '!=', '');
                });
                break;

            case SequenceCriteria::OP_IS_WITHIN_LAST:
                $this->applyWithinLast($query, $column, $values, false);
                break;

            case SequenceCriteria::OP_IS_NOT_WITHIN_LAST:
                $this->applyWithinLast($query, $column, $values, true);
                break;
        }
    }

    /**
     * Apply a "within the last" time-based criterion.
     * Values expected: [amount, unit] e.g. [30, 'days']
     */
    protected function applyWithinLast(Builder $query, string $column, array $values, bool $negate): void
    {
        if (count($values) < 2) {
            return;
        }

        $amount = (int) $values[0];
        $unit = $values[1] ?? 'days';

        $date = match ($unit) {
            'minutes' => Carbon::now()->subMinutes($amount),
            'hours'   => Carbon::now()->subHours($amount),
            'days'    => Carbon::now()->subDays($amount),
            'months'  => Carbon::now()->subMonths($amount),
            'years'   => Carbon::now()->subYears($amount),
            default   => Carbon::now()->subDays($amount),
        };

        if ($negate) {
            // is NOT within the last X → date is before the threshold (or null)
            $query->where(function (Builder $q) use ($column, $date) {
                $q->whereNull($column)
                    ->orWhere($column, '<', $date);
            });
        } else {
            // is within the last X → date >= threshold
            $query->where($column, '>=', $date);
        }
    }

    /**
     * Handle computed fields like "customername" that don't map to a single column.
     */
    protected function applyComputedCriterion(Builder $query, string $fieldName, string $operator, array $values): void
    {
        switch ($fieldName) {
            case 'customername':
                $this->applyCustomerNameCriterion($query, $operator, $values);
                break;

            case 'alternateemail':
                $this->applyAlternateEmailCriterion($query, $operator, $values);
                break;

            case 'cobuyer':
                $this->applyCoBuyerCriterion($query, $operator, $values);
                break;

            default:
                Log::warning("SmartSequence: unhandled computed field '{$fieldName}'");
                break;
        }
    }

    /**
     * Apply customer name (concatenated first + last name) criterion.
     */
    protected function applyCustomerNameCriterion(Builder $query, string $operator, array $values): void
    {
        $concat = DB::raw("CONCAT(customers.first_name, ' ', customers.last_name)");

        switch ($operator) {
            case SequenceCriteria::OP_IS:
                $query->whereRaw("CONCAT(customers.first_name, ' ', customers.last_name) = ?", [$values[0] ?? '']);
                break;
            case SequenceCriteria::OP_IS_NOT:
                $query->whereRaw("CONCAT(customers.first_name, ' ', customers.last_name) != ?", [$values[0] ?? '']);
                break;
            case SequenceCriteria::OP_IS_BLANK:
                $query->where(function ($q) {
                    $q->whereNull('customers.first_name')->whereNull('customers.last_name');
                });
                break;
            case SequenceCriteria::OP_IS_NOT_BLANK:
                $query->where(function ($q) {
                    $q->whereNotNull('customers.first_name')->orWhereNotNull('customers.last_name');
                });
                break;
        }
    }

    /**
     * Apply alternate email criterion (via customer_emails table).
     */
    protected function applyAlternateEmailCriterion(Builder $query, string $operator, array $values): void
    {
        switch ($operator) {
            case SequenceCriteria::OP_IS:
                $query->whereHas('emails', function ($q) use ($values) {
                    $q->where('is_default', false)->whereIn('email', $values);
                });
                break;
            case SequenceCriteria::OP_IS_BLANK:
                $query->whereDoesntHave('emails', function ($q) {
                    $q->where('is_default', false);
                });
                break;
            case SequenceCriteria::OP_IS_NOT_BLANK:
                $query->whereHas('emails', function ($q) {
                    $q->where('is_default', false);
                });
                break;
        }
    }

    /**
     * Apply co-buyer criterion.
     */
    protected function applyCoBuyerCriterion(Builder $query, string $operator, array $values): void
    {
        switch ($operator) {
            case SequenceCriteria::OP_IS_BLANK:
                $query->whereDoesntHave('coBuyer');
                break;
            case SequenceCriteria::OP_IS_NOT_BLANK:
                $query->whereHas('coBuyer');
                break;
        }
    }

    /**
     * Resolve a criteria field name to its database column.
     */
    protected function resolveColumn(string $fieldName): ?string
    {
        // Check for user fields that need role resolution
        if ($this->isUserField($fieldName)) {
            return self::$fieldMapping[$fieldName] ?? null;
        }

        return self::$fieldMapping[$fieldName] ?? null;
    }

    /**
     * Check if a field is a user-type field.
     */
    protected function isUserField(string $fieldName): bool
    {
        $userFields = [
            'createdby', 'assignedby', 'assignedto', 'assignedmanager', 'bdcagent', 'bdcmanager',
            'financemanager', 'generalmanger', 'inventorymanager', 'salesmanager', 'secondaryassigned',
            'serviceadvisor', 'updatedby'
        ];

        return in_array($fieldName, $userFields);
    }
}
