@forelse($blogs as $blog)
    <div class="col-lg-12">
        <div class="blog-card post-left">
            <div class="blog-card-media">
                <a href="{{ DzHelper::laraBlogLink($blog->id) }}">
                    <img height="600" width="473" src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$blog->feature_img->value) }}" alt="{{ DzHelper::theme_lang('Blog Image') }}">
                </a>
            </div>
            <div class="blog-card-info">
                <ul class="cat-list">
                    @forelse($blog->blog_categories as $blogcategory)
                    <li class="title-sm post-tag"><a href="{{ DzHelper::laraBlogCategoryLink($blogcategory->id) }}">{{ DzHelper::theme_lang($blogcategory->title) }}</a></li>
                    @empty
                    <li class="title-sm post-tag"><a href="javascript:void(0);">{{ DzHelper::theme_lang('Uncatagorized') }}</a></li>
                    @endforelse
                </ul>
                @php
                    if($blog->visibility != 'Pu'){
                        $blog_visibility = $blog->visibility == 'Pr' ? __('Private: ') : __('Protected: ') ;
                    }else {
                        $blog_visibility = '';
                    }

                    $blog_title = ($post_title_length_type == 'on_words') ? Str::words($blog->title, $post_title_length, ' ...') : Str::limit($blog->title, $post_title_length, ' ...');
                    $blog_excerpt = ($post_excerpt_length_type == 'on_words') ? Str::words($blog->excerpt, $post_excerpt_length, ' ...') : Str::limit($blog->excerpt, $post_excerpt_length, ' ...');
                @endphp
                <h4 class="title"><a href="{{ DzHelper::laraBlogLink($blog->id) }}"> {{ $blog_visibility }} {{ $blog_title }}</a></h4>
                <p>{{ $blog_excerpt }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    @php
                        $permalink = DzHelper::laraBlogLink($blog->id);
                        $image = '';
                        if (isset($blog->feature_img->value) && Storage::exists('public/blog-images/'.$blog->feature_img->value)) {
                            $image = asset('storage/blog-images/'.$blog->feature_img->value);
                        }
                    @endphp
                    {!! DzHelper::getBlogShareButton($blog->title, $permalink, $image) !!}
                    <div>
                        <a href="{{ DzHelper::laraBlogLink($blog->id) }}" class="btn-link readmore"><i class="la la-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
@endforelse