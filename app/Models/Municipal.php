<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Municipal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'municipal';

    protected $fillable = [
       'psgcCode',
       'citymunDesc',
       'regDesc',
       'provCode',
       'citymunCode'
    ];
}
