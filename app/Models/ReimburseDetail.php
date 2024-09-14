<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ReimburseDetail extends Model
{
    use HasFactory;

    protected $table = 'reimburse_detail';

    protected $primaryKey = 'id_reimburse_detail';

    protected $fillable = [
        'title',
        'jumlah',
        'file_path',
    ];

    public function reimburse()
    {
        return $this->hasOne(Reimburse::class, 'kode_reimburse', 'kode_reimburse');
    }

    public function isImage()
    {
        if (!Storage::exists($this->file_path)) {
            return false;
        }
        $extension = explode(separator: '.', string: $this->file_path)[1];
        return in_array(needle: $extension, haystack: ['jpg', 'jpeg', 'png']);
    }
}
