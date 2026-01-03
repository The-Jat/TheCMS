<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BlogBlogTag extends Model
{
    use HasFactory;

    protected $table = 'blog_blog_tags';
    protected $fillable = [
        'blog_id',
        'blog_tag_id',
    ];
    public $timestamps = false;

    /**
     * BlogBlogTag belongs to Blog.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id', 'id');
    }

    /**
     * BlogBlogTag belongs to Blog_tag.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function blog_tag()
    {
        return $this->belongsTo(BlogTag::class, 'blog_tag_id', 'id');
    }
    
}
