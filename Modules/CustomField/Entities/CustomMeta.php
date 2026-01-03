<?php

namespace Modules\CustomField\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomMeta extends Model
{
    use HasFactory;

    protected $table = 'custom_metas';
    protected $fillable = [
        'object_id',
        'custom_field_type_id',
        'custom_field_id',
        'value',
    ];

    public function custom_field()
    {
        return $this->belongsTo(CustomField::class, 'custom_field_id', 'id');
    }

    public function custom_field_types()
    {
        return $this->belongsTo(CustomField::class, 'custom_field_type_id', 'id');
    }
}
