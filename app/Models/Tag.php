<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'icon'
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
        'pivot'
    ];

    /* Mutators */
    public function setNameAttribute($name){
        $this->attributes['slug'] = Str::slug($name);
        $this->attributes['name'] = $name;
    } 

    // replace key id to slug
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /* Relationship */
     public function projects()
     {
         return $this->belongsToMany(Project::class, 'project_tags', 'tag_id', 'project_id')->withTimestamps();
     }
}
