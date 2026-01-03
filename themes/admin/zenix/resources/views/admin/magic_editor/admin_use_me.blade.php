<div class="modal-header d-block">
	<div class="d-flex justify-content-between  mb-3">
		<h4 class="modal-title">{{ __('Editor Elements') }}</h4>
		<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
	</div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs mt-3" role="tablist">
        @php
            $currentTheme = config('Theme.select_theme') ? explode("/",config('Theme.select_theme'))[1] : '' ;
        @endphp
        <li class="active"><a href="javascript:void(0);" class="ME-ElementFilter ME-Tabs nav-link" data-element-filter="all">{{ __('All') }}</a></li>
        @foreach ($allElementsCategories as $key => $value)
            <li><a href="javascript:void(0);" class="ME-ElementFilter ME-Tabs nav-link" data-element-filter="{{ $value }}">{{ $value }}</a>
            </li>
        @endforeach
    </ul>
</div>
<div class="modal-body elements-body">
   <ul class="editor-element-list ME-ElementList row">
        @forelse($allElements as $elementKey => $element)
        	
            <li class="col-lg-2 col-sm-4 ME-Show p-0 {{ $element['category'] }}">
                <a href="javascript:void(0);" class="ME-AddElement" data-element-type="{{request()->type ?? 'page'}}" data-element="{{ $element['base'] }}" data-element-image="{{ $element['icon'] }}" data-element-name="{{ $element['name'] }}">
                    <div class="icon-bx-wraper text-center style-2 m-b30">
                        <div class="icon-lg position-relative"> 
                            <img class="el-img border" src="{{ $element['icon'] }}" alt="{{ __('Image') }}">

                            <div class="zoom-img-container rounded"></div>
                        </div>
                        <div class="icon-content">
                            <h4 class="dz-title m-b15">
                                {{ $element['name'] }}
                            </h4>
                        </div>
                    </div>
                </a>
            </li>
        @empty    
			<li>{{ __('Elements not found') }}</li>
        @endforelse
        
    </ul>
</div>