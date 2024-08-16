<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReimburseDetail extends Model
{
    use HasFactory;

    protected $table = 'reimburse_detail';

    protected $fillable = [
        'title',
        'jumlah',
        'file_path',
    ];
}
