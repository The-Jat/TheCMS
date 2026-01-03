<?php

namespace Modules\W3CPT\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\W3CPT\Entities\BlogCategory;
use App\Models\Notification;
use Illuminate\Validation\Rule;
use Auth;

class BlogCategoriesController extends ModuleController
{
    public function list(Request $request, $id='')
    {
        $post_type = $this->post_type;
        $taxonomy = $this->taxonomy;
        $page_title = $taxonomy['cpt_tax_labels']['all_items'];
        $blog_categories    = (new BlogCategory)->generateCptCategoryTreeArray($taxonomy['cpt_tax_name'], Null, "_", ['id', 'title', 'created_at', 'order']);
        $blog_categories_list = $blog_categories;
        
        if($blog_categories)
        {
            $blog_categories    = $this->paginate(collect($blog_categories), config('Reading.nodes_per_page'));
        }
        $blogCategory       = BlogCategory::find($id);
        $newCat             = false;
        if(empty($blogCategory))
        {
            $newCat             = true;
            $blogCategory = new BlogCategory();
        }

        if($request->isMethod('post'))
        {

            $slugRule = Rule::unique('terms')
                            ->where(function ($query) use ($request) {
                                return $query->where('type', $request->input('taxonomy'))->where('slug', $request->slug);
                            });

            if ($id) {
                $slugRule->ignore($id);
            }

            $validation = [
                'title'       => 'required',
                'slug'        => ['required',$slugRule],
            ];

            $validationMsg = [
                'title.required'    => __('w3cpt::common.title_field_required'),
            ];

            $this->validate($request, $validation, $validationMsg);

            $blogCategory->parent_id    = $request->parent_id ? $request->parent_id : Null;
            $blogCategory->title        = $request->title;
            $blogCategory->slug         = $request->slug;
            $blogCategory->description  = $request->description;
            $blogCategory->type         = $taxonomy['cpt_tax_name'];
            $res                        = $blogCategory->save();
            $blogCategory->order        = $blogCategory->id;
            $blogCategory->save();

            if($res)
            {
                /* Send Event Notification */
                $notify_code = $newCat ? 'BLOG-ANBC' : 'BLOG-UBCAT';
                $notificationObj        = new Notification();
                $notificationObj->notification_entry($notify_code, $blogCategory->id, Auth::id(), config('constants.superadmin'));
                /* End Send Event Notification */

                $msg = $newCat ? $page_title.__(' updated successfully.') : $page_title.__(' added successfully.');
                return redirect()->route('cpt.blog_category.admin.list', ['post_type' => $post_type['name'], 'taxonomy' => $taxonomy['name']])->with('success', $msg);
            }
            return redirect()->route('cpt.blog_category.admin.list', ['post_type' => $post_type['name'], 'taxonomy' => $taxonomy['name']])->with('error', __('Something went wrong.'));
        }
        return view('w3cpt::admin.blog_categories.list', compact('blog_categories', 'blogCategory','page_title', 'post_type', 'taxonomy', 'blog_categories_list'));
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_index(Request $request)
    {
        $post_type = $this->post_type;
        $taxonomy = $this->taxonomy;
        $page_title = $taxonomy['cpt_tax_labels']['all_items'];

        $blogs_category_query = BlogCategory::query();
        if($request->isMethod('get'))
        {
            if($request->filled('title')) {
                $blogs_category_query->where('title', 'like', "%{$request->input('title')}%");
            }
        }
        $sortBy = $request->get('sort') ? $request->get('sort') : 'created_at';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $blogs_category_query->orderBy($sortBy, $direction);

        $blog_categories = $blogs_category_query->withCount('blog')->paginate(config('Reading.nodes_per_page'));
        return view('w3cpt::admin.blog_categories.index', compact('blog_categories','page_title', 'post_type', 'taxonomy'));

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function admin_create()
    {
        $post_type = $this->post_type;
        $taxonomy = $this->taxonomy;
        $page_title = $taxonomy['cpt_tax_labels']['all_items'];
        $blog_categories = (new BlogCategory)->generateCptCategoryTreeArray(Null, "_", ['id', 'title', 'created_at', 'order']);
        return view('w3cpt::admin.blog_categories.create', compact('blog_categories','page_title', 'post_type', 'taxonomy'));

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function admin_store(Request $request)
    {
        $validation = [
                'data.BlogCategory.title'       => 'required',
                'data.BlogCategory.slug'        => 'required|unique:terms,slug',
            ];

        $validationMsg = [
            'data.BlogCategory.title.required'      => __('w3cpt::common.title_field_required'),
            'data.BlogCategory.slug.required'       => __('w3cpt::common.slug_field_required'),
            'data.BlogCategory.slug.unique'         => __('w3cpt::common.slug_already_taken'),
        ];

        $this->validate($request, $validation, $validationMsg);

        $blogCategoryReq                = $request->input('data.BlogCategory');
        $blogCategoryReq['user_id']     = Auth::id();
        $blogCategory                   = BlogCategory::create($blogCategoryReq);
        if($blogCategory)
        {
            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('BLOG-ANBC', $blogCategory->id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */

            return redirect()->route('cpt.blog_category.admin.index', ['post_type' => $this->post_type['cpt_name'], 'taxonomy' => $this->taxonomy['cpt_tax_name']])->with('success', __($this->taxonomy['cpt_tax_labels']['name'].' added successfully.'));
        }
        return redirect()->back()->with('error', __('w3cpt::common.something_went_wrong'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function admin_show($id)
    {
        return view('w3cpt::admin.blog_categories.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function admin_edit($id)
    {
        $post_type = $this->post_type;
        $taxonomy = $this->taxonomy;
        $page_title = $taxonomy['cpt_tax_labels']['all_items'];
        $blog_category = BlogCategory::findorFail($id);
        $blog_categories = BlogCategory::get();
        return view('w3cpt::admin.blog_categories.edit', compact('blog_categories', 'blog_category','page_title', 'post_type', 'taxonomy'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function admin_update(Request $request, $id)
    {

        $validation = [
                'data.BlogCategory.title'       => 'required',
                'data.BlogCategory.slug'        => 'required|unique:terms,slug,'.$id,
            ];

        $validationMsg = [
            'data.BlogCategory.title.required'      => __('w3cpt::common.title_field_required'),
            'data.BlogCategory.slug.required'       => __('w3cpt::common.slug_field_required'),
            'data.BlogCategory.slug.unique'         => __('w3cpt::common.slug_already_taken'),
        ];

        $this->validate($request, $validation, $validationMsg);

        $blogCategoryReq                = $request->input('data.BlogCategory');
        $blogCategory                   = BlogCategory::where('id', '=', $id)->update($blogCategoryReq);
        if($blogCategory)
        {
            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('BLOG-UBCAT', $blogCategory->id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */

            return redirect()->route('cpt.blog_category.admin.index', ['post_type' => $this->post_type['cpt_name'], 'taxonomy' => $this->taxonomy['cpt_tax_name']])->with('success', __($this->taxonomy['cpt_tax_labels']['name'].' updated successfully.'));
        }
        return redirect()->back()->with('error', __('w3cpt::common.something_went_wrong'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function admin_destroy($id)
    {
            
        $res = BlogCategory::destroy($id);
        
        if($res)
        {
            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('BLOG-DBC', $id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */

            return redirect()->back()->with('success', $this->taxonomy['cpt_tax_labels']['all_items'].__(' deleted successfully.'));
        }
        return redirect()->back()->with('error', __('Something went wrong.'));
    }

    public function blogCategoryTree($id = Null, $level = 0)
    {
        $parents = BlogCategory::where('parent_id', '=', $id)->get();
        $res = isset($res) ? $res : array();
        $blank = "";
        if(!empty($parents))
        {   
            $level++;
            $res[] = '<ul type="none">';
        
            $i = 0;
            for($i=1; $i< $level; $i++)
                $blank .= " ";
            
                foreach($parents as $value)
                {
                    $checkbox = '<input type="checkbox" name="data[BlogCategory][BlogCategory]" class="blog_categories" value="'.$value->id.'">';
                    $title = $value->title;
                    $res[] = sprintf('<li>'.$blank.$checkbox.$title.' %s</li>', $this->blogCategoryTree($value->id, $level));
                }
        
            $res[] = '</ul>';
        }
        return implode('', $res);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $options =  array(
                        'path' => LengthAwarePaginator::resolveCurrentPath(),
                        'pageName' => 'page',
                    );
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function admin_ajax_add_category(Request $request) 
    {
        $category = BlogCategory::where('type', '=', $this->taxonomy['cpt_tax_name'])->where('slug', '=', \Str::slug($request->title))->first();
        if($category)
        {
            $category = array();
        } else 
        {
            $category               = new BlogCategory();
            $category->title        = $request->input('title');
            $category->parent_id    = $request->input('parent_id') ? $request->input('parent_id') : Null;
            $category->slug         = \Str::slug($request->input('title'));
            $category->type         = $this->taxonomy['cpt_tax_name'];
            $category->save();
            $category->order = $category->id;
            $category->save();

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('BLOG-ANBC', $category->id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */

        }
        return view('w3cpt::admin.blog_categories.ajax.admin_ajax_add_category', compact('category'));
    
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
        $blog_categorie = new BlogCategory();
        $res = $blog_categorie->moveUp($id, $step);
        if($res) 
        {
            return redirect()->back()->with('success', __('Moved up successfully.'));
        } 
        return redirect()->back()->with('error', __('Could not move up.'));
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
        $blog_categorie = new BlogCategory();
        $res = $blog_categorie->moveDown($id, $step);
        if($res) 
        {
            return redirect()->back()->with('success', __('Moved down successfully.'));
        }
        return redirect()->back()->with('error', __('Could not move down.'));
    }
}
