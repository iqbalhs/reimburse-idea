<?php

namespace App\Models;

use App\Enums\StatusFinance;
use App\Enums\StatusHr;
use App\Enums\StatusKaryawan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


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

    public function reimburseDetail()
    {
        return $this->hasMany(ReimburseDetail::class, 'reimburse_id', 'id');
    }

    public function updateJumlah()
    {
        $this->jumlah_total = $this->reimburseDetail()->sum('jumlah');
        return $this->save();
    }

    public function isKaryawanDraft()
    {
        return $this->status_staff === StatusKaryawan::DRAFT->value;
    }

    public function isKaryawanSent()
    {
        return $this->status_staff === StatusKaryawan::SENT->value;
    }

    public function isHrReview()
    {
        return $this->status_hr === StatusHr::REVIEW->value;
    }

    public function isHrAccept()
    {
        return $this->status_hr === StatusHr::ACCEPT->value;
    }

    public function isHrReject()
    {
        return $this->status_hr === StatusHr::REJECT->value;
    }

    public function isFinanceReview()
    {
        return $this->status_finance === StatusFinance::REVIEW->value;
    }

    public function isFinanceAccept()
    {
        return $this->status_finance === StatusFinance::ACCEPT->value;
    }

    public function isFinanceReject()
    {
        return $this->status_finance === StatusFinance::REJECT->value;
    }

    public function isFinanceFinish()
    {
        return $this->status_finance === StatusFinance::FINISH->value;
    }

    public function scopeHrViewable(Builder $query): void
    {
        $query->where('status_staff', StatusKaryawan::SENT)
        ->orWhereIn('status_hr', [
            StatusHr::ACCEPT,
            StatusHr::REJECT,
        ]);
    }

    public function scopeFinanceViewable(Builder $query): void
    {
        $query->where('status_hr', StatusHr::ACCEPT)
            ->orWhereIn(
                'status_finance',
                [
                    StatusFinance::ACCEPT,
                    StatusFinance::REJECT,
                    StatusFinance::FINISH,
                ]
            );
    }
}
