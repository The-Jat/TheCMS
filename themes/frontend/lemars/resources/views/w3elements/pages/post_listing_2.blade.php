@php
    $blogs = HelpDesk::elementPostsByArgs($args);
@endphp
<div class="section-full bg-white content-inner-1">
    @if (isset($args['title']) && isset($args['subtitle']) && isset($args['description']))
    <div class="section-head text-center">
        <p class="title-sm">{{ DzHelper::theme_lang(isset($args['subtitle']) ? $args['subtitle'] : '') }}</p>
        <h2 class="m-b10">{{ DzHelper::theme_lang(isset($args['title']) ? $args['title'] : '') }}</h2>
        <p>{{ DzHelper::theme_lang(isset($args['description']) ? $args['description'] : '') }}</p>
    </div>
    @endif
    <div class="min-container">
        <div class="row sp10">
            @if (isset($blogs[0]) && !empty($blogs[0]))
            <div class="col-lg-6">
                <div class="blog-card post-grid m-b30">
                    <div class="blog-card-media">
                        <img src="{{ DzHelper::getStorageImage('storage/blog-images/'.$blogs[0]->feature_img->value) }}" alt="{{ DzHelper::theme_lang('Blog Image') }}">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-flex">
                <div class="blog-card center text-center bg-dark w-100 m-b30">
                    <div class="blog-card-info text-white">
                        <div class="title-sm">
                            <a href="javascript: void(0);">
                                {{ DzHelper::theme_lang(isset($blogs[0]->blog_categories[0]['title']) ? $blogs[0]->blog_categories[0]['title'] : '') }}
                            </a>
                        </div>
                        <h4 class="title">{{ isset($blogs[0]['title']) ? Str::limit(DzHelper::theme_lang($blogs[0]['title']), 24, ' ...') : '' }}</h4>
                        <p>{{ isset($blogs[0]['excerpt']) ? Str::limit(DzHelper::theme_lang($blogs[0]['excerpt']), 60, ' ...') : '' }}</p>
                        @php
                            $permalink = DzHelper::laraBlogLink($blogs[0]->id);
                            $image = '';
                            if (isset($blogs[0]->feature_img->value) && Storage::exists('public/blog-images/'.$blogs[0]->feature_img->value)) {
                                $image = asset('storage/blog-images/'.$blogs[0]->feature_img->value);
                            }
                        @endphp
                        {!! DzHelper::getBlogShareButton($blogs[0]->title, $permalink, $image) !!}
                    </div>
                </div>
            </div>
            @endif
        </div>
        @php
            unset($blogs[0]);
        @endphp
        @if ($blogs->isNotEmpty())
        <div class="sep-bottom">
            <div class="row ajaxLoadMoreContainer">
                @forelse($blogs as $blog)
                <div class="col-lg-4">
                    <div class="blog-card post-grid grid-style m-b30">
                        <div class="blog-card-media">
                            <img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$blog->feature_img->value) }}" alt="{{ DzHelper::theme_lang('Blog Image') }}">
                        </div>
                        <div class="blog-card-info">
                            <div class="title-sm">
                                <a href="javascript: void(0);">{{ isset($blog->blog_categories[0]) ? DzHelper::theme_lang($blog->blog_categories[0]['title']) : '' }}</a>
                            </div>
                            <h5 class="font-20">
                                <a href="{{ DzHelper::laraBlogLink($blog->id) }}">{{ isset($blog->title) ? Str::limit(DzHelper::theme_lang($blog->title), 18, ' ...') : '' }}</a>
                            </h5>
                        </div>
                    </div>
                </div>
                @empty
                @endforelse
            </div>
            <div class="text-center m-b30">
                @if (isset($args['pagination']) && $args['pagination'] == 'true')
                    @if ($blogs->hasMorePages())
                    <a
                        href="javascript:void(0);"
                        class="btn outline outline-2 black el-ajax-load-more radius-xl"
                        data-ajax-container="ajaxLoadMoreContainer"
                        data-no-of-posts="3"
                        data-current-page="2"
                        data-ajax-view="lemars_post_listing_2_ajax"
                        {{ isset($args['order']) ? 'data-order='.$args['order'] : '' }}
                        {{ isset($args['orderby']) ? 'data-orderby='.$args['orderby'] : '' }}
                        {{ isset($args['post_with_images']) ? 'data-post_with_images='.$args['post_with_images'] : '' }}
                        {{ isset($args['post_category_ids']) ? 'data-post_category_ids='.$args['post_category_ids'] : '' }}
                    >{{ DzHelper::theme_lang('Load More') }}</a>
                    @else
                    <a href="javascript:void(0);" class="btn outline outline-2 black disabled">{{ DzHelper::theme_lang('No More Posts') }}</a>
                    @endif
                @elseif (isset($args['view_all']) && $args['view_all'] == 'true')
                    <a href="{{ isset($args['page_id']) ? DzHelper::laraPageLink($args['page_id']) : 'javascript:void(0);' }}" class="btn outline outline-2 black radius-xl"><span>{{ DzHelper::theme_lang(isset($args['btn_text']) ? $args['btn_text'] : 'View All') }}</span></a>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
