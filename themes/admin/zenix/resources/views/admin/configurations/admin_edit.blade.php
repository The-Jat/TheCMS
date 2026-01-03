{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
    <div class="row page-titles mx-0 mb-3">
        <div class="col-sm-6 p-0">
            <div class="welcome-text">
				<h4>{{ __('common.welcome_back_title') }}</h4>
				<p class="mb-0">{{ __('common.welcome_back_desc') }}</p>
		    </div>
        </div>
        <div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.configurations.admin_index') }}">{{ __('common.configurations') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.edit') }}</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('common.edit_configuration') }}</h4>
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
                        <form action="{{ route('admin.configurations.admin_edit', $configuration->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="setting" role="tabpanel">
                                    <div class="pt-4">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="ConfigurationName">{{ __('common.name') }}</label>
                                                <input type="text" name="Configuration[name]" id="ConfigurationName" class="form-control" maxlength="64" value="{{ old('Configuration[name]', $configuration->name) }}">
                                                <small>{{ __('common.config_title_description') }}</small>
                                                @error('Configuration.name')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="ConfigurationValue">{{ __('common.value') }}</label>
                                                <textarea name="Configuration[value]" id="ConfigurationValue" class="form-control" cols="30" rows="6">{{ old('Configuration[value]', $configuration->value) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="misc">
                                    <div class="pt-4">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="title">{{ __('common.title') }}</label>
                                                <input type="text" name="Configuration[title]" id="title" class="form-control" maxlength="255" value="{{ old('Configuration[title]', $configuration->title) }}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="ConfigurationInputType">{{ __('common.input_type') }}</label>
                                                <select name="Configuration[input_type]" id="ConfigurationInputType" class="form-control default-select">
                                                    <option value="">{{ __('common.select_input_type') }}</option>
                                                    <option value="text" {{ (old('Configuration[input_type]', $configuration->input_type) == 'text') ? 'selected="selected"':'' }}>{{ __('common.text') }}</option>
                                                    <option value="textarea" {{ (old('Configuration[input_type]', $configuration->input_type) == 'textarea') ? 'selected="selected"':'' }}>{{ __('common.textarea') }}</option>
                                                    <option value="file" {{ (old('Configuration[input_type]', $configuration->input_type) == 'file') ? 'selected="selected"':'' }}>{{ __('common.file') }}</option>
                                                    <option value="multiple_file" {{ (old('Configuration[input_type]', $configuration->input_type) == 'multiple_file') ? 'selected="selected"':'' }}>{{ __('common.multiple_file') }}</option>
                                                    <option value="checkbox" {{ (old('Configuration[input_type]', $configuration->input_type) == 'checkbox') ? 'selected="selected"':'' }}>{{ __('common.checkbox') }}</option>
                                                    <option value="multiple_checkbox" {{ (old('Configuration[input_type]', $configuration->input_type) == 'multiple_checkbox') ? 'selected="selected"':'' }}>{{ __('common.multiple_checkbox') }}</option>
                                                    <option value="radio" {{ (old('Configuration[input_type]', $configuration->input_type) == 'radio') ? 'selected="selected"':'' }}>{{ __('common.radio') }}</option>
                                                    <option value="button" {{ (old('Configuration[input_type]', $configuration->input_type) == 'button') ? 'selected="selected"':'' }}>{{ __('common.button') }}</option>
                                                    <option value="select" {{ (old('Configuration[input_type]', $configuration->input_type) == 'select') ? 'selected="selected"':'' }}>{{ __('common.select') }}</option>
                                                    <option value="date" {{ (old('Configuration[input_type]', $configuration->input_type) == 'date') ? 'selected="selected"':'' }}>{{ __('common.date') }}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="ConfigurationDescription">{{ __('common.description') }}</label>
                                                <textarea name="Configuration[description]" id="ConfigurationDescription" class="form-control">{{ old('Configuration[description]', $configuration->description) }}</textarea>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="ConfigurationParams">{{ __('common.params') }}</label>
                                                <textarea name="Configuration[params]" id="ConfigurationParams" class="form-control">{{ old('Configuration[params]', $configuration->params) }}</textarea>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="Configuration[editable]" id="ConfigurationEditable" class="custom-control-input form-check-input" {{ (old('Configuration[editable]', $configuration->editable) == 1) ? 'checked="checked"':'' }}>
                                                    <label class="custom-control-label form-check-label" for="ConfigurationEditable">{{ __('common.editable') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-primary">{{ __('common.save_configuration') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection