<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Stevebauman\Purify\Facades\Purify;
use Modules\W3CPT\Entities\BlogCategory;
use Modules\CustomField\Entities\CustomField;

class Page extends Model
{
    use HasFactory;

    protected $table = 'pages';
    protected $fillable = [
        'parent_id',
        'user_id',
        'type',
        'title',
        'slug',
        'excerpt',
        'content',
        'comment',
        'password',
        'status',
        'visibility',
        'feature_image',
        'publish_on',
        'order',
    ];

    /**
     * Page has many Child_pages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function child_pages()
    {
        return $this->hasMany(Page::class, 'parent_id', 'id');
    }

    /**
     * Page has many recursive  Child_pages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id', 'id')->with('children','page_metas', 'page_seo');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Page belongs to Parent_page.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent_page()
    {
        return $this->belongsTo(Page::class, 'parent_id', 'id');
    }

    /**
     * Page has many Page_metas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function page_metas()
    {
        return $this->hasMany(PageMeta::class, 'page_id', 'id');
    }

    /**
     * Page has one Page_seo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function page_seo()
    {
        return $this->hasOne(PageSeo::class, 'page_id', 'id');
    }

    public function page_categories()
    {
        return $this->belongsToMany(BlogCategory::class, 'term_relationships', 'object_id', 'term_id')->wherePivot('object_type', 2);
    }

    public function custom_fields()
    {
        return $this->belongsToMany(CustomField::class, 'custom_metas', 'object_id', 'custom_field_id')->whereHas('custom_field_types', function ($q) {
            $q->where('custom_field_type', 'pages');
        })->withPivot('id', 'object_id', 'custom_field_type_id', 'custom_field_id', 'value')->as('custom_metas');
    }

    /**
     * Blog has one feature_img.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function feature_img()
    {
        return $this->hasOne(PageMeta::class, 'page_id', 'id')
                    ->select(['page_id', 'title', 'value'])
                    ->where('title', '=', 'ximage');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'object_id', 'id')
                    ->where('parent_id', '0')
                    ->where('approve', '1')
                    ->orderBy('created_at', config('Discussion.comment_order', 'asc'))->with('child_comments');
    }

    /**
     * Page has many Comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function page_comments()
    {
        return $this->hasMany(Comment::class, 'object_id', 'id');
    }

    public function child_comments()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id')
                    ->where('approve', '1')
                    ->orderBy('created_at', config('Discussion.comment_order', 'asc'));
    }

    public function scopeWherePublishPage($query)
    {
        return $query->whereNotIn('status' , [2,3,5]);
    }

    public function generatePageTreeListCheckbox($parent_id=0, $seprater='_', $selected=array(), &$level=0, &$list=[]) {

        $topLevelPages = Page::where('parent_id', '=', $parent_id)->get();

        $res[] = '<ul class="page-checkbox-list">';
            if(!empty($topLevelPages))
            {
                $old_selected = old('Menu') ? old('Menu') : array();
                $selected = array_merge($old_selected, $selected);
                foreach ($topLevelPages as $page) 
                {
                    $checked = (!empty($selected) && in_array($page->id, $selected)) ? 'checked="checked"' : '';
                    $title = str_repeat($seprater, $level) . $page->title;
                    $res[] = '<li class="Menu'.$page->id.'"> <input type="hidden" name="Menu[]" id="Menu'.$page->id.'_" value="0"> <input type="checkbox" name="Menu['.$page->id.']" class="CheckboxViewAll" id="Menu'.$page->id.'" value="'.$page->id.'" '.$checked.'> '.$title;
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

    public function generateSlug($slug, $id=Null)
    {
        if (!empty($id)) {
            // for Update Page ,check same page id
            $where  = static::where('id', '!=' ,$id)->whereSlug($slug)->exists();
        }else {
            // for create Page
            $where  = static::whereSlug($slug)->exists();
        }

        if ($where) {

            $original = $slug;
            $count = 2;

            while (static::whereSlug($slug)->exists()) {
                $slug = "{$original}-" . $count++;
            }
            return $slug;
        }
        return $slug;
    }

    public function get_the_content($pageId)
    {
        return $pages = Page::firstWhere('id', $pageId)->value('content');
    }

    public function getPage($id)
    {
        $page = Page::firstWhere('id', $id);
        if ($page) {
            return $page;
        }
    }

    public function laraPageLink($id)
    {
        $page =  Page::with('parent_page')->where('id', $id)->first();     
        $slug = $page->slug;
        
        return $slug;
    }

    public function getCreatedAtAttribute( $value ) {
        $dateFormat = config('Site.custom_date_format').' '.config('Site.custom_time_format');
        return (new Carbon($value))->format($dateFormat);
    }

    public function setCreatedAtAttribute( $value ) {
        $this->attributes['created_at'] = (new Carbon($value))->format('Y-m-d H:i:s');
    }

    public function getPublishedOnAttribute( $value ) {
        $dateFormat = config('Site.custom_date_format').' '.config('Site.custom_time_format');
        return (new Carbon($value))->format($dateFormat);
    }

    public function setPublishedOnAttribute( $value ) {
        return (new Carbon($value))->format('Y-m-d H:i:s');
    }

    public function setSlugAttribute( $value ) {
        return $this->attributes['slug'] = $this->generateSlug($value, $this->id);
    }

    /*public function getContentAttribute($value)
    {
        return Purify::clean($value);
    }*/

}
