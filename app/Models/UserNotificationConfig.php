<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotificationConfig extends Model
{
    use HasFactory;

    protected $table = 'user_notification_config';
    protected $fillable = [
        'user_id',
        'notification_config_id',
        'notification_types',
        'status',
    ];
}
