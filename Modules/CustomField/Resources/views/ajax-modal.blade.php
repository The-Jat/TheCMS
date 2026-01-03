<form action="{{ route('customfields.admin.ajax_modal',request()->field_type) }}" id="AddCustomFeildForm" method="POST" enctype="multipart/form-data">
@csrf
<input type="hidden" name="custom_field_type" value="{{request()->field_type}}">
	<div class="card m-0">
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
									<span class="key-error text-danger error"></span>
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
									<span class="title-error text-danger error"></span>
								</div>
								<div class="col-md-6 form-group">
									<label for="customFieldInputTypeSelect">{{ __('common.input_type') }}</label>
									<select name="input_type" id="customFieldInputTypeSelect" class="form-control default-select" >
										<option value="">{{ __('common.select_inputtype') }}</option>
										@foreach (config('constants.custom_field_input_types') as $elementKey => $elementVal)
											<option value="{{$elementKey}}" @selected(old('input_type') == $elementKey)>{{$elementVal}}</option>
										@endforeach
									</select>
									<span class="input_type-error text-danger error"></span>
								</div>
								
								<div id="CustomFieldFormSubPart" class="col-12" >
									<div class="row">
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

								<fieldset disabled class="d-none">
									<div id="GroupFieldTemplate" class="row groupFieldItems border-bottom mb-3 mx-0" >
										<div class="col-12 text-end ">
											<button class="btn btn-link p-0" id="RemoveGroupFields">X Remove</button>
										</div>
										<div class="col-md-6 form-group">
											<label for="key">{{ __('common.key') }}</label>
											<input type="text" name="group[%key%][key]" id="key" class="form-control" required maxlength="64" value="{{ old('key') }}">
											<small>{{ __('common.eg_test_field') }}</small>
										</div>
										<div class="col-md-6 form-group">
											<label for="value">{{ __('common.value') }}</label>
											<textarea name="group[%key%][value]" id="value" class="form-control" cols="30" rows="2"></textarea>
										</div>
										<div class="col-md-6 form-group">
											<label for="title">{{ __('common.title') }}</label>
											<input type="text" name="group[%key%][title]" id="title" required class="form-control" maxlength="255">
										</div>
										<div class="col-md-6 form-group">
											<label for="input_type">{{ __('common.input_type') }}</label>
											<select name="group[%key%][input_type]" id="input_type" class="form-control" required>
												<option value="">{{ __('common.select_inputtype') }}</option>
												@foreach (config('constants.custom_field_input_types') as $elementKey => $elementVal)
													<option value="{{$elementKey}}">{{$elementVal}}</option>
												@endforeach
											</select>
										</div>
										<div class="col-md-6 form-group">
											<label for="description">{{ __('common.description') }}</label>
											<textarea name="group[%key%][description]" id="description" class="form-control"></textarea>
										</div>
										<div class="col-md-6 form-group">
											<label for="params">{{ __('common.params') }}</label>
											<textarea name="group[%key%][params]" id="params" class="form-control"></textarea>
										</div>
										<div class="col-md-12 form-group">
											<label for="placeholder">{{ __('common.placeholder') }}</label>
											<input type="text" name="group[%key%][placeholder]" id="placeholder" class="form-control">
										</div>
										<div class="col-md-3 form-group">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" name="group[%key%][editable]" id="editable" class="custom-control-input" value="1">
												<label class="custom-control-label" for="editable">{{ __('common.editable') }}</label>
											</div>
										</div>
										<div class="col-md-3 form-group">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" name="group[%key%][required]" id="required" class="custom-control-input" value="1">
												<label class="custom-control-label" for="required">{{ __('common.required') }}</label>
											</div>
										</div>
									</div>
								</fieldset>
								
								<fieldset id="GroupFieldsContainer" style="display:none;">
									<button class="btn btn-link" id="AddMoreGropedFields">Add More</button>
								</fieldset>
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
</form>