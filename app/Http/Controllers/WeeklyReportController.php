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
        //
        $startDate = now()->startOfWeek();  // Start of the current week (Monday)
        $endDate = $startDate->copy()->endOfWeek();  // End of the current week (Sunday)

        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->get();
        $totalInventory = Stock::whereBetween('created_at', [$startDate, $endDate])->get();
        $customers = Proforma::whereBetween('created_at', [$startDate, $endDate]);
        $approved = Proforma::where('status', 'verified')
                   ->whereBetween('created_at', [$startDate, $endDate])
                   ->get();
        $allocated = Proforma::where('status', 'allocated')
                   ->whereBetween('created_at', [$startDate, $endDate])
                   ->get();
        $delivered = Proforma::where('status', 'delivered')
                   ->whereBetween('created_at', [$startDate, $endDate])
                   ->get();
        $completedOrder = Proforma::where('status', 'done')
                   ->whereBetween('created_at', [$startDate, $endDate])
                   ->get();

        return $approved;

    }

    public function generateReport()
    {
        Artisan::call('report:generate');
        return response()->json(['message' => 'Report generation started.']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $report =Report::all();
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
    public function show(string $id)
    {
        //
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

    // public function weeklyReport()
    // {
    //     // Calculate the date range for the current week
    //     $startDate = Carbon::now()->startOfWeek(); // Start of the current week
    //     $endDate = Carbon::now()->endOfWeek();     // End of the current week

    //     // Fetch daily order counts within the date range
    //     $dailyOrders = Order::whereBetween('created_at', [$startDate, $endDate])
    //                         ->groupBy(DB::raw('DATE(created_at)'))
    //                         ->selectRaw('DATE(created_at) as date, COUNT(*) as order_count')
    //                         ->get();

    //     // Prepare the data for the graph
    //     $graphData = [];
    //     foreach ($dailyOrders as $dailyOrder) {
    //         $graphData[] = [
    //             'date' => $dailyOrder->date,
    //             'order_count' => $dailyOrder->order_count,
    //         ];
    //     }

    //     // Return the response
    //     return response()->json(['graph_data' => $graphData,
    //                             'start date'=>$startDate,
    //                             'end date'=>$endDate]);
    // }

    public function weeklyReport()
    {
        // Calculate the date range for the current week (starting from Monday)
        $startDate = now()->startOfWeek();  // Start of the current week (Monday)
        $endDate = $startDate->copy()->endOfWeek();  // End of the current week (Sunday)

        // Fetch daily order counts within the date range
        $dailyOrders = Order::whereBetween('created_at', [$startDate, $endDate])
                            ->groupBy(DB::raw('DATE(created_at)'))
                            ->selectRaw('DATE(created_at) as date, COUNT(*) as order_count')
                            ->get();

        // Prepare the data for the graph
        $graphData = [];
        foreach ($dailyOrders as $dailyOrder) {
            $dayName = Carbon::parse($dailyOrder->date)->format('l'); // Get the day name

            $graphData[] = [
                'day' => $dayName,
                'order_count' => $dailyOrder->order_count,
            ];
        }

        // Return the response
            return response()->json(['graph_data' => $graphData,
                                    'start date'=>$startDate,
                                    'end date'=>$endDate]);
    }
        
    public function check(){
        $startDate = now()->startOfWeek();  // Start of the current week (Monday)
        $endDate = $startDate->copy()->endOfWeek();  // End of the current week (Sunday)
        $proformaPrice = Proforma::whereBetween('created_at', [$startDate, $endDate])
                         ->sum('total_price');
        $proformaProfit = Proforma::whereBetween('created_at', [$startDate, $endDate])
                         ->sum('total_profit');
        $proforma = $proformaPrice - $proformaProfit;
        $approved = Proforma::where('status', 'pending')
                   ->whereBetween('created_at', [$startDate, $endDate])
                   ->get()->count();
        $customerCount = Proforma::whereBetween('created_at', [$startDate, $endDate])
                         ->groupBy('client_tin_number')
                         ->select('client_tin_number', DB::raw('COUNT(*) as count'))
                         ->get()
                         ->count();
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
        
        return response()->json([$dayTotals['tuesday_profit'],$dayTotals['tuesday_price']]);
    }

}
