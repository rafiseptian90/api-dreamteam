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
        'owner_id', 'project_name', 'link', 'logo', 'description', 'viewed'
    ];

    /* Mutators */
    public function setNameAttribute($name){
        $this->attributes['slug'] = Str::slug($name);
        $this->attributes['name'] = $name;
    } 

    /* Relationship */
    public function owner(){
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function tags(){
        return $this->belongsToMany(Tags::class, 'project_languages', 'project_id', 'tag_id');
    }
}
