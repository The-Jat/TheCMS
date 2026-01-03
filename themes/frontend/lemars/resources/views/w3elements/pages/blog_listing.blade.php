@php
    $blogs = HelpDesk::elementPostsByArgs($args);
    if (isset($w3cms_option)) {
        extract($w3cms_option);
    }
@endphp

@if (!empty($args['sidebar']) && $args['sidebar'] == true)
<div class="section-full bg-white content-inner p-b0">
    <div class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-8 col-md-12" >
@endif
                <div class="row masonry" id="BlogsLoadmoreContent">
                    @forelse($blogs as $blog)
                    <div class="col-lg-6 card-container">
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
                </div>

                @if ($args['pagination'] ?? false)
                <!-- Blogs Pagination --> 
                <div class="text-center">
                    @if ($args['pagination_type'] == 'load_more')
                        @if ($blogs->hasMorePages())
                            <form id="W3AjaxIndexForm" class="text-center">
                                <input type="hidden" name="ajax_container" value="BlogsLoadmoreContent">
                                <input type="hidden" name="no_of_posts" value="{{config('Reading.nodes_per_page')}}">
                                <input type="hidden" name="page" value="2">
                                <input type="hidden" name="ajax_view" value="ajax_index_blog_listing">
                                <input type="hidden" name="view_name" value="index">
                                <button  class="btn outline outline-2 black radius-xl ajax-load-more" data-form-id="W3AjaxIndexForm">{{ __('Load More') }}</button>
                            </form>
                        @else
                            <a href="javascript:void(0);" class="btn outline outline-2 black radius-xl disabled">{{ DzHelper::theme_lang('No More Posts') }}</a>
                        @endif
                    @else
                    {!! $blogs->links('elements.pagination') !!}
                    @endif
                </div>
                <!-- Blogs Pagination End--> 
                @endif
@if (!empty($args['sidebar']) && $args['sidebar'] == true)
            </div>
            <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12">
                <div class="side-bar p-r20 sticky-top">
                    @include('elements.sidebar')
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif