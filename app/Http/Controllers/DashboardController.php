<?php

namespace App\Http\Controllers;

use App\Enums\StatusFinance;
use App\Enums\StatusHr;
use App\Enums\StatusKaryawan;
use App\Models\Reimburse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $baru = Reimburse::where('status_staff', StatusKaryawan::DRAFT)->count();
        $reviewHR = Reimburse::where('status_hr', StatusHr::REVIEW)->where('status_staff', StatusKaryawan::SENT)->count();
        $reviewFinance = Reimburse::where('status_finance', StatusFinance::REVIEW)
            ->where('status_hr', StatusHr::ACCEPT)
            ->where('status_staff', StatusKaryawan::SENT)
            ->count();
        $processed = Reimburse::where('status_finance', StatusFinance::FINISH)->count();
        return view('dashboard.index', [
            'baru' => $baru,
            'reviewHR' => $reviewHR,
            'reviewFinance' => $reviewFinance,
            'processed' => $processed
        ]);
    }
}
