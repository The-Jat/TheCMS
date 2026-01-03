{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">

	<div class="row page-titles mx-0 ">
        <div class="col-sm-6 p-0">
            <div class="welcome-text">
				<h4>{{ __('common.welcome_back_title') }}</h4>
				<p class="mb-0">{{ __('common.welcome_back_desc') }}</p>
		    </div>
        </div>
        <div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.widgets.index') }}">{{ __('common.widgets') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.edit_widget') }}</a></li>
            </ol>
        </div>
    </div>

	<form action="{{ route('admin.widgets.update',$widget->id) }}" method="post" enctype="multipart/form-data">
		@csrf
		<div class="row">
			<div class="col-xl-6">
				<div class="card">
					<div class="card-header d-flex justify-content-between">
						<h4 class="card-title">{{ __('common.edit_widget') }}</h4>
						<div>
							<a href="{{ route('admin.widgets.destroy',$widget->id) }}" class="btn btn-danger">{{ __('common.delete') }}</a>
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="form-group col-md-12">
								<label for="ContentTitle">{{ __('common.title') }}</label>
                        		<input type="hidden" name="slug" class="form-control" id="slug" value="{{ old('slug',$widget->slug) }}" readonly>
								<input type="text" name="title" class="form-control MakeSlug" id="ContentTitle" placeholder="{{ __('common.title') }}" value="{{ old('title',$widget->title) }}" rel="slug">
								@error('title')
				                    <p class="text-danger">
				                        {{ $message }}
				                    </p>
				                @enderror
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-6">
				<div class="form-group col-md-12 ">
					<div class="in-box ClassicEditorBox d-none">
						<textarea name="content" class="form-control W3cmsCkeditor h-auto" id="PageContent" rows="10">{!! old('content',$widget->content) !!}</textarea>
					</div>

					<div class="in-box MagicEditorBox ">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">{{ __('common.magic_editor') }}</h4>
									 
								<a href="{{ route('admin.use.me',['type'=>'widgets']) }}" data-bs-toggle="modal" data-bs-target="#AddElement" class=" btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
							</div>
							<div class="card-body table-responsive">
								<div class="form-group" id="MagicEditorElementContainer">
									@if(!empty($widget->content) && HelpDesk::shortcodeToHtml($widget->content,'widgets'))
										{!! HelpDesk::shortcodeToHtml($widget->content,'widgets') !!}
									@else
										<a href="{{ route('admin.use.me',['type'=>'widgets']) }}" data-bs-toggle="modal" data-bs-target="#AddElement" class="btn btn-primary btn-sm me-add-element-btn"> {{ __('common.add_element') }}</a>
									@endif	
								</div>

								@error('content')
				                    <p class="text-danger">
				                        {{ $message }}
				                    </p>
				                @enderror
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</form>
</div>
@endsection

@push('inline-modals')
	<div class="modal fade" id="AddElement">
	    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
	        <div class="modal-content">
				<span>&nbsp;&nbsp;Loading... </span>
	        </div>	
	    </div>	
	</div>
@endpush

@push('inline-scripts')
	<script>
		'use strict';
		var screenOptionArray = '<?php echo json_encode(array()) ?>';
	</script>
@endpush
