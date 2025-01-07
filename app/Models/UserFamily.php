<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFamily extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'relation',
        'name',
        'religion',
        'gender',
        'birthDay',
        'bloodGroup',
        'phone',
        'email',
        'imagePath',
        'anniversaryDay'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
