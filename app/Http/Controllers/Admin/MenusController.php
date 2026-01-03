<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\BlogCategory;
use App\Models\Blog;
use App\Models\BlogTag;
use App\Models\Configuration;
use Str;
use Auth;
use App\Http\Traits\DzCptTrait;

class MenusController extends Controller
{
	use DzCptTrait;
	/**
	 * Display a listing of the resource.
	 * @return Renderable
	 */
	public function admin_index(Request $request, $id=null)
	{
		$page_title = __('common.menus');
		if(!empty(config('Site.menu_location'))){
			$configMenusLocations = config('menu.menu_location');
			$menusLocations = unserialize(config('Site.menu_location'));

			foreach($menusLocations as $location => $value)
			{
				if ($value['menu'] > 0 && isset($configMenusLocations[$location]['menu'])) {
					$configMenusLocations[$location]['menu'] = (int)$value['menu'];
				}
			}
			$menusLocations = $configMenusLocations;

		}
		else {
			 $menusLocations = config('menu.menu_location');
		}

		if($request->isMethod('post'))
		{

			$menuId         = $request->input('Menu.id');
			$menuTitle      = $request->input('Menu.title');
			$menuItem       = $request->input('MenuItem');
			$menuItemArr    = array();
			if(!empty($menuItem))
			{
				$i = 0;
				foreach ($menuItem as $value)
				{
					$value['order'] = $i++;
					$menuItemArr[] = $value;
				}
			}
			Menu::where('id', '=', $menuId)->update(['title' => $menuTitle]);
			$res = MenuItem::upsert($menuItemArr, ['id']);

			if($res)
			{
				/* 	For Menu Add And Update Menu Location Start */
				$postMenuLocations = $request->input('MenuLocation');

				if(!empty($postMenuLocations))
				{
					foreach($menusLocations as $location => $value)
					{
						if($menusLocations[$location]['menu'] == $menuId)
						{
							$menusLocations[$location]['menu'] = null;
						}
					}
					foreach($postMenuLocations as $location => $menuId)
					{
						$menusLocations[$location]['menu'] = $menuId['menu'];
					}
				}
				else
				{
					foreach($menusLocations as $location => $value)
					{
						if($menusLocations[$location]['menu'] == $menuId)
						{
							$menusLocations[$location]['menu'] = null;
						}
					}
				}
				$menuLocationArr = serialize($menusLocations);
				$config = New Configuration();
				$config->saveConfig('Site.menu_location', $menuLocationArr);
				/* For Menu Add And Update Menu Location Ends */
				return redirect()->route('menu.admin.admin_index', $id)->with('success', __('common.menu_items_update_success'));
			}
			return redirect()->route('menu.admin.admin_index')->with('error', __('common.something_went_wrong'));
		}

		$page       = new Page();
		$menuObj    = new Menu();
		$pages      = $menuObj->generatePageTreeListCheckbox(null, ' ');
		$categories = $menuObj->generateCategoryTreeListCheckbox(null, ' ');
		$blogs      = $menuObj->generateBlogTreeListCheckbox(null, ' ');
		$tags       = $menuObj->generateTagTreeListCheckbox(null, ' ');


		$menus      = Menu::orderBy('title', 'asc')->get();
		$menu       = Menu::with(['menu_items' => function ($query) {
						$query->where('parent_id', '=', 0);
						$query->orderBy('order', 'asc');
					}])->first();
		if($id)
		{
			$menu   = Menu::with(['menu_items' => function ($query) {
						$query->where('parent_id', '=', 0);
						$query->orderBy('order', 'asc');
					}])->where('id', $id)->FirstOrFail();
		}


		if(!empty($menu))
		{
			foreach($menu->menu_items as $menuitem )
			{
				if ($menuitem->type == 'Page'){
					$page = Page::firstWhere('id', $menuitem->item_id);
					if(empty($page)){
						$res = MenuItem::findorFail($menuitem->id)->delete();
					}
				}
				if ($menuitem->type == 'Post'){
					$blog = Blog::firstWhere('id', $menuitem->item_id);
					if(empty($blog)){
						$res = MenuItem::findorFail($menuitem->id)->delete();
					}
				}
				if ($menuitem->type == 'Category'){
					$category = BlogCategory::firstWhere('id', $menuitem->item_id);
					if(empty($category)){
						$res = MenuItem::findorFail($menuitem->id)->delete();
					}
				}
				if ($menuitem->type == 'Tag'){
					$tag = BlogTag::firstWhere('id', $menuitem->item_id);
					if(empty($tag)){
						$res = MenuItem::findorFail($menuitem->id)->delete();
					}
				}
			}
		}

		$allCpts = $this->get_cpt_screen_options(array('public' => 1), 'menu');
		$screenOption = config('menu.ScreenOption');
		$menuItems = optional($menu)->menu_items ? $menu->menu_items : array();
		return view('admin.menus.index', compact('pages', 'menus', 'menu', 'categories', 'blogs', 'tags', 'menusLocations','page_title', 'screenOption', 'menuItems', 'menuObj', 'allCpts'));
	}

	public function admin_select_menu(Request $request)
	{
		if($request->isMethod('post') && !empty($request->input('Menu.menu_id')))
		{
			$menuId   = $request->input('Menu.menu_id');
			return redirect()->route('menu.admin.admin_index', $menuId);
		}
		return redirect()->route('menu.admin.admin_index');
	}

	/**
	 * Show the form for creating a new resource.
	 * @return Renderable
	 */
	public function admin_create(Request $request)
	{
		if($request->isMethod('post'))
		{
			$this->validate($request, [
					'Menu.title'        => 'required',
					'Menu.title'        => 'unique:menus,title',
				],
			);

			$menuArr['user_id'] = Auth::id();
			$menuArr['title']   = $request->input('Menu.title');
			$menuArr['slug']    = Str::slug($request->input('Menu.title'), '-');

			$menu = Menu::create($menuArr);

			if($menu)
			{
				$menu->order = $menu->id;
				$menu->save();

				return redirect()->route('menu.admin.admin_index', $menu->id)->with('success', __('common.menu_create_success'));
			}

		}
		return redirect()->route('menu.admin.admin_index')->with('error', __('common.something_went_wrong'));
	}

	/**
	 * Remove the specified resource from storage.
	 * @param int $id
	 * @return Renderable
	 */
	public function admin_destroy(Request $request)
	{

		if($request->isMethod('post'))
		{
			$id = $request->input('menu_id');
			$res = Menu::findorFail($id)->delete();
			session()->flash('success', __('common.menu_delete_success'));
			return $res;
		}

		return false;
		exit();
	}

	public function search_menus(Request $request)
	{
		if($request->isMethod('post'))
		{
			$searchData = array();
			$searchType = $request->input('search_type');

			if($request->input('search_type') == 'page')
			{
				$searchData = Page::where('title', 'LIKE', "%{$request->input('page_key')}%")
								->where('status', '=', 1)
								->get();
			}
			else if($request->input('search_type') == 'blog')
			{
				$searchData = Blog::where('title', 'LIKE', "%{$request->input('page_key')}%")
							->where('status', '=', 1)
							->get();
			}
			else if($request->input('search_type') == 'category')
			{
				$searchData = BlogCategory::where('title', 'LIKE', "%{$request->input('page_key')}%")->get();
			}
			else if($request->input('search_type') == 'tag')
			{
				$searchData = BlogTag::where('title', 'LIKE', "%{$request->input('page_key')}%")->get();
			}
			return view('admin.menus.search_menus', compact('searchData', 'searchType'));
		}
	}

	public function ajax_menu_item_delete(Request $request)
	{
		if($request->isMethod('post'))
		{
			$id         = $request->input('item_id');

			$menu       = MenuItem::findorFail($id);
			$menuItem   = $menu;
			$menuItem->delete();
			if($menu)
			{
				$parent_id = isset($menu->parent_id) ? $menu->parent_id : 0;
				MenuItem::where('parent_id', '=', $id)->update(['parent_id' => $parent_id]);
			}
			return $menu;
		}

		return false;
		exit();
	}

	public function ajax_add_link(Request $request)
	{

		if($request->isMethod('post'))
		{

			$menuItemData = array(
							'menu_id'   => $request->input('Menu.id'),
							'parent_id' => 0,
							'title'     => $request->input('Menu.linktitle'),
							'type'      => 'Link',
							'attribute' => $request->input('Menu.linktitle'),
							'link'      => $request->input('Menu.link')
						);

			$menuItem = MenuItem::create($menuItemData);
			$menuItem->order = $menuItem->id;
			$menuItem->save();

			$screenOption = config('menu.ScreenOption');
			return view('admin.menus.ajax_add_link', compact('menuItem', 'screenOption'));
		}
	}

	public function ajax_add_page(Request $request)
	{
		if($request->isMethod('post'))
		{

			$menu_id        = $request->input('Menu.id');
			$menu_type      = $request->input('menu_type');
			$item_ids       = $request->input('MenuItem');

			if($menu_type == 'page')
			{
				$allItems   = Page::whereIn('id', $item_ids)->get();
				$linkType   = 'Page';
			}
			else if($menu_type == 'blog')
			{
				$allItems   = Blog::whereIn('id', $item_ids)->get();
				$linkType   = 'Post';
			}
			else if($menu_type == 'category')
			{
				$allItems   = BlogCategory::whereIn('id', $item_ids)->get();
				$linkType   = 'Category';
			}
			else if($menu_type == 'tag')
			{
				$allItems   = BlogTag::whereIn('id', $item_ids)->get();
				$linkType   = 'Tag';
			}
			else if(!empty($menu_type))
			{
				$allItems   = Blog::whereIn('id', $item_ids)->get();
				$linkType   = $menu_type;
			}

			$menuItemIds    = array();

			if(!empty($allItems))
			{
				foreach($allItems as $value)
				{
					// no need of link we will create link on run time according to permalink
					$menuItem = array(
								'menu_id'   => $menu_id,
								'title'     => $value->title,
								'attribute' => $value->title,
								'type'      => $linkType,
								'item_id'   => $value->id,
							);
					$res            = MenuItem::create($menuItem);
					$menuItemIds[]  = $res->id;
					$res->order     = $res->id;
					$res->save();
				}
			}
			$menuItems = MenuItem::whereIn('id', $menuItemIds)->get();
			$screenOption = config('menu.ScreenOption');
			return view('admin.menus.ajax_add_page', compact('screenOption', 'menuItems'));
		}
	}
}
