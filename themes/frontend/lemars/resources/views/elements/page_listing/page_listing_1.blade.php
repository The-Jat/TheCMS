@forelse($pages as $page)
<div class="{{ ($layout == 'sidebar_full') ? 'col-lg-4' : 'col-lg-6'; }} card-container">
    <div class="blog-card post-grid">
        <div class="blog-card-media">
            <img src="{{ DzHelper::getStorageImage('storage/page-images/'.@$page->feature_img->value) }}" alt="{{ DzHelper::theme_lang('Blog Image') }}">
        </div>
        <div class="blog-card-info">
            @php
                if($page->visibility != 'Pu'){
                    $page_visibility = $page->visibility == 'Pr' ? __('Private: ') : __('Protected: ') ;
                }else {
                    $page_visibility = '';
                }

                $page_title = ($post_title_length_type == 'on_words') ? Str::words($page->title, $post_title_length, ' ...') : Str::limit($page->title, $post_title_length, ' ...');
                $page_excerpt = ($post_excerpt_length_type == 'on_words') ? Str::words($page->excerpt, $post_excerpt_length, ' ...') : Str::limit($page->excerpt, $post_excerpt_length, ' ...');
            @endphp
            <h4 class="title">
                <a href="{{ DzHelper::laraPageLink($page->id) }}">{{ $page_visibility }} {{ $page_title }}</a>
            </h4>
            <p>{{ $page_excerpt }}</p>
            @php
                $permalink = DzHelper::laraPageLink($page->id);
                $image = '';
                if (optional($page->feature_img)->value && Storage::exists('public/page-images/'.$page->feature_img->value)) {
                    $image = asset('storage/page-images/'.$page->feature_img->value);
                }
            @endphp
            {!! DzHelper::getBlogShareButton($page->title, $permalink, $image) !!}
        </div>
    </div>
</div>
@empty
@endforelse