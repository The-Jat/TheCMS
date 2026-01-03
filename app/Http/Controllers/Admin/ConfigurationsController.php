<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helper\dzHelper;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\Language;
use App\Models\Page;
use App\Models\Role;
use Storage;
use Str;
use Carbon\Carbon;

class ConfigurationsController extends Controller
{
    public function admin_index(Request $request) {
        $page_title = __('common.configuration');

        $resultQuery = Configuration::select('id', 'name', 'value');

        if($request->isMethod('get') && $request->input('todo') == 'Filter')
        {
            if($request->filled('title')) {
                $resultQuery->where('title', 'like', "%{$request->input('title')}%");
            }
            if($request->filled('name')) {
                $resultQuery->where('name', 'like', "%{$request->input('name')}%");
            }
        }
        $configurations = $resultQuery->orderBy('order')->paginate(config('Reading.nodes_per_page'));
        return view('admin.configurations.admin_index', compact('configurations', 'page_title'));

    }

    public function admin_prefix(Request $request, $prefix = NULL) {
        $page_title = __('common.configuration');

        if($request->isMethod('post')) {

            if($request->has('Configuration')) {
                $newArr = array();
                $fileNameArr = $this->__imageSave($request);

                foreach ($request->input('Configuration') as $key => $config_value) {


                    if(!isset($config_value['value']) && $config_value['input_type'] == 'checkbox') {
                        $config_value['value'] = 0;
                    }
                    else if($config_value['input_type'] == 'multiple_checkbox') {
                        if (isset($config_value['value']) ){

                            $config_value['value'] = array_keys($config_value['value']);
                            $config_value['value'] = implode(',',  $config_value['value']);
                        }
                        else {
                            $config_value['value'] = '';
                        }
                    }
                    else if(isset($config_value['value'])) {
                        $config_value['value'] = $config_value['value'];


                    }
                    if(array_key_exists($key, $fileNameArr))
                    {
                        $config_value['value'] = $fileNameArr[$key];
                    }
                    $res = Configuration::where('id', '=', $key)->update($config_value);
                }
                return redirect()->back()->with('success', __('common.config_update_success'));
            } else
            {
                return redirect()->back()->with('error', __('common.problem_in_form_submition'));
            }
        } else {
            $page_title = $prefix;
            if($prefix == 'Permalink')
            {
                $routesType = array(
                                'Plain'             => '',
                                'DayName'           => '/%year%/%month%/%day%/%slug%/',
                                'MonthName'         => '/%year%/%month%/%slug%/',
                                'Numeric'           => '/archives/%post_id%',
                                'PostName'          => '/%slug%/',
                                'CustomeStructure'  => 'custom',
                            );
                $configuration = Configuration::select('id', 'name', 'value', 'title', 'description', 'input_type', 'editable', 'weight', 'params')->where('name', 'LIKE', $prefix.'%')->first();
                return view('admin.configurations.admin_permalink_prefix', compact('configuration', 'prefix', 'routesType','page_title'));
            }
            else if($prefix == 'Site')
            {
                return $this->admin_site($request, $prefix);
            }
            else if($prefix == 'Discussion')
            {
                return $this->admin_discussion($request, $prefix);
            }
            else if($prefix == 'Environment')
            {
                return $this->admin_environment($request, $prefix);
            }
            $configurations = Configuration::select('id', 'name', 'value', 'title', 'description', 'input_type', 'editable', 'weight', 'params', 'order')->where('name', 'LIKE', $prefix.'%')->orderBy('order', 'asc')->get();

            return view('admin.configurations.admin_prefix', compact('configurations', 'prefix','page_title'));
        }
    }

    public function admin_view($id = null) {
        $configuration = Configuration::select('id', 'name', 'value')->firstWhere('id', $id);
        return view('admin.configurations.admin_view', compact('configuration'));
    }

    public function admin_add(Request $request){
        if($request->isMethod('post')) {

            $validation = $this->validate($request, [
                    'Configuration.name' => 'required|unique:configurations,name',
                ]
            );

            $new_configuration = [
                'name'              => $request->input('Configuration.name'),
                'value'             => $request->input('Configuration.value'),
                'title'             => $request->input('Configuration.title'),
                'input_type'        => $request->input('Configuration.input_type'),
                'description'       => $request->input('Configuration.description') ? $request->input('Configuration.description') : '',
                'params'            => $request->input('Configuration.params') ? $request->input('Configuration.params') : '',
                'editable'          => $request->input('Configuration.editable') ? 1 : 0,
            ];

            $res = Configuration::create($new_configuration);

            if($res)
            {
                return redirect()->route('admin.configurations.admin_index')->with('success', __('common.config_add_success'));
            } else
            {
                return redirect()->route('admin.configurations.admin_index')->with('error', __('common.problem_in_form_submition'));
            }
        } else {
            return view('admin.configurations.admin_add');
        }
    }

    public function admin_edit(Request $request, $id) {
        $configuration = Configuration::findorFail($id);

        if($request->isMethod('post')) {

            $validation = $this->validate($request, [
                    'Configuration.name' => 'required|unique:configurations,name,'.$id,
                ]
            );

            $edit_configuration = [
                'name'                  => $request->input('Configuration.name'),
                'value'                 => $request->input('Configuration.value'),
                'title'                 => $request->input('Configuration.title'),
                'input_type'            => $request->input('Configuration.input_type'),
                'description'           => $request->input('Configuration.description'),
                'params'                => $request->input('Configuration.params'),
                'editable'              => $request->input('Configuration.editable') ? 1 : 0,
            ];

            $res = Configuration::where('id', '=', $id)->update($edit_configuration);

            if($res)
            {
                return redirect()->route('admin.configurations.admin_index')->with('success', __('common.config_update_success'));
            } else
            {
                return redirect()->route('admin.configurations.admin_index')->with('error', __('common.problem_in_form_submition'));
            }
        } else {
            return view('admin.configurations.admin_edit', compact('configuration'));
        }
    }

    public function admin_delete($id = NUll) {

        $configuration = Configuration::findorFail($id);
        $res = $configuration->delete();

        if($res)
        {
            return redirect()->route('admin.configurations.admin_index')->with('success', __('common.config_delete_success'));
        } else
        {
            return redirect()->route('admin.configurations.admin_index')->with('error', __('common.problem_in_form_submition'));
        }
    }

    /**
     * Admin moveup
     *
     * @param integer $id
     * @param integer $step
     * @return void
     * @access public
     */
    public function admin_moveup($id, $step = 1)
    {

        $configuration = new Configuration();
        $res = $configuration->moveUp($id, $step);
        if($res)
        {
            return redirect()->back()->with('success', __('common.Moved_up_success'));
        }
        else
        {
            return redirect()->back()->with('error', __('common.could_not_move_up'));
        }
    }

    /**
     * Admin moveup
     *
     * @param integer $id
     * @param integer $step
     * @return void
     * @access public
     */
    public function admin_movedown($id, $step = 1)
    {

        $configuration = new Configuration();
        $res = $configuration->moveDown($id, $step);
        if($res)
        {
            return redirect()->back()->with('success', __('common.Moved_down_success'));
        }
        else
        {
            return redirect()->back()->with('error', __('common.could_not_move_down'));
        }
    }

    /**
    * image save function
    *
    *
    **/
    private function __imageSave($request) {
        $fileNameArr = array();
        if(empty($request->file('Configuration')))
        {
            return $fileNameArr;
        }
        foreach($request->file('Configuration') as $imgKey => $imgValue)
        {
            if (is_array($imgValue['value'])) {

                foreach ($imgValue['value'] as $image) {
                    $fileName = $image->hashName();
                    $image->storeAs('public/configuration-images', $image->hashName());
                    $fileFullName[] = $fileName;
                }

                $fileName = implode(",",$fileFullName);

            }else {

                $fileName = time().'.'.$imgValue['value']->getClientOriginalName();
                $imgValue['value']->storeAs('public/configuration-images', $fileName);

            }
                $fileNameArr[$imgKey] = $fileName;
        }
        return $fileNameArr;
    }

    /**
    * image save function For Prefix
    *
    *
    **/
    private function __imageSavePrefix($request, $key=Null) {
        $fileNameArr = array();
        if($key == Null || empty($request->file($key)))
        {
            return $fileNameArr;
        }

        foreach($request->file($key) as $imgKey => $imgValue)
        {
            if (is_array($imgValue)) {

                foreach ($imgValue as $image) {
                    $fileName = time().'.'.$image->getClientOriginalName();
                    $image->storeAs('public/configuration-images', $fileName);
                    $fileFullName[] = $fileName;
                }

                $fileName = implode(",",$fileFullName);

            }else {
                $fileName = time().'.'.$imgValue->getClientOriginalName();
                $imgValue->storeAs('public/configuration-images', $fileName);
            }
            $fileNameArr[$imgKey] = $fileName;
        }
        return $fileNameArr;
    }

    public function save_permalink(Request $request)
    {

        $permalink_selection    = $request->input('permalink_selection');
        if($permalink_selection == 'custom')
        {
            $permalink_selection    = $request->input('permalink_structure');
        }
        $configuration          = Configuration::where('name', '=', 'Permalink.settings')->update(['value' => $permalink_selection]);

        if($configuration)
        {
            return redirect()->back()->with('success', __('common.config_update_success'));
        }
        return redirect()->back()->with('error', __('common.problem_in_form_submition'));
    }

    public function remove_config_image($id, $image)
    {
        $config = Configuration::where('id', '=', $id)->first();
        $images = explode(",",$config->value);
        if(($key = array_search($image, $images)) !== false)
        {
            unset($images[$key]);
        }
        if(!empty($config->value) && Storage::exists('public/configuration-images/'.$image))
        {
            $images = explode(",",$config->value);
            if(($key = array_search($image, $images)) !== false)
            {
                unset($images[$key]);
            }
            Storage::delete('public/configuration-images/'.$image);
            $config->value = implode(',', $images);
            return $config->save();
        }
    }

    public function admin_reading(Request $request) {
        $page_title = $prefix = __('common.reading');
        $pages  = Page::all();
        $mainLanguageList = dzHelper::getMainLanguage();
        $mainLanguageListSort = dzHelper::getLanguageBySorting();
        if($request->isMethod('post')) {
            foreach ($request->input('Reading') as $key => $value) {
                $config = New Configuration();
                $config->saveConfig('Reading.'.$key, $value);
            }
            return redirect()->back()->with('success', __('common.config_update_success'));
        }

        $configurations = Configuration::select('id', 'name', 'value', 'title', 'description', 'input_type', 'editable', 'weight', 'params')->where('name', 'LIKE', $prefix.'%')->get();

        return view('admin.configurations.admin_reading_prefix', compact('page_title','prefix', 'pages', 'configurations','mainLanguageList','mainLanguageListSort'));
    }


    public function admin_settings(Request $request) {

        $page_title = $prefix = __('common.settings');

        if($request->isMethod('post')) {

            if($request->input('storage_link'))
            {
                $folderPath = public_path('storage');
                \Artisan::call('optimize:clear');

                if(is_dir($folderPath))
                {
                    return redirect()->back()->with('error', __('common.remove_storage_folder'));
                }

                \Artisan::call('storage:link');
            }

            if($request->input('clear_cache'))
            {
                \Artisan::call('optimize:clear');
            }

            if($request->input('admin_layout') || $request->input('admin_layout') == 0)
            {
                $config = New Configuration();
                $config->saveConfig('Settings.admin_layout', $request->input('admin_layout', 0));
                $config->saveConfig('Settings.admin_layout_options', json_encode(config('constants.dezThemeSet'.$request->input('admin_layout', 0))));
            }

            if($request->input('submit_type'))
            {
                $themeStyle['typography'] = $request->input('typography', 'poppins');
                $themeStyle['version'] = $request->input('theme_version', 'light');
                $themeStyle['layout'] = $request->input('theme_layout', 'vertical');
                $themeStyle['headerBg'] = $request->input('header_bg', 'color_1');
                $themeStyle['primary'] = $request->input('primary_bg', 'color_1');
                $themeStyle['navheaderBg'] = $request->input('navigation_header', 'color_1');
                $themeStyle['sidebarBg'] = $request->input('sidebar_bg', 'color_1');
                $themeStyle['sidebarStyle'] = $request->input('sidebar_style', 'full');
                $themeStyle['sidebarPosition'] = $request->input('sidebar_position', 'fixed');
                $themeStyle['headerPosition'] = $request->input('header_position', 'fixed');
                $themeStyle['containerLayout'] = $request->input('container_layout', 'full');
                $themeStyle['direction'] = $request->input('theme_direction', 'ltr');
                $config = New Configuration();
                $config->saveConfig('Settings.admin_layout_options', json_encode($themeStyle));
            }

            return redirect()->back()->with('success', __('common.settings_updated_success'));
        }
        $admin_layout_options = json_decode(config('Settings.admin_layout_options', json_encode(config('constants.dezThemeSet0'))));
        return view('admin.configurations.admin_settings', compact('page_title','prefix', 'admin_layout_options'));
    }

    public function make_slug(Request $request)
    {
        if($request->isMethod('post')) {
            $slug_text = $request->input('slug_text');
            if($slug_text)
            {
                $slug_text = preg_replace('#[ -]+#', '-', Str::of(strip_tags($slug_text))->trim());
                return Str::lower($slug_text);
            }
        }
        return false;
    }

    public function admin_site(Request $request, $prefix) {

        $page_title = $prefix;
        $roles = Role::get();
        $allinstalledlanguage = dzHelper::getLanguages();
        $alllanguages = config('lang.default');
        $installed_language = array_intersect_key($alllanguages,$allinstalledlanguage);

        return view('admin.configurations.admin_site', compact('page_title', 'prefix', 'roles','installed_language'));
    }

    public function admin_discussion(Request $request, $prefix) {

        $page_title = $prefix;
        return view('admin.configurations.admin_discussion', compact('page_title', 'prefix'));
    }

    public function admin_environment(Request $request, $prefix) {

        $page_title = $prefix;
        return view('admin.configurations.admin_environment', compact('page_title', 'prefix'));
    }

    public function save_config(Request $request, $prefix)
    {  
        if($request->isMethod('post')) {
            if ($prefix == 'Environment') {
                $this->save_env_config($request);    
            } 
            else {

                $config = New Configuration();
                $fileNameArr = $this->__imageSavePrefix($request,$prefix);
                foreach ($request->input($prefix) as $key => $value) {
                    if(array_key_exists($key, $fileNameArr))
                    {
                        $value = $fileNameArr[$key];
                    }
                    $config->saveConfig($prefix.'.'.$key, $value);
                }
            }

            return redirect()->back()->with('success', __('common.config_update_success'));
        }
        return redirect()->back()->with('error', __('common.problem_in_form_submition'));
    }

    public function date_time_format(Request $request)
    {
        if($request->isMethod('post')) {

            if($request->input('format'))
            {
                return date($request->input('format'));
            }
        }
        return;
    }

    public function upload_files(Request $request)
    {
        if($request->isMethod('post')) {

            if ($request->hasFile('file')) {

                $fileName       = $request->file->getClientOriginalName();
                $timeStamp      = time();
                $fileFullName   = $timeStamp.'-'.$request->file->getClientOriginalName();
                $size           = $request->file->getSize();
                $request->file->storeAs('public/tempUpload', $fileFullName);

                $tempProductFiles = array(
                    "full_name" => $fileFullName,
                    "name" => $fileName,
                    "size" => $size,
                    "path" => asset('storage/tempUpload/'.$fileFullName),
                    "time" => Carbon::parse($timeStamp)->diffForHumans()
                );
                return response()->json(['success' => 'File uploaded successfully.', 'file' => $tempProductFiles]);
            }

        }
        return response()->json(['error' => 'File upload failed.']);
    }

    public function remove_file(Request $request)
    {
        if($request->isMethod('post')) {

            $filename =  basename($request->post('filename'));
            if (!empty($filename) && Storage::exists('public/tempUpload/'.$filename)) {
                Storage::delete('public/tempUpload/'.$filename);
                return response()->json(['msg' => 'File removed successfully.']);
            }

        }
        return response()->json(['msg' => 'File deleted failed.']);
    }
    
    public function ckeditor_uploads(Request $request)
    {
        if($request->hasFile('upload')) {
            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename.'_'.time().'.'.$extension;
            //Upload File
            $request->file('upload')->storeAs('public/ckeditor-images/', $filenametostore);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/ckeditor-images/'.$filenametostore);
            $message = 'File uploaded successfully';

            if (!is_null($CKEditorFuncNum)) {
                $result = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$message')</script>";
                @header('Content-type: text/html; charset=utf-8');
                return $result;
            }

            // Render HTML output
            $response = [
                'uploaded' => 1,
                'fileName' => $filenametostore,
                'url' => $url,
            ];

            return response()->json($response);
        }
    }

    public function save_env_config(Request $request)
    {

        $results = 'Your .env file settings have been saved.';
        $envFilePath = base_path('.env');
        $envFileData = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($envFileData as $line) {
            list($envKey, $envValue) = explode('=', $line, 2);
            
            if (strtolower($envKey) === 'app_name') {
                // If the key is APP_NAME, handle spaces by encapsulating the value within quotes
                if (isset($request[strtolower($envKey)])) {
                    $newEnvFileData[] = $envKey . '="' . $request[strtolower($envKey)] . '"';
                } else {
                    $newEnvFileData[] = $envKey . '="' . $envValue . '"';
                }
            } else {
                // For other keys, maintain the original logic
                if (isset($request[strtolower($envKey)])) {
                    $newEnvFileData[] = $envKey . '=' . $request[strtolower($envKey)];
                } else {
                    $newEnvFileData[] = $envKey . '=' . $envValue;
                }
            }
        }

        $newEnvFileContent = implode("\n", $newEnvFileData);

        try {
            file_put_contents($envFilePath, $newEnvFileContent);
        } catch (Exception $e) {
            $results = 'Unable to save the .env file. Please create it manually.';
        }

        return $results;


    }

}
