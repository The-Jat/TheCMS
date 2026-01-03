{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
	<div class="row page-titles mx-0">
		<div class="col-sm-6 p-0">
			<div class="welcome-text">
				<h4>{{ $taxonomy['cpt_tax_labels']['name'] }}</h4>
				<span>All {{ $taxonomy['cpt_tax_labels']['all_items'] }}</span>
			</div>
		</div>
		<div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('cpt.blog_category.admin.index', ['post_type' => $post_type['cpt_name'], 'taxonomy' => $taxonomy['cpt_tax_name']]) }}">{{ $taxonomy['cpt_tax_labels']['name'] }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ $taxonomy['cpt_tax_labels']['all_items'] }}</a></li>
			</ol>
		</div>
	</div>

	<div class="row">
        <!-- Column starts -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h4 class="card-title">{{ $taxonomy['cpt_tax_labels']['search_items'] }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('cpt.blog_category.admin.index') }}" method="get">
                        @csrf
                        <input type="hidden" name="post_type" value="{{ $post_type['cpt_name'] }}">
                        <input type="hidden" name="taxonomy" value="{{ $taxonomy['cpt_tax_name'] }}">
                        <div class="row">
                            <div class="col-sm-6 m-sm-0 form-group">
                                <input type="search" name="title" class="form-control" placeholder="{{ __('common.title') }}" value="{{ old('title', request()->input('title')) }}">
                            </div>
                            <div class="col-sm-6 text-sm-end">
                                <input type="submit" name="search" value="{{ __('common.search') }}" class="btn btn-primary me-2"> <a href="{{ route('cpt.blog_category.admin.index', ['post_type' => $post_type['cpt_name'], 'taxonomy' => $taxonomy['cpt_tax_name']]) }}" class="btn btn-danger">{{ __('common.reset') }}</a>
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
					<h4 class="card-title">{{ $taxonomy['cpt_tax_labels']['name'] }}</h4>
					@can('Controllers > BlogCategoriesController > admin_create')
						<a href="{{ route('cpt.blog_category.admin.create', ['post_type' => $post_type['cpt_name'], 'taxonomy' => $taxonomy['cpt_tax_name']]) }}" class="btn btn-primary">{{ $taxonomy['cpt_tax_labels']['add_new_item'] }}</a>
					@endcan
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-responsive-lg mb-0 min-width-40" >
							<thead>
								<tr>
									<th> <strong> {{ __('S.N.') }} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('title', __('common.name')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('slug', __('common.slug')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('blog_count', __('common.blog_count')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('created_at', __('common.created')) !!} </strong> </th>
									@canany(['Controllers > BlogCategoriesController > admin_edit', 'Controllers > BlogCategoriesController > admin_destroy'])
									<th class="text-center"> <strong> {{ __('common.actions') }} </strong> </th>
                                    @endcanany
								</tr>
							</thead>
							<tbody>
								@php
									$i = $blog_categories ? $blog_categories->firstItem() : 0;
								@endphp
								@forelse ($blog_categories as $blog_category)
									<tr>
										<td> {{ $i++ }} </td>
										<td> {{ $blog_category['title'] }} </td>
										<td> {{ $blog_category['slug'] }} </td>
										<td> <span class="badge bg-primary">{{ $blog_category->blog_count }}</span> </td>
										<td> {{ $blog_category['created_at'] }} </td>
										<td class="text-center">
											@can('Controllers > BlogCategoriesController > admin_edit')
												<a href="{{ route('cpt.blog_category.admin.edit', ['id' => $blog_category['id'], 'post_type' => $post_type['cpt_name'], 'taxonomy' => $taxonomy['cpt_tax_name']]) }}" class="btn btn-primary shadow btn-xs sharp me-1" title="{{ __('common.edit') }}"><i class="fas fa-pencil-alt"></i></a>
											@endcan
											@can('Controllers > BlogCategoriesController > admin_destroy')
												<a href="{{ route('cpt.blog_category.admin.destroy', ['id' => $blog_category['id'], 'post_type' => $post_type['cpt_name'], 'taxonomy' => $taxonomy['cpt_tax_name']]) }}" class="btn btn-danger shadow btn-xs sharp" title="{{ __('common.delete') }}"><i class="fa fa-trash"></i></a>
											@endcan
										</td>
									</tr>
								@empty
									<tr><td class="text-center" colspan="6"><p>{{ $taxonomy['cpt_tax_labels']['not_found'] }}</p></td></tr>
								@endforelse

							</tbody>
						</table>
					</div>
				</div>
				<div class="card-footer">
					{{ $blog_categories ? $blog_categories->onEachSide(1)->appends(Request::input())->links() : '' }}
				</div>
			</div>
		</div>
	</div>

</div>


@endsection