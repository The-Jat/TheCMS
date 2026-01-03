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
				<li class="breadcrumb-item"><a href="{{ route('language.admin.index') }}">{{ __('common.language') }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.all_language') }}</a></li>
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
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">{{ __('common.language') }}</h4>
					<div>
						@can('Controllers > LanguageController > admin_create')
							<a href="{{ route('language.admin.create') }}" class="btn btn-primary">{{ __('common.add_Language') }}</a>
						@endcan
						<a href="{{ route('language.admin.trash_list') }}" class="btn btn-primary">{{ __('common.trashed_Language') }}</a>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-responsive-lg mb-0">
							<thead>
								<tr>
									<th> <strong> {{ __('common.s_no') }} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('title', __('common.title')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('language_code', __('common.language_code')) !!} </strong> </th>
                                    <th> <strong> {!! DzHelper::dzSortable('country', __('common.country')) !!} </strong> </th>
                                    <th> <strong> {!! DzHelper::dzSortable('country_code', __('common.country_code')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('country_code', __('common.country_flag')) !!} </strong> </th>
									@canany(['Controllers > LanguageController > admin_edit', 'Controllers > LanguageController > admin_destroy'])
										<th class="text-center"> <strong> {{ __('common.actions') }} </strong> </th>
                                    @endcanany
								</tr>
							</thead>
							<tbody>
								@php
									$i =1;
								@endphp
								@forelse ($language as $language)
									<tr>
										<td> {{ $i++ }} </td>
										<td> {{ Str::limit($language->title, 30, ' ...') }} </td>
										<td> {{ $language->language_code }} </td>
                                        <td> {{ $language->country }} </td>
                                        <td> {{ $language->country_code }} </td>
                                        <td> {{ $language->country_flag }} </td>


										<td class="text-center">
											@can('Controllers > LanguageController > admin_edit')
												<a href="{{ route('language.admin.edit', $language->id) }}" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
											@endcan
											@can('Controllers > LanguageController > admin_destroy')
												<a href="{{ route('language.admin.destroy',$language->id) }}" class="btn btn-danger shadow btn-xs sharp" onclick="return confirm('Are you sure you want to delete this language?');"><i class="fa fa-trash"></i></a>
											@endcan
										</td>
									</tr>
								@empty
									<tr><td class="text-center" colspan="7"><p>{{ __('common.language_not_found') }}</p></td></tr>
								@endforelse

							</tbody>
						</table>
					</div>
				</div>
				<div class="card-footer">
				</div>
			</div>
		</div>
	</div>

</div>


@endsection
