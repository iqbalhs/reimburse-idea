<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;

    protected $primaryKey = 'proyek_id';

    protected $table = 'Proyek';

    protected $attributes = [
        'name' => 'proyek'
    ];

    protected $fillable = [
        'name'
    ];
}
