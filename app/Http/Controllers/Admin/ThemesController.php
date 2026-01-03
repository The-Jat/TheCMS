<?php

namespace App\Http\Controllers\Admin;

use Hexadog\ThemesManager\Facades\ThemesManager;
use Hexadog\ThemesManager\Facades\Theme;
use App\Http\Traits\DzImportTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Configuration;
use App\Models\Page;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\Menu;
use ZipArchive;
use File;
use Str;

class ThemesController extends Controller
{
	use DzImportTrait;
	/**
	 * Get all themes.
	 * Important for get composer
	 * use this to get description -> $themes['hexadog/bodyshape']->get('description');
	 *
	 * @return mixed
	 */
	public function index(Request $request)
	{

		$page_title = __('common.themes');
		
		$themes     = ThemesManager::all()->toArray();
		$themes     = \Arr::where($themes, function ($item) {
						return $item->getVendor() == 'frontend';
					});
		$currentTheme   = \DzHelper::getFrontendThemeName();

		if($request->isMethod('get'))
		{
			if ($request->get('activate')) {

				$themeName = $request->get('activate');
				$config = New Configuration();
				$config->saveConfig('Theme.select_theme', $themeName);
				return redirect()->route('themes.admin.index')->with('success', __('common.theme_activate_success'));
				
			}
		}

		return view('admin.themes.index', compact('themes', 'currentTheme', 'page_title'));
	}

	public function admin_themes(Request $request)
	{

		$page_title = __('common.themes');
		$themes     = ThemesManager::all()->toArray();
		$themes     = \Arr::where($themes, function ($item) {
						return $item->getVendor() == 'admin';
					});
		$currentTheme   = ThemesManager::current() ? ThemesManager::current()->getName() : '';

		if($request->isMethod('get'))
		{
			if ($request->get('activate')) {

				$themeName = $request->get('activate');
				$config = New Configuration();
				$config->saveConfig('Theme.select_admin_theme', $themeName);

				return redirect()->route('themes.admin.admin_themes')->with('success', __('common.theme_activate_success'));
			}
		}

		return view('admin.themes.index', compact('themes', 'currentTheme', 'page_title'));
	}

	public function import_theme(Request $request)
	{
		if($request->isMethod('post'))
		{

			$xml = simpleXML_load_file($request->db_file);
			$user_id = \Auth::user()->id;

			if($request->input('import_type') == 'draft')
			{
				Blog::where('post_type', '=', config('blog.post_type'))->update(['status' => 2]);
				Page::query()->update(['status' => 2]);
				Menu::with('menu_items')->delete();
			}
			else if($request->input('import_type') == 'delete')
			{
				Blog::with('blog_categories', 'blog_tags', 'blog_seos', 'blog_metas')->delete();
				BlogCategory::query()->delete();
				BlogTag::query()->delete();
				Page::with('page_metas', 'page_seos')->delete();
				Menu::with('menu_items')->delete();
			}

			$message = $this->importData($xml, $user_id);
			return redirect()->back()->with('success', $message);
		}
	}

	public function add_theme(Request $request)
	{
		$themes = $this->getApiThemes();

		$currentTheme   = config('Theme.select_theme');

		$page_title = __('common.add_theme');
		if($request->isMethod('post'))
		{
			if($request->input('search_apps'))
			{
				$themes = $this->getApiThemes($request->input('search_apps'));
				return view('admin.themes.ajax_theme', compact('themes', 'currentTheme'));
			}
			else if($request->file('theme_zip'))
			{
				$file       = $request->file('theme_zip');
				$fileName   = $file->getClientOriginalName();
				$request->file('theme_zip')->storeAs('frontend', $fileName, 'themes');
				$zipPath = base_path('themes/frontend/' . $fileName);

				// Extract the file
				$zip = new ZipArchive;
				$themename = '';
				if ($zip->open($zipPath) === true) {
					$zip->extractTo(base_path('themes/frontend/'));
					$themename = trim($zip->getNameIndex(0), '/');
					$zip->close();
					unlink($zipPath);
					$active_theme = route('themes.admin.index', ['activate' => 'frontend/'.$themename]);
					return view('admin.themes.add_theme', compact('page_title', 'active_theme', 'themename'));
				}
			}
		}
		return view('admin.themes.add_theme', compact('page_title', 'themes', 'currentTheme'));
	}
    public function add_admin_theme(Request $request)
	{
		$themes = $this->getApiThemes(['search_apps' => $request->input('search_apps'), 'type' => 'A']);
		$currentTheme   = config('Theme.select_admin_theme');

		$page_title = __('common.add_admin_theme');
		if($request->isMethod('post'))
		{
			if($request->input('search_apps'))
			{
				$themes = $this->getApiThemes(['search_apps' => $request->input('search_apps'), 'type' => 'A']);
				return view('admin.themes.ajax_theme', compact('themes', 'currentTheme'));
			}
			else if($request->file('theme_zip'))
			{
				$file       = $request->file('theme_zip');
				$fileName   = $file->getClientOriginalName();
				$request->file('theme_zip')->storeAs('admin', $fileName, 'themes');
				$zipPath = base_path('themes/'.config('constants.themes_root.0').'/'. $fileName);

				// Extract the file
				$zip = new ZipArchive;
				$themename = '';
				if ($zip->open($zipPath) === true) {
					$zip->extractTo(base_path('themes/'.config('constants.themes_root.0').'/'));
					$themename = trim($zip->getNameIndex(0), '/');
					$zip->close();
					unlink($zipPath);
					$active_theme = route('themes.admin.admin_themes', ['activate' => config('constants.themes_root.0').'/'.$themename]);
					return view('admin.themes.add_admin_theme', compact('page_title', 'active_theme', 'themename'));
				}
			}
		}
		return view('admin.themes.add_admin_theme', compact('page_title', 'themes', 'currentTheme'));
	}
	private function getApiThemes($searchTxt=Null)
	{
		$url = config('constants.themes_api');
		$response = Http::withHeaders([
			'User-Agent'    => 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:41.0) Gecko/20100101 Firefox/41.0',
		])->get($url, ['search_apps' => $searchTxt]);

		$themes = optional($response->object())->themes;

		return $this->checkInstalledTheme($themes);
	}

	private function checkInstalledTheme($themes)
	{
		$installedThemes = $this->getAllThemeNames();

		if(!is_null($themes) && !empty($themes))
		{
			foreach ($themes as $key => $value) {
				$value->installed = false;
				if(in_array($value->slug, $installedThemes))
				{
					$value->installed = true;
				}
				$themes[$key] = $value;
			}

			return $themes;
		}

		return array();
	}

	public function install_theme(Request $request)
	{
		if($request->isMethod('post') && $request->input('package'))
		{
			$url = $request->input('package');

			$themename = $request->input('themename');
			$filename = basename($url);
			$zipPath = base_path('themes/frontend/' . $filename);
			$extractPath = base_path('themes/frontend/');

			$ch = curl_init($url);
			$fp = fopen($zipPath, 'w');
			curl_setopt($ch, CURLOPT_FILE, $fp);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_exec($ch);
			curl_close($ch);
			fclose($fp);

			// Extract the file
			$zip = new ZipArchive;
			if ($zip->open($zipPath) === true) {
				$zip->extractTo($extractPath);
				$zip->close();
				unlink($zipPath);
				return response()->json( array('success' => true, 'active_theme' => route('themes.admin.index', ['activate' => 'frontend/'.$themename])) );
			}
		}
		return response()->json( array('success' => false) );
	}

	public function install_upload_theme(Request $request)
	{
		if($request->isMethod('post') && $request->file('theme_zip'))
		{
			$file       = $request->file('theme_zip');
			$fileName   = $file->getClientOriginalName();
			$request->file('theme_zip')->storeAs('frontend', $fileName, 'themes');
			$zipPath = base_path('themes/frontend/' . $fileName);

			// Extract the file
			$zip = new ZipArchive;
			$themename = '';
			if ($zip->open($zipPath) === true) {
				$zip->extractTo($extractPath);
				$themename = $zip->getNameIndex(0);
				$zip->close();
				unlink($zipPath);
				return response()->json( array('success' => true, 'active_theme' => route('themes.admin.index', ['activate' => 'frontend/'.$themename])) );
			}
		}
		return response()->json( array('success' => false) );
	}

	private function getAllThemeNames()
	{
		$themes = ThemesManager::all()->toArray();
		$themeNames = array();
		foreach ($themes as $value) {
			$themeNames[] = $value->getName();
		}

		return $themeNames;
	}

	public function delete(Request $request)
	{
		if($request->get('theme'))
		{
			$zipPath = base_path('themes/frontend/' . $request->get('theme'));
			$res = File::deleteDirectory($zipPath);

			if($res)
			{
				return redirect()->back()->with('success', __('Theme deleted successfully.'));
			}
		}
		return redirect()->back()->with('error', __('Something went wrong with deleting theme.'));
	}
}
