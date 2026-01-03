<?php

namespace Modules\W3CPT\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use Stevebauman\Purify\Facades\Purify;
use App\Models\Comment;
use App\Models\User;
use App\Http\Traits\DzCptTrait;
use Modules\CustomField\Entities\CustomField;

class Blog extends Model
{
	use HasFactory, DzCptTrait;
	
	protected $table = 'blogs';
	protected $fillable = [
		'user_id',
		'title',
		'slug',
		'content',
		'excerpt',
		'comment',
		'password',
		'status',
		'post_type',
		'visibility',
		'publish_on',
	];

	/**
	 * Blog belongs to User.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	/**
	 * Blog has many Blog_meta.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function blog_meta()
	{
		return $this->hasMany(BlogMeta::class, 'blog_id', 'id');
	}

	/**
	 * Blog has one Blog Seo.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function blog_seo()
	{
		return $this->hasOne(BlogSeo::class, 'blog_id', 'id');
	}

	public function blog_categories()
	{
		return $this->belongsToMany(BlogCategory::class, 'term_relationships', 'object_id', 'term_id')->where('object_type',1);
	}

	public function blog_tags()
	{
		return $this->belongsToMany(BlogTag::class, 'blog_blog_tags', 'blog_id', 'blog_tag_id');
	}

    public function custom_fields()
    {
        return $this->belongsToMany(CustomField::class, 'custom_metas', 'object_id', 'custom_field_id')->whereHas('custom_field_types', function ($q) {
            $q->where('custom_field_type','!=', 'pages');
        })->withPivot('id', 'object_id', 'custom_field_type_id', 'custom_field_id', 'value')->as('custom_metas');
    }

	/**
	 * Blog has one Feature_img.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function feature_img()
	{
		return $this->hasOne(BlogMeta::class, 'blog_id', 'id')
					->select(['blog_id', 'title', 'value'])
					->where('title', '=', 'ximage');
	}

	/**
	 * Blog has one video.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function video()
	{
		return $this->hasOne(BlogMeta::class, 'blog_id', 'id')
					->select(['blog_id', 'title', 'value'])
					->where('title', '=', 'xvideo');
	}

	public function generateSlug($slug, $id=Null)
	{
		if (!empty($id)) {
			// for Update blog ,check same blog id
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

	public function getCreatedAtAttribute( $value ) {
		$dateFormat = config('Site.custom_date_format','F j, Y').' '.config('Site.custom_time_format','g:i A');
		return (new Carbon($value))->format($dateFormat);
	}

	public function setCreatedAtAttribute( $value ) {
		$this->attributes['created_at'] = (new Carbon($value))->format('Y-m-d H:i:s');
	}

	public function getPublishOnAttribute( $value ) {
		$dateFormat = config('Site.custom_date_format','F j, Y').' '.config('Site.custom_time_format','g:i A');
		return (new Carbon($value))->format($dateFormat);
	}

	public function setPublishOnAttribute( $value ) {
		$this->attributes['publish_on'] = !empty($value) ? (new Carbon($value))->format('Y-m-d H:i:s') : date('Y-m-d H:i:s');
	}

	public function setSlugAttribute( $value ) {
		return $this->attributes['slug'] = $this->generateSlug($value, $this->id);
	}

	public function getContentAttribute($value)
	{
		return Purify::clean($value);
	}

	public function getBlogMeta($blog_id)
	{
		return BlogMeta::where('blog_id', '=', $blog_id)->pluck('value', 'title');
	}

	/*
	*return custom post type list
	*/
	public function getAllCpt()
	{
	   	$blogs = $this->where('post_type', '=', config('w3cpt.post_type'))->where('status', '=', 1)->pluck('id', 'slug');
	   	$taxonomies = $this->where('post_type', '=', config('w3cpt.post_type_taxo'))->where('status', '=', 1)->pluck('id');

	   	$blogMeta = $taxoMeta = array();
	   	if(!$blogs->isEmpty())
	   	{
			foreach ($blogs as $key => $value) {
				$blogMeta[$key] = $this->getBlogMeta($value);
				if(!$taxonomies->isEmpty())
			   	{
			   		$allTaxoMeta = array();
					foreach ($taxonomies as $taxoKey => $taxoValue) {
						$taxoMeta = $this->getBlogMeta($taxoValue);
						$taxonomiesArr = isset($taxoMeta['cpt_tax_post_types']) ? unserialize($taxoMeta['cpt_tax_post_types']) : array();
						if(in_array($blogMeta[$key]['cpt_name'], $taxonomiesArr))
						{
		   					$allTaxoMeta[] = $taxoMeta;
						}
					}
					$blogMeta[$key]['taxo'] = $allTaxoMeta;
			   	}

			}
	   	}
	   	return $blogMeta;

	}

	public function getPostsByPostType($post_type='')
	{
		return $this->where('post_type', '=', config('w3cpt.post_type'))->where('status', 1)->get();
	}

	public function getTaxonomiesByPostType($post_type='')
	{
		$allTaxoMeta = array();
		$allTaxonomyIds = Blog::where('post_type', '=', config('w3cpt.post_type_taxo'))->pluck('id');

		if (!$allTaxonomyIds->isEmpty()) {
			foreach($allTaxonomyIds as $taxoId)
			{
				$taxoMeta = BlogMeta::where('blog_id', '=', $taxoId)->pluck('value', 'title');
				$taxonomyCPT = isset($taxoMeta['cpt_tax_post_types']) ? unserialize($taxoMeta['cpt_tax_post_types']) : array();
				
				if (in_array($post_type, $taxonomyCPT)) {
					
					$allTaxoMeta[] = $taxoMeta;
					
				}
			}
		} 
		return $allTaxoMeta;
	}
	
    public function blog_comments()
    {
        return $this->hasMany(Comment::class, 'object_id', 'id');
    }

    public function scopeWherePublishBlog($query, $post_type=Null)
    {
        $post_type = $post_type ? $post_type : config('blog.post_type');
        return $query->where(['status' => 1, 'post_type' => $post_type]);
    }

    public function scopeCheckBlogVisibility($query)
    {
        return $query->where(function($query) {
                    if (!optional(Auth::user())->hasRole(config('constants.roles.admin'))) {
                        $query->where('visibility', '!=', 'pr')->orWhere(function($query) {
                            $query->where('visibility', 'pr')
                            ->where('user_id', auth()->id());
                        });
                    }
                });
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'object_id', 'id')
                    ->where('parent_id', '0')
                    ->where('approve', '1')
                    ->orderBy('created_at', config('Discussion.comment_order', 'asc'))->with('child_comments');
    }

}
