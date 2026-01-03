<?php

namespace Modules\CustomField\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Mail;

class ModuleController extends Controller
{
	use ValidatesRequests;

	function __construct()
	{
	}

	protected function __imageSave($request, $key='', $folder_name='', $old_img='')
	{
		$fileName = "";
		if($request->hasFile($key) && !empty($key) && !empty($folder_name)) { 
			$image = $request->file($key);
			$OriginalName = $image->getClientOriginalName();
			$fileName = time().'_'.$OriginalName;
			$request->file($key)->storeAs('public/'.$folder_name.'/', $fileName);
			if(!empty($old_img)) {
				if (Storage::exists('public/'.$folder_name.'/', $old_img)) {
					Storage::delete('public/'.$folder_name.'/'.$old_img);
				}
			}
		}

		return $fileName;
	}
}
