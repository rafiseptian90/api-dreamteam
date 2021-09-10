<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgrammingLanguage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'icon'
    ];

    /* Relationship */ 
    public function projects(){
        return $this->belongsToMany(Project::class, 'project_languages', 'language_id', 'project_id');
    }
}
