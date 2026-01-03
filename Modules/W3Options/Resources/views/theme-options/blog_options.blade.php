<div class="row">
	<div class="col-md-12">
		<div class="card dz-setting accordion accordion-rounded-stylish accordion-bordered  " id="acc-blog-options">
            <div class="card-header justify-content-start accordion-header" data-bs-toggle="collapse" data-bs-target="#acc-blog-option" aria-expanded="true">
                <h4 class="card-title">{{ __('common.blog_options') }}</h4>
                <span class="accordion-header-indicator"></span>
            </div>
            <div class="accordion__body p-4 collapse show" id="acc-blog-option" data-bs-parent="#acc-blog-options">
            @php
                $options_type = 'blog-options'; 
            @endphp
            @if (isset($sections) && !empty($sections))
                @include('w3options::elements.options', compact('sections','options_type','options_data'))
            @endif
            </div>
        </div>
	</div>
</div>