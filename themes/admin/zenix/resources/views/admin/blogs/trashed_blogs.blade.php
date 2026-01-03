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
				<li class="breadcrumb-item"><a href="{{ route('blog.admin.index') }}">{{ __('common.blogs') }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.all_trashed_blogs') }}</a></li>
			</ol>
		</div>
	</div>



	<div class="row">
		<!-- Column starts -->
		<div class="col-xl-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">{{ __('common.all_trashed_blogs') }}</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-responsive-lg mb-0">
							<thead class="">
								<tr>
									<th> <strong> {{ __('S.N.') }} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('title', __('common.title')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('name.users', __('common.author')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('status', __('common.status')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('visibility', __('common.visibility')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('created_at', __('common.created')) !!} </strong> </th>
									@canany(['Controllers > BlogsController > admin_edit', 'Controllers > BlogsController > admin_destroy'])
										<th class="text-center"> <strong> {{ __('common.actions') }} </strong> </th>
                                    @endcanany
								</tr>
							</thead>
							<tbody>
								@php
									$i = $blogs->firstItem();
									$status = array('1' => 'Published', '2' => 'Draft', '3' => 'Trash', '4' => 'Private', '5' => 'Pending');
								@endphp
								@forelse ($blogs as $blog)
									<tr>
										<td> {{ $i++ }} </td>
										<td> {{ Str::limit($blog->title, 30, ' ...') }} </td>
										<td> {{ $blog->user_name }} </td>
										<td> {{ $status[$blog->status] }} </td>
										<td> 
											@if ($blog->visibility == 'Pr')
												<span class="badge badge-danger">{{ __('common.private') }}</span>
											@elseif($blog->visibility == 'PP')
												<span class="badge badge-warning">{{ __('common.password_protected') }}</span>
											@else
												<span class="badge badge-success">{{ __('common.public') }}</span>
											@endif
										</td>
										<td> {{ $blog->created_at }} </td>
										<td class="text-center">
												<a href="{{ route('blog.admin.restore_blog', $blog->id) }}" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-trash-restore"></i></a>
											@can('Controllers > BlogsController > admin_destroy')
												<a href="{{ route('blog.admin.destroy', $blog->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
											@endcan
										</td>
									</tr>
								@empty
									<tr><td class="text-center" colspan="7"><p>{{ __('common.blogs_not_found') }}</p></td></tr>
								@endforelse

							</tbody>
						</table>
					</div>
				</div>
				<div class="card-footer">
                    {{ $blogs->onEachSide(2)->appends(Request::input())->links() }}
				</div>
			</div>
		</div>
	</div>

</div>


@endsection