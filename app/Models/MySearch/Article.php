<?php

namespace App\Models\MySearch;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $table = 'test1';
    
    const CREATED_AT = 'add_date';
    
    const UPDATED_AT = 'update_date';
    
    public $fillable = [
        'id',
        'class',
        'title',
        'desc',
        'content',
        'doc_status',
        'add_date',
        'update_date',
    ];
}
