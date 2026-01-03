{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
    <div class="row page-titles mx-0 mb-3">
        <div class="col-sm-6 p-0">
            <div class="welcome-text">
                <h4>{{ __('w3cpt::common.W3Cpts') }}</h4>
                <span>{{ __('w3cpt::common.add_cpt') }}</span>
            </div>
        </div>
        <div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('cpt.admin.index') }}">{{ __('w3cpt::common.W3Cpts') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('w3cpt::common.add_cpt') }}</a></li>
            </ol>
        </div>
    </div>

    @php
        $collapsed = 'collapsed';
        $show = '';
    @endphp

    @if(!empty(request()->all()))
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
                    <h4 class="accordion-header-text m-0">{{ __('w3cpt::common.search_cpt') }}</h4>
                    <span class="accordion-header-indicator"></span>
                </div>
                <div class="card-body collapse accordion__body {{ $show }}" id="rounded-search-sec" data-bs-parent="#search-sec-outer">
                    <form action="{{ route('cpt.admin.index') }}" method="get">
                    @csrf
                        <input type="hidden" name="todo" value="Filter">
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <input type="text" name="title" class="form-control" placeholder="{{ __('w3cpt::common.title') }}" value="{{ old('title', request()->input('title')) }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <input type="text" name="from" class="form-control datetimepicker" placeholder="{{ __('w3cpt::common.from_created') }}" value="{{ old('from', request()->input('from')) }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <input type="text" name="to" class="form-control datetimepicker" placeholder="{{ __('w3cpt::common.to_created') }}" value="{{ old('to', request()->input('to')) }}">
                            </div>
                            <div class="mb-3 col-md-3 text-end">
                                <input type="submit" name="search" value="{{ __('w3cpt::common.search') }}" class="btn btn-primary me-2"> 
                                <a href="{{ route('cpt.admin.index') }}" class="btn btn-danger">{{ __('w3cpt::common.reset') }}</a>
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
                    <h4 class="card-title">{{ __('w3cpt::common.all_W3Cpts') }}</h4>
                    <div>
                        <a href="{{ route('cpt.admin.index') }}" class="btn btn-primary">{{ __('w3cpt::common.all_W3Cpts') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg mb-0">
                            <thead class="">
                                <tr>
                                    <th> <strong> {{ __('w3cpt::common.s_no') }} </strong> </th>
                                    <th> <strong> {{ __('w3cpt::common.post_type') }} </strong> </th>
                                    <th> <strong> {{ __('w3cpt::common.cpt_name') }} </strong> </th>
                                    <th> <strong> {{ __('w3cpt::common.cpt_label') }} </strong> </th>
                                    <th> <strong> {{ __('w3cpt::common.description') }} </strong> </th>
                                    <th> <strong> {{ __('w3cpt::common.created_date') }} </strong> </th>
                                    <th class="text-center"> <strong> {{ __('w3cpt::common.actions') }} </strong> </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = $allCpts->firstItem();
                                @endphp
                                @forelse ($allCpts as $cpt)
                                    @php
                                        $cptMeta = optional($cpt->blog_meta)->pluck('value', 'title');
                                    @endphp
                                    <tr>
                                        <td> {{ $i++ }} </td>
                                        <td> {{ $cpt->title }} </td>
                                        <td> {{ isset($cptMeta['cpt_name']) ? $cptMeta['cpt_name'] : '' }} </td>
                                        <td> {{ isset($cptMeta['cpt_label']) ? $cptMeta['cpt_label'] : '' }} </td>
                                        <td> {{ isset($cptMeta['cpt_description']) ? Str::limit($cptMeta['cpt_description'], 30, ' ...') : '' }} </td>
                                        <td> {{ $cpt->created_at }} </td>
                                        <td class="text-center">
                                                <a href="{{ route('cpt.admin.restore', $cpt->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash-restore"></i></a>
                                                <a href="{{ route('cpt.admin.destroy', $cpt->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td class="text-center" colspan="7"><p>{{ __('w3cpt::common.cpt_not_found') }}</p></td></tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $allCpts->onEachSide(2)->appends(Request::input())->links() }}
                </div>
            </div>
        </div>
    </div>

</div>


@endsection