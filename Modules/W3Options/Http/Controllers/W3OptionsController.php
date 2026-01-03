<?php

namespace Modules\W3Options\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use App\Models\Configuration;
use Modules\W3Options\OptionsClass\ThemeOptionsClass;


class W3OptionsController extends Controller
{
    
    /**
     * Display the listing of the Theme Options in Admin.
     */
    public function theme_options()
    {   
        $themeArr = explode('/', config('Theme.select_theme'));
        $active_theme = $themeArr[1];
        $key = $active_theme.'_theme_options';
        $theme_options_data = config($key,'');
        $options_data = unserialize($theme_options_data);
        $sections = array();
     
        $ThemeOptionsobj = new ThemeOptionsClass;
        $sections = $ThemeOptionsobj->sections;
            
        if (!empty($sections)) {

            foreach ($sections as &$section) {

                if (!empty($section['fields'])) {

                    $unique_fields = array();

                    foreach ($section['fields'] as $field) {

                        $unique_fields[$field['id']] = $field;
                            
                    }
                    $unique_fields = array_values($unique_fields);
                    $section['fields'] = $unique_fields;
                }
            }
        }

        return view('w3options::theme-options.theme_options',compact('sections','options_data'));
    }

    /**
     * Used For Saving Theme Options in Database with theme name.
     */
    public function theme_options_save(Request $request)
    {
        $themeArr = explode('/', config('Theme.select_theme'));
        $active_theme = $themeArr[1];
        $configKey = $active_theme.'_theme_options';
        $request_value = $request->input('theme-options');

        if (!empty($request->file('theme-options'))) {
            foreach($request->file('theme-options') as $imgKey => $imgValue)
            {
                $fileFullName = [];
            
                if (is_array($imgValue)) {
                    foreach ($imgValue as $key => $image) {

                        /* Multiple Image Upload */
                        if (is_array($image)) {

                            foreach ($image as $fieldName => $value) {
                                $fileName = $value->hashName();
                                $value->storeAs('public/theme-options', $value->hashName());
                                $request_value[$imgKey][$key][$fieldName] = $fileName;
                            }
                            $fileFullName = $request_value[$imgKey];

                        }
                        /* Single Image Upload */
                        else{
                            $fileName = $image->hashName();
                            $image->storeAs('public/theme-options', $image->hashName());
                            $fileFullName = !empty($fileFullName) ? $fileFullName.','.$fileName : $fileName;
                        }

                    }

                    $fileName = $fileFullName;
                }
                else {
                    $fileName = time().'.'.$imgValue->getClientOriginalName();
                    $imgValue->storeAs('public/theme-options', $fileName);
                }

                $request->merge([
                    'theme-options' => array_merge($request->input('theme-options'), [$imgKey => $fileName])
                ]);
            }
        }

        $optionsData = array_filter($request->input('theme-options'), function($value) {
            return ($value !== null && $value !== false && $value !== ''); 
        });

        foreach ($optionsData as $key => $value) {
            if (!empty($value['%KEY%'])) {
                unset($optionsData[$key]['%KEY%']);
            }
        }

        $serializedOptionsData = serialize($optionsData);

        $configObj = New Configuration();
        $res = $configObj->saveConfig($configKey, $serializedOptionsData);

        return redirect()->back()->with('success', __('Theme Options Saved Successfully.'));
        
    }

    
}
