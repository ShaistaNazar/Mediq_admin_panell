<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CMSPages extends Model {

    protected $table = 'cms_pages';
    
    protected $fillable = [

							'id',
							'title_english',
							'page_html_content',
							'slug',
							'keywords',
							'description',
							'status',
							'created_at',
							'updated_at'
    ];

 
}
