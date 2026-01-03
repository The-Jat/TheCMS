@php
    $blogs = HelpDesk::elementPostsByArgs($args);
@endphp

<!-- Our Blog -->
<section class="default-el">
    <div class="container">
        @if (isset($args['subtitle']) || isset($args['title']) || isset($args['view_all']) || isset($args['page_id']))
        <div class="section-head">
            <div class="content">
                <p class="sub-title">{{ isset($args['subtitle']) ? $args['subtitle'] : '' }}</p>
                <h2 class="title">{{ isset($args['title']) ? $args['title'] : '' }}</h2>
                <p class="description">{{ isset($args['description']) ? $args['description'] : '' }}</p>
            </div>

            <div>
                @if (isset($args['view_all']) && $args['view_all'] == 'true')
                <a href="{{ isset($args['page_id']) ? DzHelper::laraPageLink($args['page_id']) : 'javascript:void(0);' }}" class="btn btn-primary  ">{{ __('View All') }}</a>
                @endif
            </div>
        </div>
        @endif
        <div class="row">
            @forelse($blogs as $blog)
            <div class="col-lg-8 m-b40">
                <div class="dz-card default-el-1 blog-half overlay-shine m-b40">
                    <div class="dz-media">
                        <a href="{{ DzHelper::laraBlogLink($blog->id) }}">
                            @if(optional($blog->feature_img)->value && Storage::exists('public/blog-images/'.$blog->feature_img->value))
                                <img src="{{ asset('storage/blog-images/'.$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}">
                            @else
                                <img src="{{ asset('images/noimage.jpg') }}" alt="{{ __('Blog Image') }}">
                            @endif
                        </a>
                    </div>
                    <div class="dz-info">
                        <div class="dz-meta">
                            <ul>
                                <li class="post-author">
                                    <a href="javascript:void(0);">
                                        <img src="{{ HelpDesk::user_img($blog->user->profile) }}" alt="">{{ $blog->user->name }}</a>
                                </li>
                                <li class="post-date"><a href="javascript:void(0);">  {{ Carbon\Carbon::parse($blog->publish_on)->format(config('Site.custom_date_format')) }}</a></li>
                                <li class="post-comment"><a href="javascript:void(0);">{{ $blog->blog_comments_count}} {{ __('comments') }}</a></li>
                            </ul>
                        </div>
                        <h4 class="dz-title"><a href="{{ DzHelper::laraBlogLink($blog->id) }}">{{ Str::limit($blog->title, 40, ' ...') }}</a></h4>
                        <p>{{ Str::limit($blog->excerpt, 80, ' ...') }}</p>
                        <a href="{{ DzHelper::laraBlogLink($blog->id) }}" class="read-more-btn bg-primary ">{{ __('Read More') }}</a>
                    </div>
                </div>
            </div>
            @empty
            @endforelse
            @if (isset($args['pagination']) && ($args['pagination'] == true))
            <div class="col-lg-12 ">
                {!! $blogs->links('elements.pagination') !!}
            </div>
            @endif
        </div>
    </div>
</section>
<!-- Our Blog -->



