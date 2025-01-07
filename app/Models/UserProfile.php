<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'imagePath',
        'formalPhoto',
        'religion',
        'gender',
        'birthDay',
        'bloodGroup',
        'primaryPhone',
        'secondaryPhone'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
