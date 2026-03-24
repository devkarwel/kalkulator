<?php

namespace App\Services;

use App\Models\CompanyInfo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PdfGenerator
{
    public function generate(
        array $summary,
        array $priceInfo
    ): string {
        $company = CompanyInfo::first();
        $user = auth()->user();

        $pdf = Pdf::loadView('pdf.summary', [
            'summary' => $summary,
            'priceInfo' => $priceInfo,
            'product' => $summary['product'],
            'company' => $company,
            'user' => $user,
        ])->setOption('defaultFont', 'DejaVu Sans')
          ->setOption('isHtml5ParserEnabled', true)
          ->setOption('isRemoteEnabled', true);

        $fileName = 'kalkulacja_' . Str::random(8) . now()->format('Ymd_His') . '.pdf';
        $filePath = 'pdf/' . $fileName;

        Storage::disk('public')->put($filePath, $pdf->output());

        return $filePath;
    }
}
