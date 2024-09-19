<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class Post extends Model
{
    use HasFactory, HasRoles, HasPermissions;
    protected $fillable = [
        'title','content'
    ];

}
