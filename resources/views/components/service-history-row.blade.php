{{-- Service History Row Component - resources/views/components/service-history-row.blade.php --}}

@props(['record'])

<tr>
    <td class="text-nowrap">
        {{ \Carbon\Carbon::parse($record->service_date)->format('M d, Y') }}
    </td>
    <td>
        <span class="badge bg-light text-dark">
            {{ $record->service_type }}
        </span>
    </td>
    <td>
        <span class="text-truncate d-inline-block" style="max-width:200px;" title="{{ $record->description }}">
            {{ $record->description }}
        </span>
    </td>
    <td class="text-nowrap">
        {{ number_format($record->mileage ?? 0) }} mi
    </td>
    <td class="text-nowrap text-success fw-bold">
        ${{ number_format($record->cost ?? 0, 2) }}
    </td>
    <td>
        {{ $record->advisor_name ?? '--' }}
    </td>
   
</tr>