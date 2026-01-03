<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\DzImportTrait;
use App\Models\BlogCategory;
use App\Models\User;

class ToolsController extends Controller
{
	use DzImportTrait;

    public function export(Request $request)
    {

    	$page_title 	= __('common.export');
		$filename 		= 'w3cms-'.date('Y-M-d').'.xml';
		$categories 	= BlogCategory::get();
		$blogUsers 		= User::select('id', 'first_name', 'last_name', 'email')->has('blog')->get();
		$pageUsers 		= User::select('id', 'first_name', 'last_name', 'email')->has('page')->get();
		$blogStatus 	= config('blog.status');
		$pageStatus 	= config('page.status');

		if($request->isMethod('post'))
		{
			return $this->exportData($request, $filename);
		}

	    return view('admin.tools.export', compact('page_title', 'categories', 'blogUsers', 'blogStatus', 'pageUsers', 'pageStatus'));
    }

    public function import(Request $request)
    {
    	$page_title 	= __('common.import');
    	$users 			= User::all();

    	if($request->isMethod('post'))
		{
            
			/*================ save uploaded file in folder and get xml ================*/
			$request->validate([
			    'xml_file' 	=> 'required|file|mimetypes:application/xml,text/xml',
			    'user_id' 	=> 'required'
			]);
			$path = $request->file('xml_file')->storeAs('public/system-import-data', 'w3cms-import.xml');
			$xml = simplexml_load_file(storage_path().'/app/'.$path);
			$user_id = $request->user_id;
			/*================ save uploaded file in folder and get xml ================*/

			$message = $this->importData($xml, $user_id);

	    	return redirect()->back()->with('success', $message);
		}

    	return view('admin.tools.import', compact('page_title', 'users'));
    }
}
