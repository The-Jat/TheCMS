{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
    <div class="row page-titles mx-0 mb-3">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>{{ __('common.custom_fields') }}</h4>
                <span>{{ __('common.all_custom_feilds') }}</span>
            </div>
        </div>
        <div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('customfields.admin.index') }}">{{ __('common.custom_fields') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.all_custom_feilds') }}</a></li>
            </ol>
        </div>
    </div>

    @php
        $collapsed = 'collapsed';
        $show = '';
        $cpts = DzHelper::get_post_types()->pluck('title','slug');

    @endphp

    @if(!empty(request()->title) || !empty(request()->input_type) || !empty(request()->custom_field_type))
        @php
            $collapsed = '';
            $show = 'show';
        @endphp
    @endif

    <!-- row -->
    <!-- Row starts -->
    <div class="row">
        <!-- Column starts -->
        <div class="col-xl-12">
            <div class="card accordion accordion-rounded-stylish accordion-bordered" id="search-sec-outer">
                <div class="accordion-header rounded-lg {{ $collapsed }}" data-bs-toggle="collapse" data-bs-target="#rounded-search-sec">
                    <span class="accordion-header-icon"></span>
                    <h4 class="accordion-header-text m-0">{{ __('common.search_custom_fields') }}</h4>
                    <span class="accordion-header-indicator"></span>
                </div>
                <div class="card-body collapse accordion__body {{ $show }}" id="rounded-search-sec" data-bs-parent="#search-sec-outer">
                    <form action="{{ route('customfields.admin.index') }}" method="get">
                        <input type="hidden" name="todo" value="Filter">
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <input type="search" name="title" class="form-control" placeholder="{{ __('common.title') }}" value="{{ old('title', request()->input('title')) }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <select name="input_type" id="input_type" class="form-control">
                                    <option value="">{{ __('common.select_inputtype') }}</option>
                                    @foreach (config('constants.custom_field_input_types') as $elementKey => $elementVal)
                                        <option value="{{$elementKey}}" @selected(old('input_type', request()->input('input_type')) == $elementKey)>{{$elementVal}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <select name="custom_field_type" id="custom_field_type" class="form-control">
                                    <option value="">{{ __('common.select_modules') }}</option>
                                    <optgroup label="Admin">
                                        @foreach (config('constants.cf_settings') as $module)
                                        @foreach ($module as $key => $val)
                                        <option @selected(old('custom_field_type', request()->input('custom_field_type')) == $key) value="{{$key}}">{{$val}}</option>
                                            
                                        @endforeach
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Custom Post Types">
                                        @foreach ($cpts as $key => $val)
                                        <option @selected(old('custom_field_type', request()->input('custom_field_type')) == 'cpt_'.$key) value="{{'cpt_'.$key}}">{{$val}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <div class="mb-3 col-md-3 text-end">
                                <input type="submit" name="search" value="{{ __('common.search') }}" class="btn btn-primary me-2"> 
                                <a href="{{ route('customfields.admin.index') }}" class="btn btn-danger">{{ __('common.reset') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Column starts -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('common.custom_fields') }}</h4>
                    <div>
                        <a href="{{ route('customfields.admin.create') }}" class="btn btn-primary">{{ __('common.add_custom_field') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg mb-0">
                            <thead>
                                <tr>
                                    <th> <strong> {{ __('common.s_no') }} </strong> </th>
                                    <th> <strong> {{ __('common.field_title') }} </strong> </th>
                                    <th> <strong> {{ __('common.key') }} </strong> </th>
                                    <th> <strong> {{ __('common.field_type') }} </strong> </th>
                                    <th> <strong> {{ __('common.module_cpt') }} </strong> </th>
                                    <th> <strong> {{ __('common.editable_required') }} </strong> </th>
                                    <th class="text-center"> <strong> {{ __('common.actions') }} </strong> </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = $custom_fields->firstItem();
                                @endphp
                                @forelse ($custom_fields as $custom_field)
                                    <tr>
                                        <td> {{ $i++ }} </td>
                                        <td> {{ $custom_field->title }} </td>
                                        <td> {!! $custom_field->key !!} </td>
                                        <td> {!! $custom_field->input_type !!} </td>
                                        <td> {!! implode(', ', $custom_field->custom_field_types->pluck('custom_field_type')->toArray()) !!} </td>
                                        <td>
                                            @if ($custom_field->editable)
                                                <span class="badge badge-sm badge-success ">{{ __('common.editable') }}</span>
                                            @else
                                                <span class="badge badge-sm badge-danger ">{{ __('common.not_editable') }}</span>
                                            @endif

                                            @if ($custom_field->required)
                                                <span class="badge badge-sm badge-success ">{{ __('common.required') }}</span>
                                            @else
                                                <span class="badge badge-sm badge-danger ">{{ __('common.not_required') }}</span>
                                            @endif

                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('customfields.admin.edit', $custom_field->id) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="{{ route('customfields.admin.destroy', $custom_field->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td class="text-center" colspan="7"><p>{{ __('common.custom_fields_not_found') }}</p></td></tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {!! $custom_fields->onEachSide(1)->appends(request()->query())->links() !!}
                </div>
            </div>
        </div>
    </div>

</div>

@endsection