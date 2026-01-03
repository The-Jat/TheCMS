<?php

namespace Modules\CustomField\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomFieldType extends Model
{
    use HasFactory;

    protected $table = 'custom_field_types';
    protected $fillable = [
        'custom_field_id',
        'custom_field_type',
    ];

    public function custom_field()
    {
        return $this->belongsTo(CustomMeta::class, 'custom_field_id', 'id');
    }
}
