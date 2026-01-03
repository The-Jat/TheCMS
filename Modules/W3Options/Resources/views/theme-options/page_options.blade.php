<div class="row">
    <div class="col-md-12">
        <div class="card dz-setting accordion accordion-rounded-stylish accordion-bordered  " id="acc-page-options">
            <div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#acc-page-option" aria-expanded="true">
                <h4 class="card-title">{{ __('common.page_options') }}</h4>
                <span class="accordion-header-indicator"></span>
            </div>
            <div class="accordion__body p-4 collapse show" id="acc-page-option" data-bs-parent="#acc-page-options">
            @php
                $options_type = 'page-options'; 
            @endphp
            @if (isset($sections) && !empty($sections))
                @include('w3options::elements.options', compact('sections','options_type','options_data'))
            @endif
            </div>
        </div>
    </div>
</div>