<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExcelPreviewService;

class PreviewImportController extends Controller
{
    public function guru(Request $request)
    {
        try {

            $request->validate([
                'file' => 'required|mimes:xlsx,xls'
            ]);

            $data = (new ExcelPreviewService())
                ->preview($request->file('file')->getRealPath());

            return response()->json($data);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => basename($e->getFile()),
            ],500);

        }
    }

    public function siswa(Request $request)
    {
        try {

            $request->validate([
                'file'=>'required|mimes:xlsx,xls'
            ]);

            $data=(new ExcelPreviewService())
                ->preview($request->file('file')->getRealPath());

            return response()->json($data);

        } catch (\Throwable $e){

            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage(),
                'line'=>$e->getLine(),
                'file'=>basename($e->getFile()),
            ],500);

        }
    }
}