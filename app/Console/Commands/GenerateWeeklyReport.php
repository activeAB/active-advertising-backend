<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Stock;
use App\Models\Report;
use App\Models\Proforma;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateWeeklyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weekly-report:generate';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startDate = now()->startOfWeek();  // Start of the current week (Monday)
        $endDate = $startDate->copy()->endOfWeek();  // End of the current week (Sunday)

        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->get()->count();
        $totalInventory = Stock::whereBetween('created_at', [$startDate, $endDate])->get()->count();
        $totalCustomer = Proforma::whereBetween('created_at', [$startDate, $endDate])
                         ->groupBy('client_tin_number')
                         ->select('client_tin_number', DB::raw('COUNT(*) as count'))
                         ->get()
                         ->count();
        $approved = Proforma::where('status', 'verified')
                   ->whereBetween('created_at', [$startDate, $endDate])
                   ->get()->count();
        $allocated = Proforma::where('status', 'allocated')
                   ->whereBetween('created_at', [$startDate, $endDate])
                   ->get()->count();
        $delivered = Proforma::where('status', 'delivered')
                   ->whereBetween('created_at', [$startDate, $endDate])
                   ->get()->count();
        $completedOrder = Proforma::where('status', 'done')
                   ->whereBetween('created_at', [$startDate, $endDate])
                   ->get()->count();
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
        
        Report::create([
            'start_date' => $startDate,
            'end_date' => $endDate,
            'totalOrder' => $totalOrders,
            'totalStock' => $totalInventory,
            'approvedOrder' => $approved,
            'allocatedOrder' => $allocated,
            'deliveredOrder' => $delivered,
            'completedOrder' => $completedOrder,
            'totalCost'=> $totalCost,
            'totalProfit'=> $totalProfit,
            'totalCustomer'=> $totalCustomer,
            'totalRevenue'=> $totalRevenue ,
            'monday' => json_encode(['profit' => $dayTotals['monday_profit'], 'price' => $dayTotals['monday_price']]),
            'tuesday' => json_encode(['profit' => $dayTotals['tuesday_profit'], 'price' => $dayTotals['tuesday_price']]),
            'wednesday' => json_encode(['profit' => $dayTotals['wednesday_profit'], 'price' => $dayTotals['wednesday_price']]),
            'thursday' => json_encode(['profit' => $dayTotals['thursday_profit'], 'price' => $dayTotals['thursday_price']]),
            'friday' => json_encode(['profit' => $dayTotals['friday_profit'], 'price' => $dayTotals['friday_price']]),
            'saturday' => json_encode(['profit' => $dayTotals['saturday_profit'], 'price' => $dayTotals['saturday_price']]),
            'sunday' => json_encode(['profit' => $dayTotals['sunday_profit'], 'price' => $dayTotals['sunday_price']])
        ]);

        

        $this->info('Weekly report generated and stored successfully.');
    }
}
