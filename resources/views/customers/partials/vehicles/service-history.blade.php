{{-- Service History Component - resources/views/customers/partials/vehicles/service-history.blade.php --}}

@props(['serviceHistory' => []])

<div class="table-responsive">
    <table class="table table-hover border mb-0">
        <thead class="table-light">
            <tr>
                <th class="text-nowrap">Date</th>
                <th class="text-nowrap">Service Type</th>
                <th>Description</th>
                <th class="text-nowrap">Mileage</th>
                <th class="text-nowrap">Cost</th>
                <th class="text-nowrap">Advisor</th>
            </tr>
        </thead>
        <tbody id="serviceHistoryBody">
            @forelse($serviceHistory as $record)
                <x-service-history-row :record="$record" />
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="ti ti-tools d-block mb-2" style="font-size:32px;"></i>
                        No service history available
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

