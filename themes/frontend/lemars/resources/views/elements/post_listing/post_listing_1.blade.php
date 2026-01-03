@forelse($blogs as $blog)
<div class="{{ (empty($sidebar) || !$show_sidebar || $layout == 'sidebar_full') ? 'col-lg-4' : 'col-lg-6'; }} card-container">
    <div class="blog-card post-grid">
        <div class="blog-card-media">
            <img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$blog->feature_img->value) }}" alt="{{ DzHelper::theme_lang('Blog Image') }}">
        </div>
        <div class="blog-card-info">
            <div class="title-sm"><a href="{{ DzHelper::laraBlogCategoryLink(@$blog->blog_categories[0]['id']) }}">{{ DzHelper::theme_lang(@$blog->blog_categories[0]['title']) }}</a></div>
            @php
                if($blog->visibility != 'Pu'){
                    $blog_visibility = $blog->visibility == 'Pr' ? __('Private: ') : __('Protected: ') ;
                }else {
                    $blog_visibility = '';
                }

                $blog_title = ($post_title_length_type == 'on_words') ? Str::words($blog->title, $post_title_length, ' ...') : Str::limit($blog->title, $post_title_length, ' ...');
                $blog_excerpt = ($post_excerpt_length_type == 'on_words') ? Str::words($blog->excerpt, $post_excerpt_length, ' ...') : Str::limit($blog->excerpt, $post_excerpt_length, ' ...');
            @endphp
            <h4 class="title">
                <a href="{{ DzHelper::laraBlogLink($blog->id) }}">{{ $blog_visibility }} {{ $blog_title }}</a>
            </h4>
            <p>{{ $blog_excerpt }}</p>
            @php
                $permalink = DzHelper::laraBlogLink($blog->id);
                $image = '';
                if (optional($blog->feature_img)->value && Storage::exists('public/blog-images/'.$blog->feature_img->value)) {
                    $image = asset('storage/blog-images/'.$blog->feature_img->value);
                }
            @endphp
            {!! DzHelper::getBlogShareButton($blog->title, $permalink, $image) !!}
        </div>
    </div>
</div>
@empty
@endforelse