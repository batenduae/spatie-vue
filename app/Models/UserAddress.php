<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'addressType',
        'district',
        'typeVillageMunicipalityCity',
        'upazillaCity',
        'unionMunicipality',
        'wardCouncil',
        'villageMohokuma',
        'roadNo',
        'houseNo',
        'otherDetails'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
