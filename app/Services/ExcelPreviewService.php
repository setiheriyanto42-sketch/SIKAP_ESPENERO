<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelPreviewService
{
    public function preview($file)
    {
        $spreadsheet = IOFactory::load($file);

        $sheet = $spreadsheet->getActiveSheet();

        $rows = [];

        foreach ($sheet->toArray() as $index => $row) {

            if ($index == 0) {
                continue; // lewati header
            }

            if (empty(array_filter($row))) {
                continue; // lewati baris kosong
            }

            $rows[] = array_map(function ($value) {
                return trim((string) $value);
            }, $row);

        }

        return $rows;
    }
}
