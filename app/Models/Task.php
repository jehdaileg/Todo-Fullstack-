<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $casts = [

        'done' => 'boolean'

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subTasks()
    {
        return $this->hasMany(Task::class, 'parent_id')->whereNull();
    }
}
