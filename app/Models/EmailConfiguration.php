<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailConfiguration extends Model
{
    //
    protected $table = 'email_configurations';
    protected $fillable =[
        'include_logo_header',
        'include_logo_footer',
        'header_logo_path',
        'footer_logo_path',
        'confidentiality_notice',
        'facebook_url',
        'reddit_url',
        'youtube_url',
        'twitter_url',
        'instagram_url',
    ];
}
