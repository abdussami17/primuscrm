{{-- Finance Option Card Component - resources/views/components/finance-option-card.blade.php --}}

@props([
    'type',
    'icon',
    'title',
    'description',
    'isSelected' => false
])

<div class="finance-payment-option-card {{ $isSelected ? 'finance-payment-selected' : '' }}" 
     data-bs-toggle="modal" 
     data-bs-target="#{{ $type }}Modal"
     role="button"
     tabindex="0">
     <div class="finance-payment-checkbox-wrapper">
        <div class="finance-payment-custom-checkbox">
          <i class="bi bi-check2"></i>
        </div>
      </div>
    <div class="finance-payment-card-inner-content">
        {{-- Icon --}}
        <div class="finance-payment-icon-circle-wrapper {{ $isSelected ? 'bg-primary text-white' : '' }}">
            <i class="bi bi-{{ $icon }}"></i>
        </div>
        
        {{-- Title --}}
        <h3 class="finance-payment-option-card-title ">
            {{ $title }}
        </h3>
        
        {{-- Description --}}
        <p class="finance-payment-option-card-description text-muted small mb-0">
            {{ $description }}
        </p>
        
        {{-- Slot for additional content --}}
        {{ $slot }}
        
        {{-- Selected indicator --}}
        @if($isSelected)
        <div class="mt-2">
            <span class="badge bg-primary">
                <i class="ti ti-check me-1"></i>Selected
            </span>
        </div>
        @endif
    </div>
</div>

<style>
/* .finance-payment-option-card.selected {
    border-color: var(--bs-primary) !important;
    background-color: rgba(var(--bs-primary-rgb), 0.05);
}
.finance-payment-option-card:focus {
    outline: 2px solid var(--bs-primary);
    outline-offset: 2px;
} */




.finance-payment-section-title {
      font-size: 1.35rem;
      font-weight: 600;
      color: #1a202c;
      margin-bottom: 0.75rem;
      letter-spacing: -0.3px;
    }
  
    .finance-payment-section-subtitle {
      color: #64748b;
      font-size: 0.9rem;
      margin-bottom: 1.75rem;
      font-weight: 400;
    }
  
    .finance-payment-options-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1rem;
      max-width: 900px;
      margin: 0 auto;
    }
  
    .finance-payment-option-card {
      position: relative;
      background: white;
      border-radius: 14px;
      padding: 1.5rem 1.25rem;
      cursor: pointer;
      transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
      border: 2px solid #e2e8f0;
      overflow: hidden;
    }
  
    .finance-payment-option-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: transparent;
      opacity: 0;
      transition: opacity 0.35s ease;
      z-index: 0;
    }
  
    .finance-payment-option-card:hover::before {
      opacity: 0.04;
    }
  
    .finance-payment-option-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
      border-color: var(--cf-primary);
    }
  
    .finance-payment-option-card.finance-payment-selected {
      border-color: var(--cf-primary);
      background: linear-gradient(to bottom, white, rgba(255, 255, 255, 0.95));
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    }
  
    .finance-payment-option-card.finance-payment-selected::before {
      opacity: 0.06;
    }
  
    .finance-payment-option-card:active {
      transform: translateY(-2px);
    }
  
    .finance-payment-card-inner-content {
      position: relative;
      z-index: 1;
    }
  
    .finance-payment-checkbox-wrapper {
      position: absolute;
      top: 12px;
      right: 12px;
      z-index: 2;
    }
  
    .finance-payment-custom-checkbox {
      width: 20px;
      height: 20px;
      border: 2px solid #cbd5e1;
      border-radius: 6px;
      background: white;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
    }
  
    .finance-payment-option-card.finance-payment-selected .finance-payment-custom-checkbox {
      background: var(--cf-primary);
      border-color: var(--cf-primary);
    }
  
    .finance-payment-custom-checkbox i {
      font-size: 12px;
      color: white;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
  
    .finance-payment-option-card.finance-payment-selected .finance-payment-custom-checkbox i {
      opacity: 1;
    }
  
    .finance-payment-icon-circle-wrapper {
      width: 56px;
      height: 56px;
      margin: 0 auto 1rem;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--cf-primary);
      transition: all 0.35s ease;
    }
  
    .finance-payment-option-card:hover .finance-payment-icon-circle-wrapper {
      transform: scale(1.08) rotate(3deg);
    }
  
    .finance-payment-option-card i.bi {
      font-size: 1.75rem;
      color: white;
    }
    .finance-payment-option-card i.bi-check2 {
      font-size: 16px;
      color: white;
    }
  
    .finance-payment-option-card-title {
      font-size: 1.05rem;
      font-weight: 600;
      color: #1a202c;
      margin-bottom: 0.35rem;
      text-align: center;
    }
  
    .finance-payment-option-card-description {
      font-size: 0.8rem !important;
      color: #64748b !important;
      margin-bottom: 0 !important;
      line-height: 1.4;
      text-align: center;
    }
  
    .finance-payment-option-card.finance-payment-type-finance {
      --finance-gradient-bg: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      --finance-border-accent: #667eea;
    }
  
    .finance-payment-option-card.finance-payment-type-lease {
      --finance-gradient-bg: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
      --finance-border-accent: #11998e;
    }
  
    .finance-payment-option-card.finance-payment-type-cash {
      --finance-gradient-bg: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
      --finance-border-accent: #f5576c;
    }
  
    @keyframes financePaymentFadeInUpAnimation {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  
    .finance-payment-option-card {
      animation: financePaymentFadeInUpAnimation 0.5s ease backwards;
    }
  
    .finance-payment-option-card:nth-child(1) {
      animation-delay: 0.05s;
    }
  
    .finance-payment-option-card:nth-child(2) {
      animation-delay: 0.1s;
    }
  
    .finance-payment-option-card:nth-child(3) {
      animation-delay: 0.15s;
    }
  
    @media (max-width: 992px) {
      .finance-payment-options-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
      }
  
      .finance-payment-option-card {
        padding: 1.25rem 1rem;
      }
  
      .finance-payment-icon-circle-wrapper {
        width: 48px;
        height: 48px;
      }
  
      .finance-payment-option-card i.bi {
        font-size: 1.5rem;
      }
    }
  
    @media (max-width: 768px) {
      .finance-payment-selector-container {
        padding: 1.5rem 1rem;
      }
  
      .finance-payment-options-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
      }
  
      .finance-payment-section-title {
        font-size: 1.2rem;
      }
    }
</style>