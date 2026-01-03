<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use Stevebauman\Purify\Facades\Purify;

class Language extends Model
{
    use HasFactory;

    protected $table = 'languages';
    protected $fillable = [
        'title',
        'language_code',
        'country',
        'country_code',
        'country_id',
        'is_universal',
        'is_main',
        'is_regional',
        'title_lang',
        'status',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function getMainLanguageQuery()
    {
        return DB::table('countries')
            ->leftJoin('languages', 'countries.id', '=', 'languages.country_id')
            ->orderBy('languages.is_main','desc')
            ->get();
    }



}
