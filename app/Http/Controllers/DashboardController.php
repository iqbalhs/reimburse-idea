<?php

namespace App\Http\Controllers;

use App\Enums\StatusFinance;
use App\Enums\StatusHr;
use App\Enums\StatusKaryawan;
use App\Models\Reimburse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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

        $year = Carbon::now()->year; // Replace with the year you want to query

        $monthlyCounts = DB::table('reimburse')
            ->select(DB::raw('MONTH(date) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('date', $year)
            ->groupBy(DB::raw('MONTH(date)'))
            ->pluck('count', 'month')
            ->toArray();

        // Fill missing months with 0
        $barCharts = [];
        for ($i = 1; $i <= 12; $i++) {
            $barCharts[$i] = isset($monthlyCounts[$i]) ? (int) $monthlyCounts[$i] : 0;
        }

        // Query to count reimbursements grouped by category
        $reimbursementsByCategory = Reimburse::select('category_id', DB::raw('count(*) as total'))
            ->groupBy('category_id')
            ->with('kategori') // Eager load the related category
            ->get();

        // Prepare the labels (category names) and data (count of reimbursements per category)
        $pieLabels = [];
        $pieData = [];

        foreach ($reimbursementsByCategory as $reimburse) {
            $pieLabels[] = $reimburse->kategori->name; // Assuming 'name' is the category's name column
            $pieData[] = $reimburse->total;
        }
        return view('dashboard.index', [
            'baru' => $baru,
            'reviewHR' => $reviewHR,
            'reviewFinance' => $reviewFinance,
            'processed' => $processed,
            'barCharts' => array_values($barCharts),
            'pieLabels' => $pieLabels,
            'pieData' => $pieData,
        ]);
    }
}
