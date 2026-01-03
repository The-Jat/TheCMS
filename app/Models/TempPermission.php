<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempPermission extends Model
{
    use HasFactory;

    protected $table = 'temp_permissions';
    protected $fillable = [
        'parent_id',
        'name',
        'path',
        'controller',
        'action',
        'type',
    ];
    

}
