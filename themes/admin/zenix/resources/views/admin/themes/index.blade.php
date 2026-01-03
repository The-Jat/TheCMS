{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
	@if(request()->routeIs('themes.admin.index'))
    	<a href="{{ route('themes.admin.add_theme') }}" class="btn btn-primary mb-3">{{ __('common.add_theme') }}</a>
    @else
    	<a href="{{ route('themes.admin.add_admin_theme') }}" class="btn btn-primary mb-3">{{ __('common.add_theme') }}</a>
    @endif

	<div class="row mb-4">
		@forelse($themes as $key => $theme)
			<div class="col-md-6 col-sm-6 col-lg-4">
				<div class="card">
                    <div class="card-body p-1">
                        <div class="new-arrival-product">
                            <img class="img-fluid" src="{{ route('get_file', ['vendor' => $theme->getVendor(), 'theme' => $theme->getName(), 'file' => 'screenshot.png']) }}" alt="{{ ucfirst($theme->getName()).__('common.preview_image ') }}">
                        </div>
                    </div>
                    <div class="card-footer p-3 border-top d-flex align-items-center justify-content-between flex-column gap-3">
                    	<h5 class="m-0 text-capitalize">{{ $theme->getName() }}</h5>
                        <div class="d-flex justify-content-between gap-2 w-100">
                            <a href="javascript:void(0);" class="btn btn-xs btn-primary light w-100 ImportDemo @if ($theme->getName() != $currentTheme) disabled @endif" rel="{{ route('get_file', ['vendor' => $theme->getVendor(), 'theme' => $theme->getName(), 'file' => Str::lower($theme->getName()).'.xml']) }}">{{ __('common.import') }}</a>
                        	@if ($theme->getName() == $currentTheme)
                        		<a href="javascript:void(0);" class="btn btn-xs btn-info w-100">{{ __('common.activated') }}</a>
                        	@else
                        		<a href="{{ request()->routeIs('themes.admin.index') ? route('themes.admin.index', ['activate'=> $key]) : route('themes.admin.admin_themes', ['activate'=> $key]) }}" class="btn btn-xs btn-primary light w-100">{{ __('common.active') }}</a>
                                <a href="{{ route('themes.admin.delete', ['theme' => $theme->getName()]) }}" class="btn btn-xs btn-danger light w-100">{{ __('common.delete') }}</a>
                        	@endif
                        </div>
                	</div>
                </div>
			</div>
		@empty
		<div class="col-12">
			<div class="alert alert-primary text-center" role="alert">
			  	{{ __('common.themes_not_found') }}
			</div>
		</div>
		@endforelse
		
	</div>

</div>

@endsection


@push('inline-modals')
	<!--**********************************
        Theme Demo Data Import Model Start
    ***********************************-->
    <div class="modal fade" id="ImportDataForm">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('themes.admin.import_theme') }}" method="post">
                @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('common.import_demo_data') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                            <input type="hidden" name="db_file" id="DBFileUrl">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="import_type" value="draft" id="draft">
                                        <label class="form-check-label" for="draft">{{ __('common.draft_all_data_option') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="import_type" value="delete" id="delete">
                                        <label class="form-check-label" for="delete">{{ __('common.delete_all_data_option') }}</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="import_type" value="only_import" id="only_import" checked>
                                        <label class="form-check-label" for="only_import">{{ __('common.only_import_data_option') }}</label>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">{{ __('common.close') }}</button>
                        <button type="submit" class="btn btn-primary" id="importBtn">{{ __('common.import') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--**********************************
        Theme Demo Data Import Model End
    ***********************************-->
@endpush