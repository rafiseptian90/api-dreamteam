<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'icon'
    ];

    /* Relationship */
     public function projects()
     {
         return $this->belongsToMany(Project::class, 'project_tags', 'tag_id', 'project_id');
     }
}
