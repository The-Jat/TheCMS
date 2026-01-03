<?php

namespace Modules\CustomField\Http\Controllers;

use Illuminate\Http\Request;
use Modules\CustomField\Entities\CustomField;
use Modules\CustomField\Entities\CustomFieldType;
use Modules\CustomField\Helpers\CustomFieldHelper;

class CustomFieldsController extends ModuleController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $page_title = __('common.custom_fields');
        $resultQuery = CustomField::query();
        if($request->isMethod('get') && $request->input('todo') == 'Filter')
        {
            if($request->filled('title')) {
                $resultQuery->where('title', 'like', "%{$request->input('title')}%");
            }
            
            if($request->filled('input_type')) {
                $resultQuery->where('input_type', '=', $request->input('input_type'));
            }

            if($request->filled('custom_field_type')) {
                $resultQuery->whereHas('custom_field_types',function($query) use($request){
                    $query->where('custom_field_types.custom_field_type', '=', $request->input('custom_field_type'));
                });
            }
        }
        $custom_fields = $resultQuery->paginate(config('Reading.nodes_per_page'));
        return view('customfield::index', compact('custom_fields','page_title'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $page_title = __('common.add_custom_field');
        $CustomField    = new CustomField();
        $cf_list        = $CustomField->cf_settings();
        return view('customfield::create', compact('cf_list','page_title'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validation = $this->validate($request, 
            [
                'key' => 'required|unique:custom_fields,key',
                'title' => 'required',
                'input_type' => 'required',
            ]
        );
        
        $res = CustomField::create($request->all());

        if($res)
        {
            $CustomFieldTypes = '';
            if($request->input('custom_field_type'))
            {
                foreach($request->input('custom_field_type') as $key => $value) {
                    $CustomFieldTypes = array(
                                        'custom_field_id' => $res->id,
                                        'custom_field_type' => $value
                                        );
                    CustomFieldType::create($CustomFieldTypes);
                }
            }
            return redirect()->route('customfields.admin.index')->with('success', 'Custom field added successfully.');  
        } 
        return redirect()->route('customfields.admin.index')->with('error', 'There are some problem in form submition.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('customfield::view');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $page_title = __('common.edit_custom_field');
        $CustomField    = new CustomField();
        $cf_list        = $CustomField->cf_settings();
        $custom_field = CustomField::with('custom_field_types')->findorFail($id);
        return view('customfield::edit', compact('custom_field', 'cf_list', 'page_title'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $custom_field = CustomField::findorFail($id);
        $validation = $this->validate($request, 
            [
                'key' => 'required|unique:custom_fields,key,'.$id,
                'title' => 'required',
                'input_type' => 'required',
            ]
        );

        $edit_custom_field              = $request->all();
        $edit_custom_field['editable']  = $request->input('editable') ? 1 : 0;
        $edit_custom_field['required']  = $request->input('required') ? '1' : '0';
        $res                            = $custom_field->fill($edit_custom_field)->save();

        if($res)
        {
            $CustomFieldTypes = '';
            if($request->input('custom_field_type'))
            {
                foreach($request->input('custom_field_type') as $key => $value) {
                    $CustomFieldTypes = array(
                                        'custom_field_id' => $custom_field->id,
                                        'custom_field_type' => $value
                                        );
                    CustomFieldType::create($CustomFieldTypes);
                }
            }
            return redirect()->route('customfields.admin.index')->with('success', 'Custom field updated successfully.');  
        }
        return redirect()->route('customfields.admin.index')->with('error', 'There are some problem in form submition.');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $custom_field = CustomField::findorFail($id);
        $res = $custom_field->delete();

        if($res)
        {
            return redirect()->route('customfields.admin.index')->with('success', 'Custom field deleted successfully.');  
        }
        return redirect()->route('customfields.admin.index')->with('error', 'There are some problem.');
    }

    public function remove_image(Request $request)
    {

        if($request->isMethod('post') && !empty($request->imageName) && !empty($request->allImagesName))
        {
            $imageName =  $request->imageName;
            $allImagesName = explode(',', $request->allImagesName);

            $filepath = storage_path('app/public/custom-fields/').$request->imageName;
            if (($key = array_search($imageName, $allImagesName)) !== false) {

                unset($allImagesName[$key]);
                if(\File::exists($filepath))
                {
                    \File::delete($filepath);
                }
            }
            $allImagesName = implode(',', $allImagesName);
            echo json_encode(array('status' => true, 'result' => $allImagesName));
        }
        else
        {
            echo json_encode(array('status' => false));
        }
    }

    public function ajax_modal(Request $request)
    {
        if($request->isMethod('post'))
        {
            $validation = $this->validate($request, 
                [
                    'key' => 'required|unique:custom_fields,key',
                    'title' => 'required',
                    'input_type' => 'required',
                ]
            );
            
            $res = CustomField::create($request->except('group','_token'));

            if($res)
            {
                CustomFieldType::create(['custom_field_id' => $res->id,'custom_field_type' => $request->custom_field_type]);
            } 

            if ($request->group) {
                foreach ($request->group as $group_field) {
                    $group_field['parent_id'] = $res->id;
                    $groupField = CustomField::create($group_field);
                    CustomFieldType::create(['custom_field_id' => $groupField->id,'custom_field_type' => $request->custom_field_type]);
                }
            }

            $html = CustomFieldHelper::custom_fields($request->custom_field_type)->render();
            return response()->json(['status' => true,'html'=>$html]);
        }
        else
        {
            return view('customfield::ajax-modal')->render();
        }
    }
}
