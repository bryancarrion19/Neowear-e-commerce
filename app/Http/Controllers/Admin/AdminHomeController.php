<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminHomeController extends Controller
{
    public function index()
    {
        $viewData = [];
        $viewData["title"] = "Panel de Control - Admin";

        // Estadísticas generales
        $viewData["totalOrders"] = Order::count();
        $viewData["totalProducts"] = Product::count();
        $viewData["totalUsers"] = User::count();
        $viewData["totalSales"] = Order::sum('total');

        // Ventas por mes (últimos 6 meses)
        $monthlyStats = Order::select(
            DB::raw('sum(total) as total'),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $viewData["monthlyLabels"] = $monthlyStats->pluck('month');
        $viewData["monthlySales"] = $monthlyStats->pluck('total');

        // Productos más vendidos
        $topProducts = DB::table('items')
            ->join('products', 'items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('sum(items.quantity) as total'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $viewData["topProducts"] = $topProducts;

        return view('admin.home.index')->with("viewData", $viewData);
    }
}
