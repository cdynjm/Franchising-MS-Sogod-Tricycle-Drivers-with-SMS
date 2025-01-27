<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Province extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'province';

    protected $fillable = [
       'psgcCode',
       'provDesc',
       'regCode',
       'provCode'
    ];
}
