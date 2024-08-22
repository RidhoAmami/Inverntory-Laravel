<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Activity;
use App\Models\Export;
use App\Models\Import;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function index()
    {
        $barangCount = Product::count();
        $kategoriCount = Category::count();
        $exportCount = Export::count();
        $importCount = Import::count();
        $supplierCount = Supplier::count();

        $exports = Export::orderBy('created_at', 'desc')->take(5)->get();

        $lowStockItems = Product::where('quantity', '<=', 5)->get();

        $totalProduct = Product::sum('quantity');

        return view('dashboard', compact(
            'barangCount', 'kategoriCount', 'exportCount', 'importCount','supplierCount', 'exports', 'lowStockItems', 'totalProduct'));
    }

}
