<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Franchise extends Model
{
    use HasFactory;

    protected $table = 'franchise';

    protected $fillable = [
        'userID',
        'code',
        'category',
        'applicant',
        'address',
        'contactNumber',
        'make',
        'motorNumber',
        'chassisNumber',
        'plateNumber',
        'validID',
        'clearanceFront',
        'clearanceBack',
        'officialReceipt',
        'certificate',
        'cardFront',
        'cardBack',
        'mayor',
        'police',
        'payment',
        'status',
        'isActive',
        'expiresOn'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'userID', 'id');
    }
    public function categories() {
        return $this->hasOne(Categories::class, 'id', 'category');
    }
}
