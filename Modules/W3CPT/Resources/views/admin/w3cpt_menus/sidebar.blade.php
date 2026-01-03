@forelse($menus as $key => $value)

	@if(empty($value['cpt_show_in_menu']))
		@continue
	@endif

@php
	$taxonomies = isset($value['cpt_builtin_taxonomies']) ? unserialize($value['cpt_builtin_taxonomies']) : array();
@endphp
	<li>
		<a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
			<i class="{{ empty($value['cpt_icon_slug']) ? 'flaticon-381-push-pin' : $value['cpt_icon_slug'] }}"></i>
			<span class="nav-text">{{ $value['cpt_label'] }}</span>
		</a>
		<ul aria-expanded="false">
			<li><a href="{{ route('cpt.blog.admin.index', ['post_type' => $value['cpt_name']]) }}">{{ $value['cpt_label'] }}</a></li>
			<li><a href="{{ route('cpt.blog.admin.create', ['post_type' => $value['cpt_name']]) }}">{{ __('common.add') }} {{ $value['cpt_label'] }}</a></li>
			@if(in_array('category', $taxonomies))
				<li><a href="{{ route('cpt.blog_category.admin.list', ['post_type' => $value['cpt_name']]) }}">{{ __('Categories') }}</a></li>
			@endif
			@if(in_array('post_tag', $taxonomies))
				<li><a href="{{ route('cpt.blog_tag.admin.list', ['post_type' => $value['cpt_name']]) }}">{{ __('Tags') }}</a></li>
			@endif
			@if(!empty($value['taxo']))
				@foreach($value['taxo'] as $taxo)
					<li><a href="{{ route('cpt.blog_category.admin.list', ['post_type' => $value['cpt_name'], 'taxonomy' => $taxo['cpt_tax_name']]) }}">{{ __($taxo['cpt_tax_label']) }}</a></li>
				@endforeach
			@endif
		</ul>
	</li>
@empty
@endforelse