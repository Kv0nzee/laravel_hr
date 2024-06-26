<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
        'files' => 'array'
    ];

    public function leaders(){
        return $this->belongsToMany(User::class, 'project_leaders');
    }
    public function members(){
        return $this->belongsToMany(User::class, 'project_members');
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }
}
