<?php

namespace Modules\W3CPT\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TermRelationship extends Model
{
    use HasFactory;

    protected $table = 'term_relationships';
    protected $fillable = [
        'object_id',
        'term_id',
        'object_type',
    ];

    public function terms()
    {
        return $this->belongsTo(BlogCategory::class, 'term_id', 'id');
    }
}
