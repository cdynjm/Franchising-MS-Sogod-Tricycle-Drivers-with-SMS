<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'category',
        'color',
        'description',
        'picture'
    ];

    public function users() {
        return $this->hasMany(User::class, 'category', 'id')->withTrashed();
    }
}
