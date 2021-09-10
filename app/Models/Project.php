<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'owner_id', 'project_name', 'link', 'logo', 'description', 'viewed'
    ];

    /* Relationship */
    public function owner(){
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function languages(){
        return $this->belongsToMany(ProgrammingLanguage::class, 'project_languages', 'project_id', 'language_id');
    }
}
