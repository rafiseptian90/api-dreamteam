<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_name', 'link', 'logo', 'description', 'viewed'
    ];

    protected $hidden = [
        'id', 'owner_id', 'created_at', 'updated_at', 'deleted_at'
    ];

    // replace key id to slug
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /* Mutators */
    public function setProjectNameAttribute($name){
        $this->attributes['slug'] = Str::slug($name);
        if(auth()->user())
        {
            $this->attributes['owner_id'] = auth()->user()->id;
        } else {
            $this->attributes['owner_id'] = 1;
        }
        $this->attributes['project_name'] = $name;
    } 

    /* Relationship */
    public function owner(){
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'project_tags', 'project_id', 'tag_id')->withTimestamps();
    }
}
