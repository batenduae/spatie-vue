<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserEducationalBackground extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'degree',
        'institution',
        'session',
        'dept_group',
        'passingYear',
        'result',
        'description'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
