<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Barangay extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'barangay';

    protected $fillable = [
       'brgyCode',
       'brgyDesc',
       'regCode',
       'provCode',
       'citymunCode'
    ];
}
