@php
    $blog_view              = HelpDesk::getPostMeta(optional($blog)->id,'blog_view') ?? 0;
    $total_post_views       = $blog_start_view + $blog_view;

	$blog_options 	        = ThemeOption::GetBlogOptionById(optional($blog)->id);
    $post_pagination        = $blog_options['post_pagination'] ?? false;
	$featured_image			= $blog_options['featured_image'] ?? true;

	if( !$show_sidebar || empty($sidebar) || $layout == 'sidebar_full')
	{
		$is_sidebar = false;
		$classes = 'col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12';
		$blog_classes = 'blog-post blog-single blog-post-style-2 ';

	}else{
		$is_sidebar = true;
		$classes = 'col-xl-9 col-lg-8 col-md-12 col-sm-12 col-12';
		$blog_classes = 'blog-post blog-single blog-post-style-2 sidebar';
	}
	$container = ($is_sidebar)?'':'min-container';
@endphp

<div class="section-full content-inner bg-white">
	<div class="container">
		<div class="row">
            <!-- Left sidebar area -->
			@if ($layout == 'sidebar_left' && $show_sidebar && $is_sidebar)
			<div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12">
                <div class="side-bar p-l30 sticky-top">
                    @include('elements.sidebar')
                    <div class="clearfix"></div>
                </div>
            </div>
			@endif
            <!-- End Left sidebar area -->

            <!--Content Side-->
			<div class="{{ $classes }}">

                <!-- Password protected block -->
                @include('elements.password_protected_block')
                <!-- End Password protected block -->
                
				@if ($status == 'unlock_'.$blog->id)
    				<div class="section-head text-center">
    					@if ($category_on && !empty($blog->blog_categories))
    					<ul class="cat-list">
                            @forelse($blog->blog_categories as $blogcategory)
                            <li class="title-sm post-tag"><a href="{{ DzHelper::laraBlogCategoryLink($blogcategory->id) }}">{{ DzHelper::theme_lang($blogcategory->title) }}</a></li>
                            @empty
                            <li class="title-sm post-tag"><a href="javascript:void(0);">{!! DzHelper::theme_lang('Uncatagorized') !!}</a></li>
                            @endforelse
                        </ul>
    					@endif

    					@php
    	                    if($blog->visibility != 'Pu'){
    	                        $blog_visibility = $blog->visibility == 'Pr' ? __('Private: ') : __('Protected: ');
    	                    }else {
    	                        $blog_visibility = '';
    	                    }
    	                @endphp
                        <h2 class="title-head">{{ DzHelper::theme_lang($blog_visibility) }}{{ DzHelper::theme_lang( $blog->title)}}</h2>
    				</div>
    				<div class="{{ $blog_classes }}">

                        <div class="dlab-post-info">
        					<div class="dlab-post-text text">
        						@if ($featured_image && $featured_img_on && !empty(@$blog->feature_img->value))
        						<div class="alignwide">
        							<figure class="aligncenter">
        								<img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$blog->feature_img->value) }}" alt="{{ DzHelper::theme_lang('Blog Image') }}">
        							</figure>
        						</div>
        						@endif
                                {!! $blog->content !!}
        						<div class="clearfix"></div>
        					</div>

        					<div class="blog-card-info style-1 no-bdr">
        						<div class="date">@if ($date_on){{ DzHelper::theme_lang($blog->publish_on) }}@endif</div>
                                @php
                                    $permalink = DzHelper::laraBlogLink($blog->id);
                                    $image = '';
                                    if (optional($blog->feature_img)->value && Storage::exists('public/blog-images/'.$blog->feature_img->value)) {
                                        $image = asset('storage/blog-images/'.$blog->feature_img->value);
                                    }
                                @endphp
                                @if ($post_sharing_on && $show_social_icon && $social_shaing_on_post)
                                    {!! DzHelper::getBlogShareButton($blog->title, $permalink, $image) !!}
                                @endif
                                <div>
                                    <a href="#respond" class="btn-link comment">{{ DzHelper::theme_lang('Write A Comment') }}</a>
                                </div>
        					</div>
    				    </div>
                    </div>
                    <div class="{{ $container }}">
                        <!-- Author block element -->
                        @include('elements.author_block_element')
                        <!-- End Author block element -->

                        <!-- Blog Pagination element -->
                        @include('elements.blog_pagination_element')
                        <!-- End Blog Pagination element -->
        				
                        <!-- Comment list block -->
                        @include('elements.comments_block')
                        <!-- End comment list block -->
                    </div>
                    
                @endif
			</div>
            <!-- End Content Side-->

			<!-- Right sidebar area -->
            @if ( $is_sidebar && $show_sidebar && $layout == 'sidebar_right')
            <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12">
                <div class="side-bar p-r20 sticky-top">
                    @include('elements.sidebar')
                    <div class="clearfix"></div>
                </div>
            </div>
            @endif
            <!-- End Right sidebar area -->
		</div>
	</div>
</div>
