<?php

namespace Modules\W3CPT\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BlogBlogCategory extends Model
{
    use HasFactory;

    protected $table = 'blog_blog_categories';
    protected $fillable = [
        'blog_id',
        'blog_category_id',
    ];
    public $timestamps = false;

    /**
     * BlogBlogCategory belongs to Blog.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id', 'id');
    }

    public function blog_category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id', 'id');
    }
    
}
