<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'type',
    ];

    /**
     * Menu belongs to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Menu has many Menu_items.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menu_items()
    {
        return $this->hasMany(MenuItem::class, 'menu_id', 'id');
    }

    public function generatePageTreeListCheckbox($parent_id=0, $seprater='_', $selected=array(), &$level=0, &$list=[]) {

        $topLevelPages = Page::where('parent_id', '=', $parent_id)->where('visibility', '!=', 'Pr')->get();

        $res[] = '<ul class="page-checkbox-list">';
            if(!empty($topLevelPages))
            {
                $old_selected = old('MenuItem') ? old('MenuItem') : array();
                $selected = array_merge($old_selected, $selected);
                foreach ($topLevelPages as $page) 
                {
                    $checked = (!empty($selected) && in_array($page->id, $selected)) ? 'checked="checked"' : '';
                    $title = str_repeat($seprater, $level) . $page->title;
                    $res[] = '<li class="Menu'.$page->id.'"> <div class="d-flex"> <input type="checkbox" name="MenuItem['.$page->id.']" class="page-checkbox form-check-input CheckboxViewAll" id="Menu'.$page->id.'" value="'.$page->id.'" '.$checked.'><label class="form-check-label ms-1" for="Menu'.$page->id.'">'.$title.'</label> </div>';
                    $childrenPages = $this->getPageChildren($page->id);
                    if (count($childrenPages)) 
                    {
                        $level++;
                        $res[] = $this->generatePageTreeListCheckbox($page->id, $seprater, $selected, $level, $list);
                        $level--;
                    }
                    $res[] = '</li>';
                }

            }
        $res[] = '</ul>';

        return $res ? implode(' ', $res) : '';
    }

    public function getPageChildren($pageId) {
        $pages = Page::where('parent_id', '!=', 0)->get();
        return $pages->filter(function ($page) use ($pageId) {
            return $page->parent_id == $pageId;
        });
    }

    public function generateCategoryTreeListCheckbox($parent_id=0, $seprater='_', $selected=array(), &$level=0, &$list=[]) 
    {
        $topLevelCategories = BlogCategory::where('parent_id', '=', $parent_id)->get();

        $res[] = '<ul class="category-checkbox-list">';
            if(!empty($topLevelCategories))
            {
                $old_selected = old('MenuCategory') ? old('data.MenuCategory') : array();
                $selected = array_merge($old_selected, $selected);
                foreach ($topLevelCategories as $category) 
                {
                    $checked = (!empty($selected) && in_array($category->id, $selected)) ? 'checked="checked"' : '';
                    $title = str_repeat($seprater, $level) . $category->title;
                    $res[] = '<li class="MenuCategory'.$category->id.'"> <div class="d-flex"> <input type="checkbox" name="MenuItem[]" class="menu_categories form-check-input CheckboxViewAll" id="MenuCategory'.$category->id.'" value="'.$category->id.'" '.$checked.'><label class="form-check-label ms-1" for="MenuCategory'.$category->id.'">'.$title.'</label> </div>';
                    $childrenCategories = $this->getCategoryChildren($category->id);
                    if (count($childrenCategories)) 
                    {
                        $level++;
                        $res[] = $this->generateCategoryTreeListCheckbox($category->id, $seprater, $selected, $level, $list);
                        $level--;
                    }
                    $res[] = '</li>';
                }

            }
        $res[] = '</ul>';

        return $res ? implode(' ', $res) : '';
    }

    /**
     * Gets a given category's id children
     *
     * @param $categoryId
     * @return Collection
     */
    public function getCategoryChildren($categoryId) 
    {
        $categories = BlogCategory::where('parent_id', '!=', 0)->get();
        return $categories->filter(function ($category) use ($categoryId) {
            return $category->parent_id == $categoryId;
        });
    }

    public function generateBlogTreeListCheckbox($parent_id=0, $seprater='_', $selected=array(), &$level=0, &$list=[]) 
    {
        $topLevelBlogs = Blog::WherePublishBlog('blog')->CheckBlogVisibility()->get();

        $res[] = '<ul class="blog-checkbox-list">';
            if(!empty($topLevelBlogs))
            {
                $old_selected = old('MenuBlog') ? old('MenuBlog') : array();
                $selected = array_merge($old_selected, $selected);
                foreach ($topLevelBlogs as $blog) 
                {
                    $checked = (!empty($selected) && in_array($blog->id, $selected)) ? 'checked="checked"' : '';
                    $title = str_repeat($seprater, $level) . $blog->title;
                    $res[] = '<li class="MenuBlog'.$blog->id.'"> <div class="d-flex"> <input type="checkbox" name="MenuItem[]" class="menu_blogs form-check-input CheckboxViewAll" id="Blog'.$blog->id.'" value="'.$blog->id.'" '.$checked.'><label class="form-check-label ms-2" for="Blog'.$blog->id.'">'.$title.'</label>';
                    $res[] = '</li>';
                }

            }
        $res[] = '</ul>';

        return $res ? implode(' ', $res) : '';
    }
    
    /*
    * This function is copy of generateBlogTreeListCheckbox for cpt. We are using Post type condition.
    * Created on: 21-April-2023
    * Created on: 21-April-2023
    * Author: Rahul Dev Sharma and Ankit Suman
    */
    public function generateCptTreeListCheckbox($parent_id=0, $cpt=Null, $seprater='_', $selected=array(), &$level=0, &$list=[]) 
    {
        if($cpt == Null)
        {
            return false;
        }
        $topLevelBlogs = Blog::where('status', '=', 1)->where('visibility', '!=', 'Pr')->where('post_type', '=', $cpt)->get();

        $res[] = '<ul class="blog-checkbox-list">';
            if(!empty($topLevelBlogs))
            {
                $old_selected = old('MenuBlog') ? old('MenuBlog') : array();
                $selected = array_merge($old_selected, $selected);
                foreach ($topLevelBlogs as $blog) 
                {
                    $checked = (!empty($selected) && in_array($blog->id, $selected)) ? 'checked="checked"' : '';
                    $title = str_repeat($seprater, $level) . $blog->title;
                    $res[] = '<li class="MenuBlog'.$blog->id.'"> <div class="d-flex"> <input type="checkbox" name="MenuItem[]" class="menu_cpt form-check-input CheckboxViewAll" id="Cpt'.$blog->id.'" value="'.$blog->id.'" '.$checked.'><label class="form-check-label ms-2" for="Cpt'.$blog->id.'">'.$title.'</label>';
                    $res[] = '</li>';
                }

            }
        $res[] = '</ul>';

        return $res ? implode(' ', $res) : '';
    }

    public function generateTagTreeListCheckbox($parent_id=0, $seprater='_', $selected=array(), &$level=0, &$list=[]) 
    {
        $topLevelTags = BlogTag::get();

        $res[] = '<ul class="tag-checkbox-list">';
            if(!empty($topLevelTags))
            {
                $old_selected = old('MenuTag') ? old('MenuTag') : array();
                $selected = array_merge($old_selected, $selected);
                foreach ($topLevelTags as $tag) 
                {
                    $checked = (!empty($selected) && in_array($tag->id, $selected)) ? 'checked="checked"' : '';
                    $title = str_repeat($seprater, $level) . $tag->title;
                    $res[] = '<li class="MenuTag'.$tag->id.'"> <div class="d-flex"> <input type="checkbox" name="MenuItem[]" class="menu_tags CheckboxViewAll form-check-input" id="MenuTag'.$tag->id.'" value="'.$tag->id.'" '.$checked.'> <label class="form-check-label ms-2" for="MenuTag'.$tag->id.'">'.$title.'</label>';
                    $res[] = '</li>';
                }

            }
        $res[] = '</ul>';

        return $res ? implode(' ', $res) : '';
    }

    public function get_nav_menu($menuName='')
    {
        $menu = Menu::with(['menu_items' => function($query) {
            $query->orderBy('menu_items.order', 'asc');
            $query->where('menu_items.parent_id', '0');
            $query->with('child_menu_items');

        }])->where('slug', $menuName)->first(['id', 'title']);

        if(!empty($menu->menu_items))
        {
            return $menu->menu_items;
        }
        return false;
    }

    public function getCreatedAtAttribute( $value ) {
        $dateFormat = config('Site.custom_date_format').' '.config('Site.custom_time_format');
        return (new Carbon($value))->format($dateFormat);
    }

    public function setCreatedAtAttribute( $value ) {
        $this->attributes['created_at'] = (new Carbon($value))->format('Y-m-d H:i:s');
    }
}
