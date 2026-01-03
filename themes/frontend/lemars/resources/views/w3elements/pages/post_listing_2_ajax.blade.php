@forelse($blogs as $blog)
<div class="col-lg-4">
	<div class="blog-card post-grid grid-style m-b30">
		<div class="blog-card-media">
			<img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$blog->feature_img->value) }}" alt="{{ DzHelper::theme_lang('Blog Image') }}">
		</div>
		<div class="blog-card-info">
			<div class="title-sm"><a href="javascript: void(0);">{{ isset($blog->blog_categories[0]) ? DzHelper::theme_lang($blog->blog_categories[0]['title']) : '' }}</a></div>
			<h5 class="font-20"><a href="{{ DzHelper::laraBlogLink($blog->id) }}">{{ isset($blog->title) ? Str::limit(DzHelper::theme_lang($blog->title), 18, ' ...') : '' }}</a></h5>
		</div>
	</div>
</div>
@empty
@endforelse
