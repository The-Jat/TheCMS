@php
    $blogObj = new \app\models\Blog();
    $limit = $args['number_of_posts'] ?? 3;
    $blogs = $blogObj->recentBlogs(['limit'=>$limit]);
@endphp
<h6 class="m-b30 footer-title"><span>{{ $args['title'] ?? __('Recent Post') }}</span></h6>
<div class="widget recent-posts-entry">
    @forelse($blogs as $blog)
    <div class="widget-post-bx">
        <div class="widget-post clearfix">
            <div class="dlab-post-media"> <img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$blog->feature_img->value) }}" alt=""> </div>
            <div class="dlab-post-info">
                <div class="dlab-post-header">
                    <h6 class="post-title">
                        <a href="{{ DzHelper::laraBlogLink($blog->id) }}">{{ Str::limit($blog->title, 24, ' ...') }}</a>
                    </h6>
                </div>
                @if (!empty($args['display_date']))
                <div class="dlab-post-meta">
                    <ul>
                        <li class="post-date">{{ Carbon\Carbon::parse($blog->publish_on)->format(config('Site.custom_date_format')) }}</li>
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
    @empty
    @endforelse
</div>