@php
    $categories = HelpDesk::elementCategoriesByArgs($args);
@endphp

<section class="default-el">
    <div class="container">
        @if (isset($args['title']) || isset($args['view_all']) || isset($args['page_id']))
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
        <div class="row m-b10">
            @forelse($categories as $category)
            <div class="col-lg-3 col-md-4  col-sm-6 m-b30">
                <div class="category-box swiper-category-box">
                    <div class="category-media">    
                        @if(optional($category)->image && Storage::exists('public/category-images/'.$category->image))
                            <img src="{{ asset('storage/category-images/'.$category->image) }}" alt="">
                        @else
                            <img src="{{ asset('images/noimage.jpg') }}" alt="">
                        @endif
                    </div>
                    <div class="category-info">
                        <a href="{{ DzHelper::laraBlogCategoryLink($category->id) }}" class="category-title">{{  $category->title  }}</a>
                    </div>
                </div>
            </div>
            @empty
            @endforelse
        </div>
        @if (isset($args['pagination']) && ($args['pagination'] == true))
        <div class="col-lg-12">
            {!! $categories->links('elements.pagination') !!}
        </div>
        @endif
    </div>
</section>