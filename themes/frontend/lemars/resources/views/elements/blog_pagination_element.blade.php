@if ($pre_next_post_on && $post_pagination)
    <div class="post-btn">
        <div class="prev-post">
        @if(!empty($previousBlog))
            <img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$previousBlog->feature_img->value) }}" alt="{{ DzHelper::theme_lang('Blog Image') }}">
            <h6 class="title">
                <a href="{{ DzHelper::laraBlogLink($previousBlog->id) }}">{{ Str::limit(DzHelper::theme_lang($previousBlog->title), 24, '..') }}</a>
                <span class="post-date">{{ DzHelper::theme_lang($previousBlog->publish_on) }}</span>
            </h6>
        @endif
        </div>
        <div class="next-post">
        @if(!empty($nextBlog))
            <h6 class="title">
            <a href="{{ DzHelper::laraBlogLink($nextBlog->id) }}">{{ Str::limit(DzHelper::theme_lang($nextBlog->title), 24, '..') }}</a>
            <span class="post-date">{{ DzHelper::theme_lang($nextBlog->publish_on) }}</span></h6>
            <img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$nextBlog->feature_img->value) }}" alt="{{ DzHelper::theme_lang('Blog Image') }}">
        @endif
        </div>
    </div>
@endif