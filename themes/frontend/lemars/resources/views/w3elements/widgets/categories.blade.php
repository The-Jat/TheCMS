@php
    if (!empty($args['show_hierarchy'])) {
        $categoryObj = new \app\models\BlogCategory();
        $categories = $categoryObj->generateCategoryTreeList();
    }else{
        $blogObj = new \app\models\Blog();
        $categories = $blogObj->categoryWidget()->pluck('title','id')->toArray();
    }
@endphp

<div class="widget widget_categories">
    <h6 class="widget-title"><span>{{ $args['title'] ?? __('Categories') }}</span></h6>
    <ul>
        @forelse($categories as $id => $title)
            <li class="cat-item">
                <a href="{{ DzHelper::laraBlogCategoryLink($id) }}">{{ $title }} </a>
                @if (!empty($args['show_post_counts']))
                    {{DzHelper::getCategoryBlogCount($id)}} 
                @endif
            </li>
        @empty
        @endforelse
    </ul>
</div>