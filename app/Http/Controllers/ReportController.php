<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Exibe a tela de relatórios
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Product::all();
        $users = User::all();
        return view('admin.reports.index', compact('products', 'users'));
    }

    public function stockEntry(Request $request)
    {
        $movements = null;

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            $startDate = $request->start_date . ' 00:00:00';
            $endDate = $request->end_date . ' 23:59:59';

            $movements = StockMovement::with('product')
                ->where('type', 'entrada')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();
        }

        return view('admin.reports.stock_entry', compact('movements'));
    }

    /**
     * Gera relatório baseado nos filtros
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
    public function gerarRelatorio(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'report_type' => 'required|in:entradas,saidas,estoque_atual',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $startDate = $request->start_date . ' 00:00:00';
        $endDate = $request->filled('end_date') ? $request->end_date . ' 23:59:59' : now()->format('Y-m-d') . ' 23:59:59';
        $reportType = $request->report_type;
        $userId = $request->user_id;

        $data = [];

        if ($reportType === 'entradas') {
            $query = StockMovement::with('product', 'user')
                ->where('type', 'entrada')
                ->whereBetween('created_at', [$startDate, $endDate]);

            if ($userId && $userId != 'todos') {
                $query->where('user_id', $userId);
            }

            $data = $query->orderBy('created_at', 'desc')->get();
        } elseif ($reportType === 'saidas') {
            $query = StockMovement::with('product', 'user')
                ->where('type', 'saida')
                ->whereBetween('created_at', [$startDate, $endDate]);

            if ($userId && $userId != 'todos') {
                $query->where('user_id', $userId);
            }

            $data = $query->orderBy('created_at', 'desc')->get();
        } elseif ($reportType === 'estoque_atual') {
            $data = Stock::with('product')
                ->whereHas('product')
                ->get();
        }

        if ($request->has('export_pdf')) {
            $userName = $userId && $userId != 'todos' ? User::find($userId)->name : 'Todos';
            return PDF::loadView('admin.reports.pdf_relatorio', compact('data', 'reportType', 'startDate', 'endDate', 'userName'))
                ->download('relatorio-estoque-' . now()->format('Y-m-d') . '.pdf');
        }

        return view('admin.reports.index', [
            'products' => Product::all(),
            'users' => User::all(),
            'data' => $data,
            'reportType' => $reportType,
            'startDate' => $request->start_date,
            'endDate' => $request->end_date,
            'userId' => $userId,
        ]);
    }
}
