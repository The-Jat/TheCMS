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
				<li class="breadcrumb-item"><a href="{{ route('page.admin.index') }}">{{ __('common.pages') }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.all_pages') }}</a></li>
			</ol>
		</div>
	</div>

	@php
        $collapsed = 'collapsed';
        $show = '';
    @endphp

    @if(!empty(request()->title) || !empty(request()->status) || !empty(request()->from) || !empty(request()->to))
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
                    <h4 class="accordion-header-text m-0">{{ __('common.search_pages') }}</h4>
                    <span class="accordion-header-indicator"></span>
				</div>
				<div class="card-body collapse accordion__body {{ $show }}" id="rounded-search-sec" data-bs-parent="#search-sec-outer">
					<form action="{{ route('page.admin.index') }}" method="get">
					@csrf
						<input type="hidden" name="todo" value="Filter">
						<div class="row">
							<div class="col-md-4 col-lg-2 mb-3 mb-lg-0">
								<input type="search" name="title" class="form-control" placeholder="{{ __('common.title') }}" value="{{ old('title', request()->input('title')) }}">
							</div>
							<div class="col-md-4 col-lg-3 mb-3 mb-lg-0">
								<select name="status" class="default-select form-control">
									<option value="">{{ __('common.select_status') }}</option>
									<option value="1" {{ old('status', request()->status) == 1 ? 'selected' : '' }}>{{ __('common.published') }}</option>
									<option value="2" {{ old('status', request()->status) == 2 ? 'selected' : '' }}>{{ __('common.draft') }}</option>
									<option value="3" {{ old('status', request()->status) == 3 ? 'selected' : '' }}>{{ __('common.trash') }}</option>
									<option value="4" {{ old('status', request()->status) == 4 ? 'selected' : '' }}>{{ __('common.private') }}</option>
									<option value="5" {{ old('status', request()->status) == 5 ? 'selected' : '' }}>{{ __('common.pending') }}</option>
								</select>
							</div>
							<div class="col-md-4 col-lg-2 mb-3 mb-lg-0">
								<input type="search" name="from" class="form-control datetimepicker" id="PublishDateTimeTextbox" placeholder="{{ __('common.from_created') }}" value="{{ old('from', request()->from) }}">
							</div>
							<div class="col-md-4 col-lg-2 mb-3 mb-lg-0">
								<input type="search" name="to" class="form-control datetimepicker" placeholder="{{ __('common.to_created') }}" value="{{ old('to', request()->to) }}">
							</div>
							<div class="col-md-4 col-lg-3 text-end">
								<input type="submit" name="search" value="{{ __('common.search') }}" class="btn btn-primary me-2"> 
								<a href="{{ route('page.admin.index') }}" class="btn btn-danger">{{ __('common.reset') }}</a>
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
					<h4 class="card-title">{{ __('common.pages') }}</h4>
					<div>
						@can('Controllers > PagesController > admin_create')
							<a href="{{ route('page.admin.create') }}" class="btn btn-primary">{{ __('common.add_page') }}</a>
						@endcan
						<a href="{{ route('page.admin.trash_list') }}" class="btn btn-primary">{{ __('common.trashed_pages') }}</a>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-responsive-lg mb-0">
							<thead>
								<tr>
									<th> <strong> {{ __('common.s_no') }} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('title', __('common.title')) !!} </strong> </th>
									<th> <strong> {!! __('common.author') !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('status', __('common.status')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('visibility', __('common.visibility')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('created_at', __('common.created')) !!} </strong> </th>
									@canany(['Controllers > PagesController > admin_edit', 'Controllers > PagesController > admin_destroy'])
										<th class="text-center"> <strong> {{ __('common.actions') }} </strong> </th>
                                    @endcanany
								</tr>
							</thead>
							<tbody>
								@php
									$i = $pages->firstItem();
								@endphp
								@forelse ($pages as $page)
									<tr>
										<td> {{ $i++ }} </td>
										<td> {{ Str::limit($page->title, 30, ' ...') }} </td>
										<td> {{ optional($page->user)->full_name }} </td>
										<td> {{ $status[$page->status] }} </td>
										<td> 
											@if ($page->visibility == 'Pr')
												<span class="badge badge-danger">{{ __('common.private') }}</span>
											@elseif($page->visibility == 'PP')
												<span class="badge badge-warning">{{ __('common.password_protected') }}</span>
											@else
												<span class="badge badge-success">{{ __('common.public') }}</span>
											@endif
										</td>
										<td> {{ $page->created_at }} </td>
										<td class="text-center">
											@can('Controllers > PagesController > admin_edit')
												<a href="{{ route('page.admin.edit', $page->id) }}" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
											@endcan
											@can('Controllers > PagesController > admin_destroy')
												<a href="{{ route('page.admin.admin_trash_status', $page->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
											@endcan
										</td>
									</tr>
								@empty
									<tr><td class="text-center" colspan="7"><p>{{ __('common.pages_not_found') }}</p></td></tr>
								@endforelse

							</tbody>
						</table>
					</div>
				</div>
				<div class="card-footer">
					{{ $pages->onEachSide(2)->appends(Request::input())->links() }}
				</div>
			</div>
		</div>
	</div>

</div>


@endsection