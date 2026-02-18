@forelse($customers as $customer)
<tr 
  data-full-name="{{ $customer->full_name }}"
  data-email="{{ $customer->email ?? '' }}"
  data-city="{{ $customer->city ?? '' }}"
  data-zip-code="{{ $customer->zip_code ?? '' }}"
  data-state="{{ $customer->state ?? '' }}"
  data-phone="{{ $customer->phone ?? '' }}"
  data-cell-phone="{{ $customer->cell_phone ?? '' }}"
  data-work-phone="{{ $customer->work_phone ?? '' }}"
  data-assigned-to="{{ $customer->assignedUser->name ?? '' }}"
  data-secondary-assigned-to="{{ $customer->secondaryAssignedUser->name ?? '' }}"
  data-assigned-manager="{{ $customer->assignedManagerUser->name ?? '' }}"
  data-bdc-agent="{{ $customer->bdcAgentUser->name ?? '' }}"
  data-lead-source="{{ $customer->lead_source ?? '' }}"
  data-lead-type="{{ $customer->lead_type ?? '' }}"
  data-status="{{ $customer->status ?? '' }}"
  data-interested-make="{{ $customer->interested_make ?? '' }}"
  data-dealership-franchises="{{ is_array($customer->dealership_franchises) ? implode(', ', $customer->dealership_franchises) : ($customer->dealership_franchises ?? '') }}"
  data-sales-status="{{ $customer->sales_status ?? '' }}"
  data-sales-type="{{ $customer->sales_type ?? '' }}"
  data-deal-type="{{ $customer->deal_type ?? '' }}"
  data-lead-status-type="{{ $customer->lead_status_type ?? '' }}"
  data-appointment-status="{{ $customer->appointment_status ?? '' }}"
  data-assigned-by="{{ $customer->assigned_by ?? '' }}"
  data-assigned-date="{{ $customer->assigned_date ? $customer->assigned_date->format('Y-m-d') : '' }}"
  data-sold-by="{{ $customer->sold_by ?? '' }}"
  data-created-date="{{ $customer->created_at ? $customer->created_at->format('Y-m-d') : '' }}"
  data-sold-date="{{ $customer->sold_date ? $customer->sold_date->format('Y-m-d') : '' }}"
  data-delivery-date="{{ $customer->delivery_date ? $customer->delivery_date->format('Y-m-d') : '' }}"
  data-appointment-date="{{ $customer->appointment_date ? $customer->appointment_date->format('Y-m-d') : '' }}"
  data-last-contacted-date="{{ $customer->last_contacted_at ? $customer->last_contacted_at->format('Y-m-d') : '' }}"
>
  <td style="padding: 0;padding-left: 5px;">
    <div class="form-check"><input class="form-check-input" type="checkbox"></div>
  </td>
  <td>
    <div class="name-cell">
      <a href="#" data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">{{ $customer->full_name }}</a>
      <span class="badge bg-primary">0</span>
      <i class="ti ti-caret-right-filled" onclick="showDealsModal('{{ $customer->full_name }}', 'customer-{{ $customer->id }}')"
        title="View Deals"></i>
    </div>
  </td>

  <td>{{ $customer->email ?? '-' }}</td>
  <td>{{ $customer->city ?? '-' }}</td>
  <td>{{ $customer->zip_code ?? '-' }}</td>
  <td>{{ $customer->state ?? '-' }}</td>
  <td>{{ $customer->phone ?? '-' }}</td>
  <td>{{ $customer->cell_phone ?? '-' }}</td>
  <td>{{ $customer->work_phone ?? '-' }}</td>
  <td>{{ $customer->assignedUser->name ?? '-' }}</td>
  <td>{{ $customer->secondaryAssignedUser->name ?? '-' }}</td>
  <td>{{ $customer->assignedManagerUser->name ?? '-' }}</td>
  <td>{{ $customer->bdcAgentUser->name ?? '-' }}</td>
  <td>{{ $customer->lead_source ?? '-' }}</td>
  <td>{{ $customer->lead_type ?? '-' }}</td>
  <td>{{ $customer->status ?? '-' }}</td>
  <td>0</td>
  <td>{{ $customer->interested_make ?? '-' }}</td>
  <td>{{ is_array($customer->dealership_franchises) ? implode(', ', $customer->dealership_franchises) : ($customer->dealership_franchises ?? '-') }}</td>
  <td>{{ $customer->sales_status ?? '-' }}</td>
  <td>{{ $customer->sales_type ?? '-' }}</td>
  <td>{{ $customer->deal_type ?? '-' }}</td>
  <td>{{ $customer->lead_status_type ?? '-' }}</td>
  <td>{{ $customer->appointment_status ?? '-' }}</td>
  <!-- New Data Columns -->
  <td>{{ $customer->assigned_by ?? '-' }}</td>
  <td>{{ $customer->assigned_date ? $customer->assigned_date->format('Y-m-d') : '-' }}</td>
  <td>{{ $customer->assignedUser->name ?? '-' }}</td>
  <td>{{ $customer->sold_by ?? '-' }}</td>
  <!-- End New Data Columns -->
  <td>
    @if($customer->status == 'Completed')
      <span class="badge bg-success">Completed</span>
    @elseif($customer->status == 'Pending')
      <span class="badge bg-warning text-dark">Pending</span>
    @elseif($customer->status == 'In Progress')
      <span class="badge bg-info">In Progress</span>
    @elseif($customer->status == 'Scheduled')
      <span class="badge bg-primary">Scheduled</span>
    @elseif($customer->status == 'No Show')
      <span class="badge bg-danger">No Show</span>
    @else
      <span class="badge bg-secondary">{{ $customer->status ?? 'New' }}</span>
    @endif
  </td>
  <td class="extra-columns-toggle">{{ $customer->created_at ? $customer->created_at->format('Y-m-d') : '-' }}</td>
  <td class="extra-columns-toggle">{{ $customer->sold_date ? $customer->sold_date->format('Y-m-d') : '-' }}</td>
  <td class="extra-columns-toggle">{{ $customer->delivery_date ? $customer->delivery_date->format('Y-m-d') : '-' }}</td>
  <td class="extra-columns-toggle">{{ $customer->appointment_date ? $customer->appointment_date->format('Y-m-d') : '-' }}</td>
  <td class="extra-columns-toggle">{{ $customer->last_contacted_at ? $customer->last_contacted_at->format('Y-m-d') : '-' }}</td>
  <td>
    <div class="dropdown dropdown-action">
      <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
      <div class="dropdown-menu dropdown-menu-end">
        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_modal"><i class="far fa-edit me-2"></i>Edit</a>
        <a class="dropdown-item delete-customer" href="#" data-id="{{ $customer->id }}"><i class="far fa-trash-alt me-2"></i>Delete</a>
        <a class="dropdown-item" href="#"><i class="far fa-eye me-2"></i>View Details</a>
      </div>
    </div>
  </td>
</tr>
@empty
<tr>
  <td colspan="35" class="text-center py-4">No customers found for the selected date range</td>
</tr>
@endforelse
