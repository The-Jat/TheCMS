<?php

namespace Modules\W3CPT\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Http\Traits\DzCptTrait;

class BlogCategory extends Model
{
    use HasFactory, DzCptTrait;

    public $post_type;
    protected $table = 'terms';
    protected $fillable = [
        'parent_id',
        'title',
        'slug',
        'description',
        'order',
        'post_count',
        'type',
    ];

    public function child_cats()
    {
        return $this->hasMany(BlogCategory::class, 'parent_id', 'id');
    }

    public function parent_cat()
    {
        return $this->belongsTo(BlogCategory::class, 'parent_id', 'id');
    }

    public function blog()
    {
        return $this->belongsToMany(Blog::class, 'term_relationships', 'term_id', 'object_id');
    }

    public function selected_cat_ids()
    {
        return $this->hasMany(TermRelationship::class, 'term_id', 'id');
    }

    /**
     * This  function creates (by running recursively)
     * an array of categories, their hierarchy level
     * and any other relevant data needed
     *
     * @param Collection $categories
     * @param int        $level
     * @param array      $list
     * @return array
     */

    public function generateCategoryTreeList($parent_id=Null, $seprater='_', &$level=0, &$list=[]) 
    {
        $topLevelCategories = BlogCategory::where('type', '=', 'category')->where('parent_id', '=', $parent_id)->get();

        if(!empty($topLevelCategories))
        {
            foreach ($topLevelCategories as $category) {
                $list[$category->id] = str_repeat($seprater, $level) . $category->title;
                
                $childrenCategories = $this->getCategoryChildren($category->id);
                if (count($childrenCategories)) {
                    $level++;
                    $this->generateCategoryTreeList($category->id, $seprater, $level, $list);
                    $level--;
                }
            }

        }
        return $list;
    }

    public function generateCategoryTreeArray($parent_id=Null, $seprater='_', $fields=['id', 'title'], &$level=0, &$list=[]) 
    {
        $topLevelCategories = BlogCategory::select($fields)->where('type', '=', 'category')->where('parent_id', '=', $parent_id)->withCount('blog')->get()->toArray();

        if(!empty($topLevelCategories))
        {
            foreach ($topLevelCategories as $category) {

                $category['title'] = str_repeat($seprater, $level) . $category['title'];
                if(!empty($category['created_at']))
                {
                    $category['created_at'] = date('Y-m-d H:i:s', strtotime($category['created_at']));
                }
                $list[$category['id']] = $category;
                
                $childrenCategories = $this->getCategoryChildren($category['id']);
                if (count($childrenCategories)) {
                    $level++;
                    $this->generateCategoryTreeArray($category['id'], $seprater, $fields, $level, $list);
                    $level--;
                }
            }

        }
        return $list;
    }

    public function generateCategoryTreeListCheckbox($parent_id=Null, $seprater='_', $selected=array(), &$level=0, &$list=[]) 
    {
        $topLevelCategories = BlogCategory::where('type', '=', 'category')->where('parent_id', '=', $parent_id)->get();

        $res[] = '<ul class="category-checkbox-list">';
            if(!empty($topLevelCategories))
            {
                $old_selected = old('data.BlogCategory') ? old('data.BlogCategory') : array();
                $selected = array_merge($old_selected, $selected);
                foreach ($topLevelCategories as $category) 
                {
                    $checked = (!empty($selected) && in_array($category->id, $selected)) ? 'checked="checked"' : '';
                    $title = str_repeat($seprater, $level) . $category->title;
                    $res[] = '
                    <li class="form-group BlogCategory'.$category->id.'"> 
                        <input type="checkbox" name="data[BlogCategory][]" class="blog_categories form-check-input" id="BlogCategory'.$category->id.'" value="'.$category->id.'" '.$checked.'>
                         <label class="form-check-label" for="BlogCategory'.$category->id.'">'.$title.'</label>';
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

    public function generateCptCategoryTreeList($post_type='', $parent_id=Null, $seprater='_', &$level=0, &$list=[]) 
    {
        $topLevelCategories = BlogCategory::where('parent_id', '=', $parent_id)->where('type', '=', $post_type)->get();

        if(!empty($topLevelCategories))
        {
            foreach ($topLevelCategories as $category) {
                $list[$category->id] = str_repeat($seprater, $level) . $category->title;
                
                $childrenCategories = $this->getCategoryChildren($category->id);
                if (count($childrenCategories)) {
                    $level++;
                    $this->generateCptCategoryTreeList($post_type, $category->id, $seprater, $level, $list);
                    $level--;
                }
            }

        }
        return $list;
    }

    public function generateCptCategoryTreeArray($post_type='', $parent_id=Null, $seprater='_', $fields=['id', 'title'], &$level=0, &$list=[]) 
    {
        $topLevelCategories = BlogCategory::select($fields)->where('type', '=', $post_type)->where('parent_id', '=', $parent_id)->withCount('blog')->get()->toArray();

        if(!empty($topLevelCategories))
        {
            foreach ($topLevelCategories as $category) {

                $category['title'] = str_repeat($seprater, $level) . $category['title'];
                if(!empty($category['created_at']))
                {
                    $category['created_at'] = date('Y-m-d H:i:s', strtotime($category['created_at']));
                }
                $list[$category['id']] = $category;
                
                $childrenCategories = $this->getCategoryChildren($category['id']);
                if (count($childrenCategories)) {
                    $level++;
                    $this->generateCptCategoryTreeArray($post_type, $category['id'], $seprater, $fields, $level, $list);
                    $level--;
                }
            }

        }
        return $list;
    }

    public function generateCptCategoryTreeListCheckbox($post_type=Null, $parent_id=Null, $seprater='_', $selected=array(), &$level=0, &$list=[]) 
    {
        $topLevelCategories = BlogCategory::where('type', '=', $post_type)->where('parent_id', '=', $parent_id)->get();
        $inputName = $this->post_type === 'blog' ? 'TaxoCategory' : 'BlogCategory';

        $res[] = '<ul class="category-checkbox-list">';
            if(!empty($topLevelCategories))
            {
                foreach ($topLevelCategories as $category) 
                {
                    $checked = (!empty($selected) && in_array($category->id, $selected)) ? 'checked="checked"' : '';
                    $title = str_repeat($seprater, $level) . $category->title;
                    $res[] = '
                    <li class="form-group BlogCategory'.$category->id.'"> 
                        <input type="checkbox" name="data['.$inputName.'][]" class="blog_categories form-check-input" id="TaxoCategory'.$category->id.'" value="'.$category->id.'" '.$checked.'>
                         <label class="form-check-label" for="TaxoCategory'.$category->id.'">'.$title.'</label>';
                    $childrenCategories = $this->getCategoryChildren($category->id);
                    if (count($childrenCategories)) 
                    {
                        $level++;
                        $res[] = $this->generateCptCategoryTreeListCheckbox($post_type, $category->id, $seprater, $selected, $level, $list);
                        $level--;
                    }
                    $res[] = '</li>';
                }

            }
        $res[] = '</ul>';

        return $res ? implode(' ', $res) : '';
    }

    /**
     * Creates (by running recursively) an array of categories
     * with their hierarchy level and any other
     * relevant data needed
     * 
     * @param Category $category
     * @param int      $level
     * @return array
     */
    public function getHierarchyData($category, $seprater, $level) 
    {
        return [
            'id' => $category->id,
            'slug' => $category->slug,
            'title' => str_repeat($seprater, $level) . $category->title,
            'created_at' => $category->created_at,
            'level' => $level,
            'order' => $category->order,
        ];
    }

    /**
     * Gets a given category's id children
     *
     * @param $categoryId
     * @return Collection
     */
    public function getCategoryChildren($categoryId) 
    {
        $categories = BlogCategory::where('parent_id', '!=', Null)->get();
        return $categories->filter(function ($category) use ($categoryId) {
            return $category->parent_id == $categoryId;
        });
    }

    public function moveUp($id, $step) 
    {
        $currentPosition = BlogCategory::select('id', 'order')->findorFail($id);
        
        if($currentPosition->id > 1)
        {
            $limit = $step;

            $changePosition = BlogCategory::select('id', 'order')
                                ->where('order', '<', $currentPosition->order)
                                ->orderBy('order', 'DESC')
                                ->limit($limit)
                                ->get()->toArray();

            if($changePosition)
            {
                $lastArray = end($changePosition);
                $currentPositionRes = BlogCategory::where('id', '=', $currentPosition->id)
                                    ->update(['order'=> $lastArray['order']]);

                $changePositionId = ($limit > 1) ? $lastArray['id'] : $lastArray['id'];

                $changePositionRes = BlogCategory::where('id', '=', $changePositionId)
                                    ->update(['order'=>$currentPosition->order]);
                return true;
            }
            return false;
        }
        else
        {
            return  false;
        }
    }

    public function moveDown($id, $step) 
    {
        $currentPosition = BlogCategory::select('id', 'order')->findorFail($id);
        $maxOrder = BlogCategory::max('order');
        
        if($currentPosition->order < $maxOrder)
        {
            $limit = $step;

            $changePosition = BlogCategory::select('id', 'order')
                                ->where('order', '>', $currentPosition->order)
                                ->orderBy('order', 'ASC')
                                ->limit($limit)
                                ->get()->toArray();

            $lastArray = end($changePosition);
            $currentPositionRes = BlogCategory::where('id', '=', $currentPosition->id)
                                ->update(['order'=> $lastArray['order']]);

            $changePositionId = ($limit > 1) ? $lastArray['id'] : $lastArray['id'];

            $changePositionRes = BlogCategory::where('id', '=', $changePositionId)
                                ->update(['order'=>$currentPosition->order]);
            
            return true;
        }
        else
        {
            return  false;
        }
    }

    public function getCreatedAtAttribute( $value ) {
        $dateFormat = config('Site.custom_date_format','F j, Y').' '.config('Site.custom_time_format','g:i A');
        return (new Carbon($value))->format($dateFormat);
    }

    public function setCreatedAtAttribute( $value ) {
        $this->attributes['created_at'] = (new Carbon($value))->format('Y-m-d H:i:s');
    }
    
    public function get_taxonomies_by_cpt($post_type=Null)
    {
        return $this->taxonomies_by_cpt($post_type);
    }
    
    public function getCategoriesCheckboxByCpt($post_type=Null)
    {
        $cptIds = Blog::where('post_type', '=', config('w3cpt.post_type_taxo'))->pluck('id');
        $categories = array();

        if(!$cptIds->isEmpty())
        {
            foreach($cptIds as $cptId)
            {
                $taxonomies = BlogMeta::where('blog_id', '=', $cptId)->whereIn('title', ['cpt_tax_name', 'cpt_tax_label', 'cpt_tax_post_types'])->pluck('value', 'title');

                if(!$taxonomies->isEmpty())
                {
                    $cpt_tax_post_types = unserialize($taxonomies['cpt_tax_post_types']);
                    if(in_array($post_type, $cpt_tax_post_types))
                    {
                        $taxName = \Str::studly($taxonomies['cpt_tax_name']);
                        $categories[\Str::studly($taxName)] = BlogCategory::where('type', '=', $taxonomies['cpt_tax_name'])->get();
                    
                        $categories[\Str::studly($taxName)]['label'] = $taxonomies['cpt_tax_label'];    
                    }
                }

            }
        }
        
        return $categories;
    }
    
    public function getTaxonomiesByPostType($post_type=Null)
    {
        return $this->where('type', '=', $post_type)->get();
    }
    
}
