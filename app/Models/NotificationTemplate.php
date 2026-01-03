<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    use HasFactory;

    protected $table = 'notification_templates';
    protected $fillable = [
        'notification_types',
        'subject',
        'slug',
        'content',
    ];

    public function notification_config()
    {
        return $this->belongsTo(NotificationConfig::class, 'notification_config_id', 'id');
    }

    public function get_notification_template($id='', $type_id='')
    {
        if($type_id)
        {
            return NotificationTemplate::where('notification_config_id', '=', $id)->where('notification_type_id', '=', $type_id)->first();
        }
        return NotificationTemplate::firstWhere('notification_config_id', $id);
    }
}
