<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Franchise extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'franchise';

    protected $fillable = [
        'userID',
        'password',
        'code',
        'category',
        'applicant',
        'address',
        'contactNumber',
        'caseNumber',
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
        'expiresOn',
        'warning',
        'comment',
        'hasComment',
        'validIDcheck',
        'todaCheck',
        'driverCheck',
        'ORCheck',
        'CRCheck',
        'dateSubmitted',
        'signatureDate',
        'releaseDate',
        'applciationForm',
        'permitForm',
        'confirmationForm',
        'provisionalForm',
        'created_at'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'userID', 'id')->withTrashed();
    }
    public function categories() {
        return $this->hasOne(Categories::class, 'id', 'category')->withTrashed();
    }

}
