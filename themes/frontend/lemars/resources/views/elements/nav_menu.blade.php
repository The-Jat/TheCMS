@php
	$menu_class = !empty($menu_class) ? $menu_class : 'nav navbar-nav navbar navbar-left';
@endphp
<ul class="{{ $menu_class }}">
	@if ($menus)
		@foreach ($menus as $menuitem)
			@php
				$active = '';
				if (Request::url() == $menuitem->link) {
					$active = 'active';
				}
				$sub_menu_class = $menuitem->child_menu_items->isNotEmpty() ? 'sub-menu-down' : '' ;
			@endphp
			<li class="{{ $sub_menu_class }} {{ $active }}">
				@if ($menuitem->child_menu_items->isNotEmpty())
					<a href="{{ $menuitem->link }}" {{ ($menuitem->menu_target == 1) ? 'target="_blank"' : '' ; }} class="{{ $menuitem->css_classes }}" title="{{ $menuitem->attribute }}">{{ DzHelper::theme_lang($menuitem->title) }}<i class="fas fa-chevron-down"></i></a>
					@include('elements.nav_menu', ['menus' => $menuitem->child_menu_items, 'menu_class' => 'sub-menu'])
				@else
					<a href="{{ $menuitem->link }}" {{ ($menuitem->menu_target == 1) ? 'target="_blank"' : '' ; }} class="{{ $menuitem->css_classes }}" title="{{ $menuitem->attribute }}">{{ DzHelper::theme_lang($menuitem->title) }}</a>
				@endif
			</li>
		@endforeach
	@endif
</ul>
