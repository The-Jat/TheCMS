{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
	<div class="row page-titles mx-0 mb-3">
		<div class="col-sm-6 p-0">
			<div class="welcome-text">
				<h4>{{ __('common.blog_tag') }}</h4>
				<span>{{ __('common.all_blog_tags') }}</span>
			</div>
		</div>
		<div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('blog_tag.admin.index') }}">{{ __('common.blog_tag') }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.all_blog_tags') }}</a></li>
			</ol>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="row">
                <!-- Column starts -->
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header d-block">
                        	@if($blogTag->id)
                            	<h4 class="card-title">{{ __('common.edit_blog_tag') }}</h4>
                            @else
                            	<h4 class="card-title">{{ __('common.add_blog_tag') }}</h4>
                        	@endif
                        </div>
                        <form method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="basic-form">
                                    <div class="form-group">
                                        <label for="title">{{ __('common.title') }}</label>
                                        <input type="text" name="title" class="form-control" id="BlogTitle" placeholder="{{ __('common.title') }}" value="{{ old('title', $blogTag->title) }}" required>
                                        @error('title')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="slug">{{ __('common.slug') }}</label>
                                        <input type="text" name="slug" class="form-control slug" id="BlogSlug" placeholder="{{ __('common.slug') }}" value="{{ old('slug', $blogTag->slug) }}" required>
                                        @error('slug')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <input type="hidden" name="blog_id" value="{{ $blogTag->id }}">
                                <button type="submit" class="btn btn-primary">{{ __('common.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
		</div>
		<div class="col-md-8">
			<div class="row">
				<!-- Column starts -->
				<div class="col-xl-12">
					<div class="card">
						<div class="card-header d-block">
							<h4 class="card-title">{{ __('common.blog_tag') }}</h4>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-responsive-md mb-0">
									<thead>
										<tr>
											<th> <strong> {{ __('common.s_no') }} </strong> </th>
											<th> <strong> {{ __('common.name') }} </strong> </th>
											<th> <strong> {{ __('common.blog_count') }} </strong> </th>
											<th> <strong> {{ __('common.created') }} </strong> </th>
											<th class="text-center"> <strong> {{ __('common.actions') }} </strong> </th>
										</tr>
									</thead>
									<tbody>
										@php
											$i = $blog_tags ? $blog_tags->firstItem() : 0;
										@endphp
										@forelse ($blog_tags as $blog_tag)
											<tr>
												<td> {{ $i++ }} </td>
												<td> {{ $blog_tag->title }} </td>
												<td> <span class="badge bg-primary">{{ $blog_tag->blog_count }}</span> </td>
												<td> {{ $blog_tag->created_at }} </td>
												<td class="text-center">
													<a href="{{ route('blog_tag.admin.list', $blog_tag->id) }}" class="btn btn-primary shadow btn-xs sharp me-1" title="{{ __('common.edit') }}"><i class="fas fa-pencil-alt"></i></a>
													<a href="{{ route('blog_tag.admin.destroy', $blog_tag->id) }}" class="btn btn-danger shadow btn-xs sharp" title="{{ __('common.delete') }}"><i class="fa fa-trash"></i></a>
												</td>
											</tr>
										@empty
											<tr><td class="text-center" colspan="5"><p>{{ __('common.blog_tags_not_found') }}</p></td></tr>
										@endforelse

									</tbody>
								</table>
							</div>
						</div>
						<div class="card-footer">
							{{ $blog_tags ? $blog_tags->onEachSide(1)->links() : '' }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>


@endsection