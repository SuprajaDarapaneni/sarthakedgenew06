<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use App\Models\School;
use App\Models\Subscription;
use App\Services\CachingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{
    public function index()
    {
        $year = request()->get('year', date('Y'));
        $settings = app(CachingService::class)->getSystemSettings();

        // Get available years for the filter
        $availableYears = PaymentTransaction::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();
        
        if (empty($availableYears)) {
            $availableYears = [(int)date('Y')];
        }

        // --- Core Stats ---
        $totalRevenue = PaymentTransaction::where('payment_status', 'succeed')
            ->whereYear('created_at', $year)
            ->sum('amount');

        $prevYearRevenue = PaymentTransaction::where('payment_status', 'succeed')
            ->whereYear('created_at', $year - 1)
            ->sum('amount');
        
        $growth = $prevYearRevenue > 0 ? (($totalRevenue - $prevYearRevenue) / $prevYearRevenue) * 100 : 0;

        // MRR Calculation
        $mrr = 0;
        $today = Carbon::now()->format('Y-m-d');
        $active_subscriptions = Subscription::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->with('package')
            ->get();
        
        foreach ($active_subscriptions as $sub) {
            if ($sub->package && $sub->package->days > 0) {
                // Approximate MRR for the current active subscriptions
                $mrr += ($sub->charges * 30) / $sub->package->days;
            }
        }
        $arr = $mrr * 12;

        $schoolCount = School::where('status', 1)->count() ?: 1;
        $avgPerSchool = $totalRevenue / $schoolCount;

        // --- Stream Breakdown ---
        $subscriptionRevenue = PaymentTransaction::where('payment_status', 'succeed')
            ->where('type', 'subscription')
            ->whereYear('created_at', $year)
            ->sum('amount');

        $addonRevenue = PaymentTransaction::where('payment_status', 'succeed')
            ->where('type', 'addon')
            ->whereYear('created_at', $year)
            ->sum('amount');

        $otherRevenue = $totalRevenue - ($subscriptionRevenue + $addonRevenue);

        // --- Monthly Collections (for Chart) ---
        $monthlyTrend = array_fill(1, 12, 0);
        $monthlySubTrend = array_fill(1, 12, 0);
        $monthlyAddonTrend = array_fill(1, 12, 0);
        $monthlyOtherTrend = array_fill(1, 12, 0);

        $results = PaymentTransaction::where('payment_status', 'succeed')
            ->whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, type, SUM(amount) as total')
            ->groupBy('month', 'type')
            ->get();

        foreach ($results as $res) {
            $monthNum = (int)$res->month;
            $monthlyTrend[$monthNum] += $res->total;
            if ($res->type == 'subscription') {
                $monthlySubTrend[$monthNum] = (float)$res->total;
            } elseif ($res->type == 'addon') {
                $monthlyAddonTrend[$monthNum] = (float)$res->total;
            } else {
                $monthlyOtherTrend[$monthNum] += (float)$res->total;
            }
        }

        // Handle Download Request
        if (request('download') == 'csv') {
            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="revenue_report_' . $year . '.csv"',
            ];
            $callback = function () use ($months, $monthlyTrend, $monthlySubTrend, $monthlyAddonTrend, $monthlyOtherTrend) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['Month', 'Total Revenue', 'Subscriptions', 'Add-ons', 'Other']);
                for ($i = 0; $i < 12; $i++) {
                    fputcsv($file, [$months[$i], $monthlyTrend[$i + 1], $monthlySubTrend[$i + 1], $monthlyAddonTrend[$i + 1], $monthlyOtherTrend[$i + 1]]);
                }
                fclose($file);
            };
            return response()->stream($callback, 200, $headers);
        }

        return view('revenue.index', compact(
            'totalRevenue', 'mrr', 'arr', 'avgPerSchool', 'monthlyTrend', 
            'monthlySubTrend', 'monthlyAddonTrend', 'monthlyOtherTrend', 
            'subscriptionRevenue', 'addonRevenue', 'otherRevenue', 
            'year', 'availableYears', 'growth', 'settings'
        ));
    }
}
