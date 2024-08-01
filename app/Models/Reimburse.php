<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reimburse extends Model
{
    use HasFactory;

    protected $table = 'reimburse';

    protected $fillable = [
        'kode',
	    'project_id',
	    'category_id',
	    'staff_id',
	    'date',
	    'title',
	    'remark',
	    'status_staff',
	    'status_hr',
	    'status_finance',
    ];
}
