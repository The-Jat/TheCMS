@php
    $pages = HelpDesk::elementPagesByArgs($args);
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
        <div class="page-list row">
            @forelse($pages as $page)
            <div class="col-lg-3 m-b30 col-sm-6 "> 
				<div class="page-listing-box">
					<h5>{{ $page->title }}</h5>
					<p>{{ $page->excerpt }}</p>
					<a class="btn btn-primary" href="{{ DzHelper::laraPageLink($page->id) }}">{{ __('Go to Page') }}</a>
				</div>
			</div>
            @empty
            @endforelse
        </div>
        @if (isset($args['pagination']) && ($args['pagination'] == true))
        <div class="col-lg-12">
            {!! $pages->links('elements.pagination') !!}
        </div>
        @endif
    </div>
</section>