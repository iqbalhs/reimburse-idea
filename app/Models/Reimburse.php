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

    public function generateKode()
    {
        $this->kode = 'RMB-' . date('YmdHis') . random_int(1, 9);
    }

    public function kategori()
    {
        return $this->hasOne(Kategori::class, 'id', 'category_id');
    }


    public function proyek()
    {
        return $this->hasOne(Proyek::class, 'id', 'project_id');
    }
}
