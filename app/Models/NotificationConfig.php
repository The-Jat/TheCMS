<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationConfig extends Model
{
    use HasFactory;

    protected $table = 'notification_config';
    protected $fillable = [
        'title',
        'code',
        'table_model',
        'notification_types',
        'placeholders',
    ];

    public function notification_templates()
    {
        return $this->HasMany(NotificationTemplate::class, 'notification_config_id', 'id');
    }

    public function notifications()
    {
        return $this->HasMany(Notification::class, 'notification_config_id', 'id');
    }

    public function user_notification_config()
    {
        return $this->HasMany(UserNotificationConfig::class, 'notification_config_id', 'id');
    }

    public function get_module_code($module_name='', $type='')
    {
        $module = \DB::table('laraapps')->select('*')->where('title', $module_name)->first();
        if($type == 'code')
        {
            return $module->code;
        }
        else 
        {
            return $module;
        }
    }
}
