<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Proforma;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class weeklyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $startDate = now()->startOfWeek();  // Start of the current week (Monday)
        $endDate = now();  // Current date and time

        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalInventory = Stock::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalCustomer = Proforma::whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('client_tin_number')
            ->select('client_tin_number', DB::raw('COUNT(*) as count'))
            ->count();
        $approved = Proforma::where('status', 'Verified')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $allocated = Order::where('status', 'Allocated')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $delivered = Proforma::where('status', 'delivered')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $completedOrder = Proforma::where('status', 'Completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $totalRevenue = Proforma::whereBetween('created_at', [$startDate, $endDate])->sum('total_price');
        $totalProfit = Proforma::whereBetween('created_at', [$startDate, $endDate])->sum('total_profit');
        $totalCost = $totalRevenue - $totalProfit;

        // Calculate and store daily totals
        $dayTotals = [];
        $daysOfWeek = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        foreach ($daysOfWeek as $day) {
            $dayStartDate = $startDate->copy()->addDays(array_search($day, $daysOfWeek));
            $dayEndDate = $dayStartDate->copy()->endOfDay();

            $dayTotalProfit = Proforma::whereBetween('created_at', [$dayStartDate, $dayEndDate])->sum('total_profit');
            $dayTotalPrice = Proforma::whereBetween('created_at', [$dayStartDate, $dayEndDate])->sum('total_price');

            $dayTotals[$day . '_profit'] = $dayTotalProfit;
            $dayTotals[$day . '_price'] = $dayTotalPrice;
        }

        $weeklyReport = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'totalOrder' => $totalOrders,
            'totalStock' => $totalInventory,
            'approvedOrder' => $approved,
            'allocatedOrder' => $allocated,
            'deliveredOrder' => $delivered,
            'completedOrder' => $completedOrder,
            'totalCost' => $totalCost,
            'totalProfit' => $totalProfit,
            'totalCustomer' => $totalCustomer,
            'totalRevenue' => $totalRevenue,
            'daily_totals' => $dayTotals,
        ];

        return response()->json($weeklyReport, 200);
    }




    public function generateReport()
    {
        Artisan::call('report:generate');
        return response()->json(['message' => 'Report generation started.'], 404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $report = Report::all();
        return $report;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $day)
    {
        //
        $report = Report::whereDate('start_date', '<=', $day)
            ->whereDate('end_date', '>=', $day)
            ->first();
        if (!$report) {
            return response()->json(['message' => 'No report found for the specified day'], 404);
        }

        $mondayData = json_decode($report['monday'], true);
        $tuesdayData = json_decode($report['monday'], true);
        $wednesdayData = json_decode($report['monday'], true);
        $thursdayData = json_decode($report['monday'], true);
        $fridayData = json_decode($report['monday'], true);
        $saturdayData = json_decode($report['monday'], true);
        $sundayData = json_decode($report['monday'], true);

        $dailyTotals = [
            'monday_profit' => $mondayData[0],
            'monday_price' => $mondayData[1],
            'tuesday_profit' => $tuesdayData[0],
            'tuesday_price' => $tuesdayData[1],
            'wednesday_profit' => $wednesdayData[0],
            'wednesday_price' => $wednesdayData[1],
            'thursday_profit' => $thursdayData[0],
            'thursday_price' => $thursdayData[1],
            'friday_profit' => $fridayData[0],
            'friday_price' => $fridayData[1],
            'saturday_profit' => $saturdayData[0],
            'saturday_price' => $saturdayData[1],
            'sunday_profit' => $sundayData[0],
            'sunday_price' => $sundayData[1],
        ];

        // Remove the daily totals from the main report object
        unset($report->monday, $report->tuesday, $report->wednesday, $report->thursday, $report->friday, $report->saturday, $report->sunday);

        // Add the daily_totals to the main report object
        $report->daily_totals = $dailyTotals;

        return response()->json($report, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
