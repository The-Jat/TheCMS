@forelse($blogs as $blog)
<div class="col-lg-6 col-md-12 col-sm-6 card-container">
    <div class="blog-card post-grid">
        <div class="blog-card-media">
            <img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$blog->feature_img->value) }}" alt="{{ DzHelper::theme_lang('Blog Image') }}">
        </div>
        <div class="blog-card-info">
            <div class="title-sm"><a>{{ DzHelper::theme_lang(isset($blog->blog_categories[0]) ? $blog->blog_categories[0]['title'] : '') }}</a></div>
            <h4 class="title"><a href="{{ DzHelper::laraBlogLink($blog->id) }}">{{ isset($blog->title) ? Str::limit(DzHelper::theme_lang($blog->title), 20, ' ...') : '' }}</a></h4>
            <p>{{ isset($blog->excerpt) ? Str::limit(DzHelper::theme_lang($blog->excerpt), 60, ' ...') : '' }}</p>
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
