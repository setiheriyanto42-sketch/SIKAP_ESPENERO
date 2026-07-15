<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExcelPreviewService;

class PreviewImportController extends Controller
{
    public function guru(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        return response()->json(
            (new ExcelPreviewService())->preview(
                $request->file('file')->getRealPath()
            )
        );
    }

    public function siswa(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        return response()->json(
            (new ExcelPreviewService())->preview(
                $request->file('file')->getRealPath()
            )
        );
    }
}
