{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
	<div class="row page-titles mx-0">
		<div class="col-sm-6 p-0">
			<div class="welcome-text">
				<h4>{{ __('common.welcome_back_title') }}</h4>
				<p class="mb-0">{{ __('common.welcome_back_desc') }}</p>
		    </div>
		</div>
		<div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('comments.admin.index') }}">{{ __('common.comments') }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.all_comments') }}</a></li>
			</ol>
		</div>
	</div>

	<div class="row">
        <!-- Column starts -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h4 class="card-title">{{ __('common.search_comments') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('comments.admin.index') }}" method="get">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 m-sm-0 form-group">
                                <input type="search" name="commenter" class="form-control" placeholder="{{ __('common.title') }}" value="{{ old('commenter', request()->input('commenter')) }}">
                            </div>
                            <div class="col-md-3 m-sm-0 form-group">
                                <input type="search" name="email" class="form-control" placeholder="{{ __('common.email') }}" value="{{ old('email', request()->input('email')) }}">
                            </div>
							<div class="mb-3 col-md-3">
								<select name="approve" class="default-select form-control">
									<option value="">{{ __('common.select_status') }}</option>
									<option value="0" {{ old('approve', request()->input('approve')) == '0' ? 'selected' : '' }}>{{ __('common.pending') }}</option>
									<option value="1" {{ old('approve', request()->input('approve')) == '1' ? 'selected' : '' }}>{{ __('common.approved') }}</option>
									<option value="2" {{ old('approve', request()->input('approve')) == '2' ? 'selected' : '' }}>{{ __('common.spam') }}</option>
									<option value="3" {{ old('approve', request()->input('approve')) == '3' ? 'selected' : '' }}>{{ __('common.trash') }}</option>
								</select>
							</div>
                            <div class="col-md-3 text-md-end">
                                <input type="submit" name="search" value="{{ __('common.search') }}" class="btn btn-primary me-2">
                                <a href="{{ route('comments.admin.index') }}" class="btn btn-danger">{{ __('common.reset') }}</a>
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
					<h4 class="card-title">{{ __('common.comment') }}</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive ">
						<table class="table table-responsive-lg mb-0">
							<thead>
								<tr>
									<th> <strong> {{ __('common.s_no') }} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('commenter', __('common.commenter')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('email', __('common.email')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('approve', __('common.approve')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('created_at', __('common.created')) !!} </strong> </th>

									<th class="text-center"> <strong> {{ __('common.actions') }} </strong> </th>

								</tr>
							</thead>
							<tbody>
								@php
									$i = $comments ? $comments->firstItem() : 0;
								@endphp
								@forelse ($comments as $comment)
                                <!-- this condition is use for check comment blog is in trash or not if blog is in trash then it will not dislasy -->
                                    @if(DzHelper::checkCommentBlogExist($comment->object_id, $comment->object_type) == 0)
                                        <tr>
                                            <td> {{ $i++ }} </td>
                                            <td> {{ $comment->commenter }} </td>
                                            <td> {{ $comment->email }} </td>
                                            <td>
                                                @if ($comment->approve == 0)
                                                    <span class="badge badge-warning">{{ __('common.pending') }}</span>
                                                @elseif($comment->approve == 1)
                                                    <span class="badge badge-success">{{ __('common.approved') }}</span>
                                                @elseif($comment->approve == 2)
                                                    <span class="badge badge-warning">{{ __('common.spam') }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ __('common.trash') }}</span>
                                                @endif
                                            </td>
                                            <td> {{ $comment->created_at }} </td>
                                            <td class="text-center">
                                                <a href="{{ route('comments.admin.edit', $comment->id) }}" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>

                                                <a href="{{ route('comments.admin.destroy', $comment->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endif
								@empty
									<tr><td class="text-center" colspan="6"><p>{{ __('common.comments_not_found') }}</p></td></tr>
								@endforelse

							</tbody>
						</table>
					</div>
				</div>
				<div class="card-footer">
					{{ $comments ? $comments->onEachSide(1)->appends(Request::input())->links() : '' }}
				</div>
			</div>
		</div>
	</div>

</div>


@endsection
