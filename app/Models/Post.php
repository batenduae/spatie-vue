<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class Post extends Model
{
    use HasFactory, HasRoles, HasPermissions;
    use SoftDeletes;
    protected $fillable = [
        'title','content'
    ];

}
