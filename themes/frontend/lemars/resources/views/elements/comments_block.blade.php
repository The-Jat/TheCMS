
@php
    $enable_comment = false;
    $object = '';
    $objectUrl = '#';

    if (isset($page) && !empty($page->comment)) {
        $enable_comment = true;
        $object = $page;
        $objectUrl = DzHelper::laraPageLink($object->id);
    }
    if (isset($blog) && !empty($blog->comment)) {
        $enable_comment = true;
        $object = $blog;
        $objectUrl = DzHelper::laraBlogLink($object->id);
    }
@endphp

@if ($enable_comment)
    <div class="{{ isset($page) ? 'container' : '' }} clear m-b30" id="comment-list">
        <div class="comments-area" id="comments-div">
            <h6 class="comments-title">
                <span>@if ($comment_count_on){{ $total_comments }}@endif {{ DzHelper::theme_lang('Comments') }}</span>
            </h6>
            @if($comments->isNotEmpty() && $comment_view_on)
                <ol class="comment-list">
                    @forelse($comments as $comment)
                        <li class="comment">
                            <div class="comment-body">
                                <div class="comment-author vcard">
                                    @if (optional($comment->user)->profile && Storage::exists('public/user-images/'.$comment->user->profile))
                                        <img class="avatar photo" src="{{ asset('storage/user-images/'.$comment->user->profile) }}" alt="">
                                    @else
                                        <img class="avatar photo" src="{{ asset('images/no-user.png') }}" alt="">
                                    @endif
                                    <cite class="fn">{{ DzHelper::theme_lang($comment->commenter) }}</cite>
                                </div>
                                <div class="comment-meta">
                                    <span>{{ \Carbon\Carbon::parse($comment->created_at)->format('d , F, Y') }}</span>
                                </div>
                                <div class="reply">
                                    <a rel="nofollow" href="{{ $objectUrl }}?replytocom={{ $comment->id }}#respond" class="comment-reply-link w3-comment-reply" data-commentid="{{ $comment->id }}" data-postid="{{ $object->id }}" data-replyto="Reply to {{ DzHelper::theme_lang($comment->commenter) }}">
                                    <i class="fa fa-reply"></i>
                                    </a>
                                </div>
                                <div class="comment-info">
                                    <p>{{ DzHelper::theme_lang($comment->comment) }}</p>
                                </div>
                            </div>
                            @if (isset($comment->child_comments) && $comment->child_comments->isNotEmpty())
                                @include('elements.child_comments', ['comments' => $comment->child_comments,'parent_comment' => $comment->commenter, 'depth' => 1])
                            @endif
                        </li>
                    @empty
                    @endforelse
                </ol>
            @endif
            <div class="mb-4">
                @if(config('Discussion.page_comments'))
                    {!! $comments->links('elements.pagination') !!}
                @endif
            </div>
            @if(!config('Discussion.registration_comment'))
                <div id="ReplyFormContainer">
                    @if(Session::has('unapprove_comment_error'))
                        <div class="alert alert-danger alert-dismissible alert-alt fade show">
                            <strong>{{ __('common.error') }}</strong> {{ Session::get('unapprove_comment_error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        </div>
                    @endif
                    <div class="default-form comment-respond style-1 mb-4" id="respond">
                        <div class="comment-reply-title text-center mb-3">
                            <span>{{ DzHelper::theme_lang('LEAVE A REPLY') }}</span>
                        </div>
                        <h5>
                            <span id="reply-title"></span>
                            <small class="fw-normal"> <a rel="nofollow" id="cancel-comment-reply" href="{{ $objectUrl }}#respond" style="display: none;">{{ DzHelper::theme_lang('Cancel reply') }}</a> </small>
                        </h5>
                        @auth
                            <p class="m-t0">{{ DzHelper::theme_lang('You are Logged in as') }} <a href="{{ route('admin.users.profile') }}">{{ DzHelper::theme_lang(Auth::user()->name) }}</a></p>
                        @endauth
                        <form action="{{ route('comments.admin.store') }}" class="comment-form" id="commentform" method="post">
                            @csrf
                            @error('commenter')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ DzHelper::theme_lang($message) }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @enderror
                            @error('email')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ DzHelper::theme_lang($message) }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @enderror
                            @error('comment')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ DzHelper::theme_lang($message) }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @enderror

                            @if( Session::get('success'))
                                <div class="m-b30">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ Session::get('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif
                            <input type="hidden" name="object_id" value="{{ $object->id }}">
                            <input type="hidden" name="parent_id" id="comment_parent" value="0">
                            @guest
                                <p class="m-b30">
                                    <input type="text" name="commenter" placeholder="{{ DzHelper::theme_lang('Name') }}" id="commenter" {{ old('commenter', $comment_author) }} class="form-control" {{ $isRequired }}>
                                </p>
                                <p class=" m-b30">
                                    <input type="text" placeholder="{{ DzHelper::theme_lang('Email') }}" name="email" id="email" value="{{ old('email', $comment_email) }}" class="form-control" {{ $isRequired }}>
                                </p>
                                <p class="m-b30">
                                    <input type="text" placeholder="{{ DzHelper::theme_lang('Website url') }}" name="profile_url" id="profileurl" {{ old('profile_url', $comment_url) }} class="form-control">
                                </p>
                            @endguest
                            <p class="comment-form-comment m-b30">
                                <textarea rows="8" name="comment" placeholder="{{ DzHelper::theme_lang('Type Comment here ...') }}" id="comment" class="form-control">{{ old('comment') }}</textarea>
                            </p>
                            @guest
                                @if(config('Discussion.save_comments_cookie'))
                                    <p class="comment-form-comment">
                                        <input type="checkbox" name="set_comment_cookie" class="form-check-input" id="set_comment_cookie" @checked($comment_author || $comment_email || $comment_url)>
                                        <label for="set_comment_cookie" class="d-block">{{ __('Remember details for future comments: Name, Email, and Website.') }}</label>
                                    </p>
                                @endif
                            @endguest
                            <p class="form-submit m-b30">
                                <input href="#respond" type="submit" value="{{ DzHelper::theme_lang('Submit Now') }}" class="btn btn-dark btn-skew btn-icon" id="submit">
                            </p>
                        </form>
                    </div>
                </div>
            @else
                <p>{{ DzHelper::theme_lang('Please') }} <a href="{{ route('admin.login') }}">{{ DzHelper::theme_lang('log in') }}</a> {{ DzHelper::theme_lang('to post a comment') }}</p>
            @endif
            <!-- Form END -->
        </div>
    </div>
@endif
