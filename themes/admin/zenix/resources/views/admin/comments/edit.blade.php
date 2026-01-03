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
				<li class="breadcrumb-item"><a href="{{ route('comments.admin.index') }}">{{ __('common.comments') }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.edit_comment') }}</a></li>
			</ol>
		</div>
	</div>

	<form action="{{ route('comments.admin.update', $comment->id) }}" method="post" enctype="multipart/form-data">
		@csrf
		<div class="row">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">{{ __('common.edit_comment') }}</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="form-group col-md-6">
								<label for="CommentAuthor">{{ __('common.author') }} {{ __('common.name') }}</label>
								<input type="text" name="commenter" class="form-control" id="CommentAuthor" placeholder="{{ __('common.name') }}" value="{{ $comment->commenter }}">
								@error('commenter')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>
							<div class="form-group col-md-6">
								<label for="CommentEmail">{{ __('common.email') }}</label>
								<input type="text" name="email" class="slug form-control" id="CommentEmail" placeholder="{{ __('common.email') }}" value="{{ $comment->email }}">
								@error('email')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>
							<div class="form-group col-md-12">
								<label for="CommentProfileUrl">{{ __('common.profile_url') }}</label>
								<input type="text" name="profile_url" class="slug form-control" id="CommentProfileUrl" placeholder="{{ __('common.profile_url') }}" value="{{ $comment->profile_url }}">
								@error('profile_url')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>
							<div class="form-group col-md-12">
								<label for="Comment">{{ __('common.comment') }}</label>
								<textarea name="comment" class="form-control h-auto" id="Comment" rows="5">{{ $comment->comment }}</textarea>
								@error('comment')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card h-auto">
					<div class="card-header">
						<h4 class="card-title">{{ __('common.save_changes') }}</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="form-group">
								<label for="CommentStatus">{{ __('common.status') }}</label>
								<select name="approve" class="default-select form-control" id="CommentStatus">
									{{-- <option value="">{{ __('common.select_status') }}</option> --}}
									<option value="0" {{ old('approve', $comment->approve) == '0' ? 'selected' : '' }}>{{ __('common.pending') }}</option>
									<option value="1" {{ old('approve', $comment->approve) == '1' ? 'selected' : '' }}>{{ __('common.approved') }}</option>
									<option value="2" {{ old('approve', $comment->approve) == '2' ? 'selected' : '' }}>{{ __('common.spam') }}</option>
									<option value="3" {{ old('approve', $comment->approve) == '3' ? 'selected' : '' }}>{{ __('common.trash') }}</option>
								</select>
								@error('approve')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>

                            @if($comment->object_type == 1)
                                <p> {{ __('common.comment_s_blog') }} : <a class="fw-bold" href="{{ DzHelper::laraBlogLink($comment->object_id) }}"> {{ DzHelper::getBlogTitle($comment->object_id) }}</a></p>
                                <p> {{ __('common.submited_on') }} : {{ $comment->created_at }}</p>
                            @else
                                <p> {{ __('common.comment_s_blog') }} : <a class="fw-bold" href="{{ DzHelper::laraPageLink($comment->object_id) }}"> {{ DzHelper::getPageTitle($comment->object_id) }}</a></p>
                                <p> {{ __('common.submited_on') }} : {{ $comment->created_at }}</p>
                            @endif
							<div class=" pt-0">
								<button type="submit" class="btn btn-primary" >{{ __('common.update') }}</button>
								@if($comment->approve != 3)
	                    			<a href="{{ route('comments.admin.trash', $comment->id) }}" class="btn btn-danger">{{ __('common.move_to_trash') }}</a>
	                    		@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
@endsection

