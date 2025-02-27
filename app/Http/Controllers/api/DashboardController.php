<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuarios;
use App\Models\Productos;
use App\Models\Articulos;
use App\Models\Orders;
use App\Models\Valoraciones;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', ['apiData' => []]);
    }
    
    public function getMetrics()
    {
        // Obtener total de usuarios
        $totalUsuarios = Usuarios::count();
        $usuariosConNewsletter = Usuarios::where('newsletter', true)->count();
        
        // Obtener estadísticas de productos
        $totalProductos = Productos::count();
        $productosVisibles = Productos::where('visible', true)->count();
        $productosSinStock = Productos::where('stock', 0)->count();
        
        // Total de artículos
        $totalArticulos = Articulos::count();
        
        // Total de órdenes y valor promedio
        $totalOrdenes = Orders::count();
        $valorPromedio = Orders::avg('costo') ?? 0;
        
        // Productos más valorados
        $productosMasValorados = Productos::select('productos.id', 'productos.nombre', DB::raw('AVG(valoraciones.valoracion) as promedio_valoracion'), DB::raw('COUNT(valoraciones.id) as total_valoraciones'))
            ->leftJoin('valoraciones', 'productos.id', '=', 'valoraciones.producto_id')
            ->groupBy('productos.id', 'productos.nombre')
            ->orderByDesc('promedio_valoracion')
            ->orderByDesc('total_valoraciones')
            ->limit(5)
            ->get();
        
        // Productos más vendidos
        $productosMasVendidos = DB::table('productos')
            ->select('productos.id', 'productos.nombre', DB::raw('SUM(productos_order.cantidad) as total_vendidos'))
            ->join('productos_order', 'productos.id', '=', 'productos_order.producto_id')
            ->groupBy('productos.id', 'productos.nombre')
            ->orderByDesc('total_vendidos')
            ->limit(5)
            ->get();

        // Ventas por mes (últimos 6 meses)
        $ventasPorMes = Orders::select(
            DB::raw('MONTH(created_at) as mes'),
            DB::raw('YEAR(created_at) as año'),
            DB::raw('SUM(costo) as total')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('año', 'mes')
            ->orderBy('año')
            ->orderBy('mes')
            ->get();

        return response()->json([
            'usuarios' => [
                'total' => $totalUsuarios,
                'newsletter' => $usuariosConNewsletter
            ],
            'productos' => [
                'total' => $totalProductos,
                'visibles' => $productosVisibles,
                'sin_stock' => $productosSinStock
            ],
            'articulos' => [
                'total' => $totalArticulos
            ],
            'ordenes' => [
                'total' => $totalOrdenes,
                'valor_promedio' => round($valorPromedio, 2)
            ],
            'productos_valorados' => $productosMasValorados,
            'productos_vendidos' => $productosMasVendidos,
            'ventas_mensuales' => $ventasPorMes
        ]);
    }
}