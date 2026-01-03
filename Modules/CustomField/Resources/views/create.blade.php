{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
	<div class="row page-titles mx-0 mb-3">
		<div class="col-sm-6 p-md-0">
			<div class="welcome-text">
				<h4>{{ __('common.custom_fields') }}</h4>
				<span>{{ __('common.add_custom_field') }}</span>
			</div>
		</div>
		<div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('customfields.admin.index') }}">{{ __('common.custom_fields') }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.add') }}</a></li>
			</ol>
		</div>
	</div>

	<form action="{{ route('customfields.admin.store') }}" method="POST" enctype="multipart/form-data">
		@csrf
		<div class="row">
			<div class="col-xl-8">
				<div class="row">
					<div class="col-xl-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">{{ __('common.add_custom_field') }}</h4>
							</div>
							<div class="card-body">
								<!-- Nav tabs -->
								<div class="default-tab">
									<ul class="nav nav-tabs" role="tablist">
										<li class="nav-item mr-2">
											<a class="nav-link active" data-bs-toggle="tab" href="#setting">{{ __('common.setting') }}</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-bs-toggle="tab" href="#misc">{{ __('common.misc') }}</a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane fade active show" id="setting" role="tabpanel">
											<div class="pt-4">
												<div class="row">
													<div class="col-md-12 form-group">
														<label for="key">{{ __('common.key') }}</label>
														<input type="text" name="key" id="key" class="form-control" maxlength="64" value="{{ old('key') }}">
														<small>{{ __('common.eg_test_field') }}</small>
														@error('key')
															<p class="text-danger">
																{{ $message }}
															</p>
														@enderror
													</div>
													<div class="col-md-12 form-group">
														<label for="value">{{ __('common.value') }}</label>
														<textarea name="value" id="value" class="form-control" cols="30" rows="6">{{ old('value') }}</textarea>
													</div>
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="misc">
											<div class="pt-4">
												<div class="row">
													<div class="col-md-6 form-group">
														<label for="title">{{ __('common.title') }}</label>
														<input type="text" name="title" id="title" class="form-control" maxlength="255" value="{{ old('title') }}">
														@error('title')<p class="text-danger">{{ $message }}</p>@enderror
													</div>
													<div class="col-md-6 form-group">
														<label for="input_type">{{ __('common.input_type') }}</label>
														<select name="input_type" id="input_type" class="form-control default-select">
															<option value="">{{ __('common.select_inputtype') }}</option>
															@foreach (config('constants.custom_field_input_types') as $elementKey => $elementVal)
																<option value="{{$elementKey}}" @selected(old('input_type') == $elementKey)>{{$elementVal}}</option>
															@endforeach
														</select>
														@error('input_type')
															<p class="text-danger">
																{{ $message }}
															</p>
														@enderror
													</div>
													<div class="col-md-6 form-group">
														<label for="description">{{ __('common.description') }}</label>
														<textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
													</div>
													<div class="col-md-6 form-group">
														<label for="params">{{ __('common.params') }}</label>
														<textarea name="params" id="params" class="form-control">{{ old('params') }}</textarea>
													</div>
													<div class="col-md-12 form-group">
														<label for="placeholder">{{ __('common.placeholder') }}</label>
														<input type="text" name="placeholder" id="placeholder" class="form-control" value="{{ old('placeholder') }}">
													</div>
													<div class="col-md-3 form-group">
														<div class="custom-control custom-checkbox">
															<input type="checkbox" name="editable" id="editable" class="custom-control-input" @checked(old('editable',1) == 1) value="1">
															<label class="custom-control-label" for="editable">{{ __('common.editable') }}</label>
														</div>
													</div>
													<div class="col-md-3 form-group">
														<div class="custom-control custom-checkbox">
															<input type="checkbox" name="required" id="required" class="custom-control-input" @checked(old('required') == 1) value="1">
															<label class="custom-control-label" for="required">{{ __('common.required') }}</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<button type="submit" class="btn btn-primary">{{ __('common.save') }}</button>
								<a href="{!! route('customfields.admin.index') !!}" class="btn btn-danger">{{ __('common.back') }}</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4">
				<div class="row">
					<div class="col-xl-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">{{ __('common.select_modules') }}</h4>
							</div>
							<div class="card-body">
								@forelse($cf_list as $cf_key => $cf_value)
									<b>{{ $cf_key }}</b>
									@forelse($cf_value as $cf_sub_key => $cf_sub_value)
										<div class="custom-control custom-checkbox mt-2">
											<input type="checkbox" name="custom_field_type[]" id="{{ $cf_sub_key }}" class="custom-control-input" value="{{ $cf_sub_key }}">
											<label class="custom-control-label" for="{{ $cf_sub_key }}">{{ $cf_sub_value }}</label>
										</div>
									@empty
									@endforelse
								@empty
								@endforelse
							</div>
						</div>
					</div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('common.select_cpt') }}</h4>
                            </div>
                            <div class="card-body">
                                @php
                                    $cpts = DzHelper::get_post_types()->pluck('title','slug');
                                @endphp
                                @forelse($cpts as $cf_key => $cf_value) 
                                    @php
                                        $cf_key = 'cpt_'.$cf_key;
                                    @endphp
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input type="checkbox" name="custom_field_type[]" id="{{ $cf_key }}" class="custom-control-input" value="{{ $cf_key }}">
                                        <label class="custom-control-label" for="{{ $cf_key }}">{{ $cf_value }}</label>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</form>

</div>

@endsection