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
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.all_configurations') }}</a></li>
            </ol>
        </div>
    </div>
    @php
        $collapsed = 'collapsed';
        $show = '';
    @endphp

    @if(!empty(request()->title) || !empty(request()->name))
        @php
            $collapsed = '';
            $show = 'show';
        @endphp
    @endif

    <div class="row">
        <!-- Column starts -->
        <div class="col-xl-12">
            <div class="card accordion accordion-rounded-stylish accordion-bordered" id="search-sec-outer">
                <div class="accordion-header rounded-lg {{ $collapsed }}" data-bs-toggle="collapse" data-bs-target="#rounded-search-sec">
                    <span class="accordion-header-icon"></span>
                    <h4 class="accordion-header-text m-0">{{ __('common.search') }} {{ __('common.configurations') }}</h4>
                    <span class="accordion-header-indicator"></span>
                </div>
                <div class="card-body collapse accordion__body {{ $show }}" id="rounded-search-sec" data-bs-parent="#search-sec-outer">
                    <form action="{{ route('admin.configurations.admin_index') }}" method="get">
                    @csrf
                        <input type="hidden" name="todo" value="Filter">
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <input type="search" name="title" class="form-control" placeholder="{{ __('common.title') }}" value="{{ old('title', request()->input('title')) }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <input type="search" name="name" class="form-control" placeholder="{{ __('common.name') }}" value="{{ old('name', request()->input('name')) }}">
                            </div>
                            <div class="mb-3 col-md-6 text-end">
                                <input type="submit" name="search" value="{{ __('common.search') }}" class="btn btn-primary me-2"> 
                                <a href="{{ route('admin.configurations.admin_index') }}" class="btn btn-danger">{{ __('common.reset') }}</a>
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
                    <h4 class="card-title">{{ __('common.configurations') }}</h4>
                    <a href="{{ route('admin.configurations.admin_add') }}" class="btn btn-primary">{{ __('common.add_configuration') }}</a>
                </div>
                <div class="pe-4 ps-4 pt-2 pb-2">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg mb-0">
                            <thead>
                                <tr>
                                    <th> <strong> {{ __('common.name') }} </strong> </th>
                                    <th> <strong> {{ __('common.value') }} </strong> </th>
                                    <th class="text-center" width="150px"> <strong> {{ __('common.actions') }} </strong> </th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @forelse ($configurations as $configuration)
                                    <tr>
                                        <td> {{ $configuration->name }} </td>
                                        <td> {!! $configuration->value !!} </td>
                                        <td width="150px">
                                            <a href="{{ route('admin.configurations.admin_moveup', $configuration->id) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
                                            <a href="{{ route('admin.configurations.admin_movedown', $configuration->id) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                                            <a href="{{ route('admin.configurations.admin_edit', $configuration->id) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="{{ route('admin.configurations.admin_delete', $configuration->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <p>{{ __('common.configurations_not_found') }}</p>
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $configurations->links() }}
                </div>
            </div>
        </div>
    </div>

</div>

@endsection