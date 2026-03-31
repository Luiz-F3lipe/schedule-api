<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $items = collect([
            ['cliente' => 'João Silva', 'email' => 'joao@email.com', 'valor' => 1250.50, 'data' => '2026-03-10'],
            ['cliente' => 'Maria Souza', 'email' => 'maria@email.com', 'valor' => 890.90, 'data' => '2026-03-12'],
            ['cliente' => 'Carlos Lima', 'email' => 'carlos@email.com', 'valor' => 2199.99, 'data' => '2026-03-14'],
            ['cliente' => 'Ana Costa', 'email' => 'ana@email.com', 'valor' => 430.00, 'data' => '2026-03-15'],
        ]);

        $total = $items->sum('valor');

        $base64 = Pdf::view('pdf.report', [
            'title'       => 'Relatório de Vendas',
            'subtitle'    => 'Resumo financeiro do período',
            'generatedAt' => now()->format('d/m/Y H:i'),
            'items'       => $items,
            'total'       => $total,
        ])
            ->headerView('pdf.partials.header', [
                'title' => 'Relatório de Vendas',
            ])
            ->footerView('pdf.partials.footer')
            ->format('a4')
            ->margins(12, 10, 18, 10)
            ->name('relatorio-vendas.pdf')
            ->withBrowsershot(function (Browsershot $browsershot) {
                $browsershot->showBackground();
            })
            ->base64();

        return response()->json([
            'file'     => $base64,
            'filename' => 'relatorio.pdf',
            'mime'     => 'application/pdf',
        ]);
    }
}
