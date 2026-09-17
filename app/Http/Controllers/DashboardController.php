<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Client;

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard con conteos del sistema.
     */
    public function index()
    {
        $totalUsuarios  = User::count();
        $totalProductos = Product::count();
        $totalClientes  = Client::count();

        return view('dashboard.index', compact(
            'totalUsuarios',
            'totalProductos',
            'totalClientes'
        ));
    }
}
