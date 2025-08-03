<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Request as RequestModel;
use App\Models\RequestItem;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Exibe a tela de relatórios
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::all();
        return view('admin.reports.index', compact('users'));
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
            'report_type' => 'required|in:entrada,saida,entrada_saida',
            'user_id' => 'nullable',
        ]);

        // Validação customizada para user_id
        if ($request->filled('user_id') && $request->user_id !== 'todos') {
            $request->validate([
                'user_id' => 'exists:users,id',
            ]);
        }

        $startDate = $request->start_date . ' 00:00:00';
        $endDate = $request->filled('end_date') ? $request->end_date . ' 23:59:59' : now()->format('Y-m-d') . ' 23:59:59';
        $reportType = $request->report_type;
        $userId = $request->user_id;

        $data = [];
        $totals = [];

        if ($reportType === 'entrada' || $reportType === 'entrada_saida') {
            $data['entrada'] = $this->getEntradaRelatorio($startDate, $endDate, $userId);
            $totals['entrada'] = $this->calculateEntradaTotals($data['entrada']);
        }

        if ($reportType === 'saida' || $reportType === 'entrada_saida') {
            $data['saida'] = $this->getSaidaRelatorio($startDate, $endDate, $userId);
            $totals['saida'] = $this->calculateSaidaTotals($data['saida']);
        }

        if ($request->has('export_pdf')) {
            $userName = $userId && $userId != 'todos' ? User::find($userId)->name : 'Todos';
            return PDF::loadView('admin.reports.pdf_relatorio', compact('data', 'totals', 'reportType', 'startDate', 'endDate', 'userName'))
                ->download('relatorio-requisicoes-' . now()->format('Y-m-d') . '.pdf');
        }

        return view('admin.reports.index', [
            'users' => User::all(),
            'data' => $data,
            'totals' => $totals,
            'reportType' => $reportType,
            'startDate' => $request->start_date,
            'endDate' => $request->end_date,
            'userId' => $userId,
        ]);
    }

    /**
     * Gera relatório de entrada de estoque
     */
    private function getEntradaRelatorio($startDate, $endDate, $userId)
    {
        $query = RequestItem::with(['request.user', 'product'])
            ->whereHas('request', function ($q) use ($startDate, $endDate, $userId) {
                $q->whereBetween('requested_at', [$startDate, $endDate]);
                if ($userId && $userId != 'todos') {
                    $q->where('user_id', $userId);
                }
            });

        $items = $query->get();

        $groupedData = [];

        foreach ($items as $item) {
            $productName = $item->product->name;

            if (!isset($groupedData[$productName])) {
                $groupedData[$productName] = [
                    'product' => $item->product,
                    'quantity' => 0,
                    'total_cost' => 0,
                    'total_sale' => 0
                ];
            }

            $groupedData[$productName]['quantity'] += $item->quantity;
            $groupedData[$productName]['total_cost'] += $item->quantity * $item->product->cost_price;
            $groupedData[$productName]['total_sale'] += $item->quantity * $item->product->sale_price;
        }

        return $groupedData;
    }

    /**
     * Gera relatório de saída de estoque
     */
    private function getSaidaRelatorio($startDate, $endDate, $userId)
    {
        $query = RequestItem::with(['request.user', 'product'])
            ->whereHas('request', function ($q) use ($startDate, $endDate, $userId) {
                $q->whereBetween('requested_at', [$startDate, $endDate]);
                if ($userId && $userId != 'todos') {
                    $q->where('user_id', $userId);
                }
            });

        $items = $query->get();

        $groupedData = [];

        foreach ($items as $item) {
            $product = $item->product;

            if ($product->type === 'composite') {
                // Para produtos compostos, calcular os componentes simples
                foreach ($product->components as $component) {
                    $componentName = $component->name;
                    $componentQuantity = $item->quantity * $component->pivot->quantity;

                    if (!isset($groupedData[$componentName])) {
                        $groupedData[$componentName] = [
                            'product' => $component,
                            'quantity' => 0,
                            'total_cost' => 0
                        ];
                    }

                    $groupedData[$componentName]['quantity'] += $componentQuantity;
                    $groupedData[$componentName]['total_cost'] += $componentQuantity * $component->cost_price;
                }
            } else {
                // Para produtos simples
                $productName = $product->name;

                if (!isset($groupedData[$productName])) {
                    $groupedData[$productName] = [
                        'product' => $product,
                        'quantity' => 0,
                        'total_cost' => 0
                    ];
                }

                $groupedData[$productName]['quantity'] += $item->quantity;
                $groupedData[$productName]['total_cost'] += $item->quantity * $product->cost_price;
            }
        }

        return $groupedData;
    }

    /**
     * Calcula totais do relatório de entrada
     */
    private function calculateEntradaTotals($data)
    {
        $totalCost = 0;
        $totalSale = 0;

        foreach ($data as $item) {
            $totalCost += $item['total_cost'];
            $totalSale += $item['total_sale'];
        }

        return [
            'total_cost' => $totalCost,
            'total_sale' => $totalSale
        ];
    }

    /**
     * Calcula totais do relatório de saída
     */
    private function calculateSaidaTotals($data)
    {
        $totalCost = 0;

        foreach ($data as $item) {
            $totalCost += $item['total_cost'];
        }

        return [
            'total_cost' => $totalCost
        ];
    }
}
