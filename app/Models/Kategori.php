<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
   use HasFactory;

   protected $primaryKey = 'category_id';

    protected $table = 'kategori';

    protected $attributes = [
        'name' => 'kategori'
    ];

    protected $fillable = [
        'name'
    ];
}
