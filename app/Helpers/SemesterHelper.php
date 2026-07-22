<?php

namespace App\Helpers;

use Carbon\Carbon;

class SemesterHelper
{
    public static function semester()
    {
        $bulan = Carbon::now()->month;

        return $bulan >= 7 ? 'Ganjil' : 'Genap';
    }

    public static function tahunAjaran()
    {
        $tahun = Carbon::now()->year;
        $bulan = Carbon::now()->month;

        if ($bulan >= 7) {
            return $tahun . '/' . ($tahun + 1);
        }

        return ($tahun - 1) . '/' . $tahun;
    }

    public static function status()
    {
        return 'Aktif';
    }
}
