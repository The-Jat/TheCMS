<?php
namespace App\Helper;

use App\Lib\ClientInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Language;
use App\Models\Country;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\Configuration;
use Str;

class DzHelper
{

	public static function action() {
		$chunks = explode("@",Route::currentRouteAction());
		return end($chunks);
	}

	public static function controller() {
		$chunks = explode("\\",Route::currentRouteAction());
		$controller = explode("@",end($chunks));
		return $controller[0];
	}

	/********************************
	* get base url using this function
	* $key is @params
	* $key = 'AppUrl' || 'AssetUrl';
	*********************************/
	public static function GetBaseUrl($key = 'AppUrl') {

		if(Str::contains(request()->getHttpHost(), ':') && $key == 'AssetUrl')
		{
			return asset('/');
		}


		if (isset($_SERVER['HTTPS']) &&
			($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
			isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
			$_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
		{
			$protocol = 'https://';
		}
		else
		{
			$protocol = 'http://';
		}

		if (!empty($_SERVER['SUBDOMAIN_DOCUMENT_ROOT'])) {
			$_SERVER['DOCUMENT_ROOT'] = $_SERVER['SUBDOMAIN_DOCUMENT_ROOT'];
		}
		/* For All Oher Server */
		$DOCUMENT_PATH = str_replace( $_SERVER['DOCUMENT_ROOT'], '', str_replace('\\', '/', base_path()));
		$url['AppUrl'] = $protocol.request()->getHost().$DOCUMENT_PATH.'/';
		$url['AssetUrl'] = $protocol.request()->getHost().$DOCUMENT_PATH.'/public/';

		return $url[$key];
	}

	/*
    * nav_menu function use for return menu on menuLocations with view nav_menu.blade.php,
    * this function get menu name by menu locations array,
    * this function get menu items by menu name from menu model by get_nav_menu() function,
    * if menu items has child menu items then this function calls ChildMenuLink() function.
    */
	public static function nav_menu($args = array())
	{

		$theme_location 	= !empty($args['theme_location']) ? $args['theme_location'] : '';
		$menu_class 		= !empty($args['menu_class']) ? $args['menu_class'] : '';
		$menu_name 			= !empty($args['menu']) ? $args['menu'] : '';
		$menusLocations 	= unserialize(config('Site.menu_location'));

		if ($menusLocations) {
			foreach($menusLocations as $location => $value)
			{
				if (!empty($value['menu'] && $theme_location == $location)) {
					$menuName = self::getMenuTitle($value['menu']);
				}
			}
		}

		if ($menu_name) {
			$menuName = $menu_name;
		}


		if(\Schema::hasTable('menus') && !empty($menuName))
		{
			$menu = New Menu();
			$menuItems = $menu->get_nav_menu($menuName);

			if($menuItems)
			{
				foreach($menuItems as &$menuitem )
				{
					if ($menuitem->type == 'Page'){
						$menuitem->link = self::laraPageLink($menuitem->item_id);
					}
					else if ($menuitem->type == 'Post'){
						$menuitem->link = self::laraBlogLink($menuitem->item_id);
					}
					else if ($menuitem->type == 'Category'){
						$menuitem->link = self::laraBlogCategoryLink($menuitem->item_id);
					}
					else if ($menuitem->type == 'Tag'){
						$menuitem->link = self::laraBlogTagLink($menuitem->item_id);
					}
					else if (in_array($menuitem->type, self::get_post_types()->pluck('slug')->toArray())){
						$menuitem->link = self::laraBlogLink($menuitem->item_id);
					}

					if (!empty($menuitem->child_menu_items)){
						$menuitem->child_menu_items = self::ChildMenuLink($menuitem->child_menu_items);
					}
				}
			}

			$menus = $menuItems;
			return view('elements.nav_menu',compact('menus','menu_class'));
		}
		return null;
	}

	/*
    * ChildMenuLink function used by nav_menu() function for fill link column of child menu items,
    * this function put current link in menu items link column,
    * if child menu items has child then this function calls self recursively.
    */
	public static function ChildMenuLink($menuItems){
		if($menuItems)
		{
			foreach($menuItems as &$menuitem ){
				if ($menuitem->type == 'Page'){
					$menuitem->link = self::laraPageLink($menuitem->item_id);
				}
				else if ($menuitem->type == 'Post'){
					$menuitem->link = self::laraBlogLink($menuitem->item_id);
				}
				else if ($menuitem->type == 'Category'){
					$menuitem->link = self::laraBlogCategoryLink($menuitem->item_id);
				}
				else if ($menuitem->type == 'Tag'){
					$menuitem->link = self::laraBlogTagLink($menuitem->item_id);
				}
				else if (in_array($menuitem->type, self::get_post_types()->pluck('slug')->toArray())){
					$menuitem->link = self::laraBlogLink($menuitem->item_id);
				}

				if (!empty($menuitem->child_menu_items)){
					$menuitem->child_menu_items = self::ChildMenuLink($menuitem->child_menu_items);
				}
			}
		}
		return $menuItems;
	}

	/*
    * the_content function use for get data of content column of page by page id,
    * this function get page content in $pageContent from page model by $page->get_the_content($pageId) function,
    */
	public static function the_content($pageId='')
	{
		if(!empty($pageId))
		{
			$page = New Page();
			$pageContent = $page->get_the_content($pageId);
			return $pageContent;
		}
		return false;
	}
	
	/*
    * laraPageLink function use for get link of single page by page id,
    * this function get page slug in $link from page model by $page->laraPageLink($id) function,
    * if $link has no slug than $link = page id,
    * this function return page slug or id on route ('permalink.page_action').
    */
	public static function laraPageLink($id)
	{
		$page = Page::whereId($id)->orWhere('slug', $id)->first();
		if ($page && $page->id) {

			$permalink = config('Permalink.settings');

			$link = ['page_id' => $page->id];
			if($permalink)
			{
				$link = ['slug' => $page->slug];
			}

			return route('permalink.page_action', $link);
		}
		return 'javascript:void(0);';
	}

	/*
    * laraBlogLink function use for get link of  single blog by blog id,
    * this function get blog slug in $link from blog model by $blog->laraBlogLink($id) function,
    * if $link has no slug than $link = blog id,
    * this function return blog slug or id on route ('permalink.action').
    */
	public static function laraBlogLink($id)
	{
		if (Blog::whereId($id)->count() > 0) {
			$blog = New Blog();
			$link = $blog->laraBlogLink($id);
			if(empty($link))
			{
				$link = ['p' => $id];
			}
			return route('permalink.action', $link);
		}
		return 'javascript:void(0);';
	}

	/*
    * laraBlogCategoryLink function use for get link of blog category by category id,
    * this function get category slug in $link from blog model by $blog->laraBlogCategoryLink($id) function,
    * this function return category slug on route ('permalink.category_action').
    */
	public static function laraBlogCategoryLink($id)
	{
		if (BlogCategory::whereId($id)->count() > 0) {

			$blog = New Blog();
			$link = $blog->laraBlogCategoryLink($id);
			return route('permalink.category_action', $link);
		}
		return 'javascript:void(0);';
	}

	/*
    * laraBlogTagLink function use for get link of blog tag by tag id,
    * this function get tag title in $link from blog model by $blog->laraBlogTagLink($id) function,
    * this function return tag name on route ('permalink.blogtag_action').
    */
	public static function laraBlogTagLink($id)
	{
		if (BlogTag::whereId($id)->count() > 0) {

			$blog = New Blog();
			$link = $blog->laraBlogTagLink($id);
			return route('permalink.blogtag_action', $link);
		}
		return 'javascript:void(0);';
	}

	/*
    * laraBlogArchiveLink function use for get link of blog archive by year and month,
    * this function return array of month and year on route ('permalink.archive_action').
    */
	public static function laraBlogArchiveLink($yy,$mm)
	{
		$link = [
			'year' 	=> $yy,
			'month' => $mm
		];
		return route('permalink.archive_action', $link);
	}

	/*
    * author function use for get link of blog or page author by author id,
    * this function get author name in $name from blog model by $blog->author($id) function,
    * this function return author name on route ('permalink.author_action').
    */
	public static function author($id)
	{
		$blog = New Blog();
		$name = $blog->author($id);
		return route('permalink.author_action', $name);
	}

    /*
    * siteLogo function use for get site Logo from configurations,
    */
	public static function siteLogo()
	{

		$logo = config('ThemeOptions.site_logo');
		if(empty($logo))
		{
			return asset('images/'.config('menu.Site.logo-dark'));
		}
		return asset('storage/configuration-images/'.$logo);
	}


	public static function siteLogoLight()
	{
		$logo = config('ThemeOptions.site_other_logo');
		if(empty($logo))
		{
			return asset('images/'.config('menu.Site.logo'));
		}
		return asset('storage/configuration-images/'.$logo);
	}

	/*
    * siteFooterText function use for get site footer text from configurations,
    */
	public static function siteFooterText()
	{
		$text = config('Site.footer_text');
		if(empty($text))
		{
			return __('© 2022. All Rights Reserved.');
		}
		return $text;
	}
	/*
    * siteCopyrightText function use for get site copyright text from configurations,
    */
	public static function siteCopyrightText()
	{
		$text = config('Site.copyright');
		if(empty($text))
		{
			return __('© 2022. All Rights Reserved.');
		}
		return $text;
	}

	/*
    * getMenuTitle function use for get menu title by id,
    */
	public static function getMenuTitle($id=null)
	{
        $menu = Menu::select('slug')->where('id', '=', $id)->first();
        return isset($menu->slug) ? $menu->slug : '';
    }

	/*
    * getBlogTitle function use for get blog title by id,
    */
	public static function getBlogTitle($id=null)
	{
        $blog = Blog::select('title')->where('id', '=', $id)->orWhere('slug', '=', $id)->first();
        return isset($blog->title) ? $blog->title : '';
    }

    /*
    * getPageTitle function use for get page title by id,
    */
	public static function getPageTitle($id=null)
	{
        $page = Page::select('title')->where('id', '=', $id)->first();
        return isset($page->title) ? $page->title : '';
    }


    /*
    * getChildPage function use for get child pages of parent page,
    * this function used in page.blade.php(single page detail),
    * if child page has child page then this function calls recursively(self::getChildPage()).
    */
	public static function getChildPage($child_pages)
	{
        if(!empty($child_pages))
		{
        	$res[] = '<ul class="sub-child-page ps-4">';
			foreach ($child_pages as $child_page) {
				$res[] = '<li> <a href="'.self::laraPageLink($child_page->id).'" class="pl-2 ">'.$child_page->title.'</a>';
				if ($child_page->child_pages->isNotEmpty()) {
					$res[] = self::getChildPage($child_page->child_pages);
				}
				$res[] = '</li>';
			}
			$res[] = '</ul>';
		}

		return $res ? implode(' ', $res) : '';
    }

    /*
    * dzSortable function use for sorting record
    * $column has column name if have relation in column than explode with '.',
    * $title has column display title.
    */
	public static function dzSortable($column, $title)
    {
		$columns = explode('.', $column);
		$column = $columns[0];
		$params = request()->except('sort', 'direction', 'with');
		$direction = 'asc';
		if(request()->get('direction') == 'asc'){
			$direction = 'desc';
		}
		$sortUri = ['sort' => $column, 'direction' => $direction];
		if(isset($columns[1]) && !empty($columns[1]))
		{
			$sortUri['with'] = $columns[1];
		}
		$uriString = array_merge($params, $sortUri);
		$url = url()->current().'?'.http_build_query($uriString);
		return '<a href="'.$url.'">'.$title.'<i class="fa fa-sort '.$direction.'"></i></a>';
    }

    /*
    * dzHasSidebar function use for checking site has sidebar or not.
    * this function returns boolean value true or false.
    * this function used for column class "col-8" or "col-12".
    */
    public static function dzHasSidebar()
    {

	    $col_class = false;
        $allconfigs = Configuration::where('name', 'LIKE', "%Widget%")->pluck('name', 'value');
	    foreach($allconfigs as $key => $value){
			if ($key){
				$col_class = true;
				break;
			}
	    }
	    return $col_class;

    }

    public static function getBlogShareButton($title, $permalink, $image){

    	$social_btns = array(
    					'facebook'=> array(
    						'icon' => 'fab fa-facebook-f'
    					),
    					'twitter'=> array(
    						'icon' => 'fab fa-twitter'
    					),
    					'linkedin'=> array(
    						'icon' => 'fab fa-linkedin-in'
    					),
    					'pinterest'=> array(
    						'icon' => 'fab fa-pinterest'
    					)
    				);

    	$social_share_link	= array(
			'facebook'=>'http://www.facebook.com/sharer.php?u='.$permalink,
			'twitter'=>'https://twitter.com/share?url='.$permalink.'&text='.$title,
			'google-plus'=>'https://plus.google.com/share?url='.$permalink,
			'linkedin'=>'http://www.linkedin.com/shareArticle?url='.$permalink.'&title='.$title,
			'pinterest'=>'http://pinterest.com/pin/create/button/?url='.$permalink.'&media='.$image.'&description='.$title,
			'reddit'=>'http://reddit.com/submit?url='.$permalink.'&title='.$title,
			'tumblr'=>'http://www.tumblr.com/share/link?url='.$permalink.'&name='.$title,
			'digg'=>'http://digg.com/submit?url='.$permalink.'&title='.$title,
		);


    	$output = '<ul class="social-link-round">';

        $output .= '<li class="link-ic"><a href="javascript:void(0);" class="btn-link share"><i class="la la-share-alt"></i></a></li>';


        foreach($social_btns as $key => $social_btn){
        	$output .= '<li><a target="_blank" href="'.$social_share_link[$key].'" class="btn-link"><i class="'.$social_btn['icon'].'"></i></a></li>';
        }

        $output .= '</ul>';

        return $output;

    }

    public static function RequiredFieldIndicator()
    {
		return '<span class="text-danger"> * </span>';
    }

    public static function getIpInfo()
    {
        $ipInfo = ClientInfo::ipInfo();
        return json_decode(json_encode($ipInfo), true);
    }

    public static function osBrowser()
    {
        $osBrowser = ClientInfo::osBrowser();
        return $osBrowser;
    }

    public static function getLanguages()
    {
        $langBasePath = base_path('lang');
        $files = scandir($langBasePath);

        $languages = [];

        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $language = pathinfo($file, PATHINFO_FILENAME);
                $languages[$language] = self::getLanguageFiles($language);
            }
        }
        return $languages;
    }

    public static  function getLanguageFiles($language)
    {
        $langBasePath = base_path('lang').'/'.$language;
        $files = scandir($langBasePath);
        $langFiles = [];
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $langFiles[] = pathinfo($file, PATHINFO_FILENAME);
            }
        }
        return $langFiles;
    }

	/**
	 * this healper method is used to change admin in multiple language
	 */
	public static function admin_lang($text)
	{ 
        $lang_file = "common";
        $LangArray = \Lang::get('common'); 
		$translation_key = preg_replace('/[^a-z0-9_]+/i', '_', strtolower(trim($text)));
		$translation_key = trim($translation_key, '_');
		$translation = __($lang_file.'.'.$translation_key);//dump($translation);
		if(array_key_exists($translation_key, $LangArray)){
			
			return $translation;
		}else{
			return $text;
		}
	}

	/**
	 * this healper method is used to change website in multiple language
	 */
	public static function theme_lang($text)
	{
        $lang_file = "theme";
        $LangArray = \Lang::get('theme'); 
		$translation_key = preg_replace('/[^a-z0-9_]+/i', '_', strtolower(trim($text)));
		$translation_key = trim($translation_key, '_');
		$translation = __($lang_file.'.'.$translation_key);
		if(array_key_exists($translation_key, $LangArray)){
			return $translation;
		}else{
			return $text;
		}
	}

    /**
     * this helper method is use for get all install languages
     */
    public static function getInstalledLanguage(){
        $allinstalledlanguage = dzHelper::getLanguages();
        $alllanguages = config('lang');
        return array_intersect_key($alllanguages,$allinstalledlanguage);
    }

    /**
     * method is use for change Language Select Box Position on frontend
     */
    public static function languageBoxPosition(){

        $flag=' ';
        if(config('Reading.multi_lang_theme') == 1  && config('Reading.lang_position') == 'Footer'){
           $flag='Footer';
        }else if(config('Reading.multi_lang_theme') == 1  && config('Reading.lang_position')=='Header'){
            $flag='Header';
        }else{
            $flag=' ';
        }
        return $flag;
    }

    public static function languageSelectBoxStyle(){

    	if(empty(session()->get('language')) && config('language','Site.w3cms_locale') !='')
    	{
            session()->put(config('language',config('Site.w3cms_locale')));
    	}
        if(empty(session()->get('language')) && config('language','Site.w3cms_locale') ==''){
            session()->put('language','en');
        }

   		$langPath = base_path('lang');
        $directories = \File::directories($langPath);

        foreach ($directories as $value) {
            $available_langs[] = basename($value);
        }

        if(config('Reading.language_widgets')  == '1'){
            $records = dzHelper::getMainLanguage();
           	return view('selectbox.selectbox_one',compact('records','available_langs'));
        }
        else if(config('Reading.language_widgets') =='2'){
            $records = dzHelper::getLanguageBySorting();
            return view('selectbox.selectbox_two',compact('records','available_langs'));
        }
        else if(config('Reading.language_widgets') =='3'){
            $records = dzHelper::getLanguageBySorting();
            return view('selectbox.selectbox_three',compact('records','available_langs'));
        }
        else if(config('Reading.language_widgets') =='4'){
            $records = dzHelper::getMainLanguage();
            return view('selectbox.selectbox_four',compact('records','available_langs'));
        }
        else if(config('Reading.language_widgets') =='5'){
            $records = dzHelper::getLanguageBySorting();
            return view('selectbox.selectbox_five',compact('records','available_langs'));
        }
        else if(config('Reading.language_widgets') =='6'){
            $records = dzHelper::getLanguageBySorting();
            return view('selectbox.selectbox_six',compact('records','available_langs'));
        }
        else{
            $records = Language::with('countries')->get();
            return view('selectbox.selectbox_six',compact('records','available_langs'));
        }

    }

    public  static function getMainLanguage(){
        $inputArray = config('lang-countries');

        $uniqueArray = [];
        $uniqueCountryIds = [];

        foreach ($inputArray as $item) {
            $countryId = $item["country_id"];

            if (!in_array($countryId, $uniqueCountryIds)) {
                $uniqueArray[] = $item;
                $uniqueCountryIds[] = $countryId;
            }
        }
        return $uniqueArray;
    }

    public static  function getLanguageBySorting(){

        $lang = config('lang-countries');
        return $lang;
    }

    public static function gatCountryList(){
        return $country = Country::all();
    }

    public static function checkCommentBlogExist($id,$type){
        if($type == 1){
            return Blog::where('status','3')->where('id',$id)->count();
        }
    }


    /*
    * Check for image , If image is not exist return NoImage,
    */
	public static function getStorageImage($path=null)
	{
		$filePath = str_replace('storage', 'public', $path);
		$absolutePath = \Storage::disk('local')->path($filePath);
    
		if(!empty($path) && \Storage::exists($filePath) && is_file($absolutePath)) 
		{
			return asset($path);
		}
		return asset('images/noimage.jpg');
	}

    /*
    * Used for getting name of frontend active theme,
    */
	public static function getFrontendThemeName()
	{
		$themeFullName = \Config::get('Theme.select_theme');
		return $themeName = $themeFullName ? explode('/', $themeFullName)[1] : 'lemars';
	}

	public static function getSidebarsList()
	{
		$sidebars = Blog::where('status','1')->where('post_type','sidebars')->whereHas('blog_meta', function($q){
							    $q->where('value', 'sidebar');
							})->get()->pluck('title','slug')->toArray();
		return $sidebars;
	}

	public static function getSidebar($slug)
	{
		$sidebar = Blog::where('slug',$slug)->where('status','1')->where('post_type','sidebars')->first();
		return $sidebar;
	}

	public static function getSidebarWidgets($slugsArr = null)
	{
		$widgets = array();
		if (is_array($slugsArr) && !empty($slugsArr)) {
			$widgets = Blog::whereIn('slug',$slugsArr)->where('status','1')->where('post_type','widgets')->orderByRaw('FIELD(slug, "'.implode('", "', $slugsArr).'")')->get();
		}

		return $widgets;
	}

	public static function getAllWidgetsList()
	{
		$widgets = Blog::where('status','1')->where('post_type','widgets')->get()->pluck('title','slug')->toArray();
		return $widgets;
	}

	public static function getCategoryBlogCount($id)
	{
		$category  = BlogCategory::whereId($id)->withCount(['blog' => function($query) {
            $query->WherePublishBlog()->CheckBlogVisibility();
        }])->first();
        $blog_count = optional($category)->blog_count ?? 0;
		return $blog_count;
	}

	public static function extractImagesFromContent($content)
	{
		ini_set('max_execution_time', 300);
		$pattern = '/https?:\/\/[^",]+(?:\.png|\.jpe?g|\.webp|\.gif|\.svg)/i';
		
		if (preg_match($pattern, $content)) {
			preg_match_all($pattern, urldecode(html_entity_decode($content)), $matches);
			$imageUrls = $matches[0];
			foreach ($imageUrls as $url) {
				$imageName = self::downloadAndSaveImage($url);
		        $content = Str::replace($url, $imageName, $content);
		    }
	    }

	    return $content;


	}

	public static function downloadAndSaveImage($url)
	{
		if (preg_match('/https?:\/\/[^",]+(?:\.png|\.jpe?g|\.webp|\.gif|\.svg)/i', $url)) {
		    $imageName = basename($url);
			$storage_directory = explode('/public/storage/', $url);
		    $storage_path = str_replace('/', DIRECTORY_SEPARATOR, $storage_directory[1]);
	        $localFilePath = storage_path("app" . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . $storage_path);

			try {
		    	if (!file_exists($localFilePath)) {
		    	
		    	    $imageContent = file_get_contents($url);

			        if (!file_exists(dirname($localFilePath))) {
			            mkdir(dirname($localFilePath), 0755, true);
			        }

			        file_put_contents($localFilePath, $imageContent);

		    	}

		        return $imageName;
		    } catch (\Exception $e) {
		        return null;
		    }
		}
		else{
			return $url;
		}
	}

	public static function get_post_types()
	{
		return $cpts = Blog::wherePostType('cpt')->where('status', 1)->whereNotIn('slug', ['widgets','sidebars'])->get();
	}


}
