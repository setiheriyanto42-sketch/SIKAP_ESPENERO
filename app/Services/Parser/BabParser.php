<?php

namespace App\Services\Parser;

use App\Services\Parser\PertemuanParser;

class BabParser
{
    public function parse(string $text): array
    {
        $hasil = [];

        /*
        |--------------------------------------------------------------------------
        | NORMALISASI TEKS
        |--------------------------------------------------------------------------
        */

        $text = preg_replace(
            "/\r\n|\r/",
            "\n",
            $text
        );

        $text = trim($text);

        if ($text === '') {
            return [];
        }

        /*
        |--------------------------------------------------------------------------
        | DETEKSI BAB
        |--------------------------------------------------------------------------
        |
        | Mendukung:
        |
        | BAB I. JUDUL
        | BAB II. JUDUL
        | BAB 1. JUDUL
        | BAB 2 - JUDUL
        | BAB 3: JUDUL
        |
        */

        preg_match_all(
            '/^BAB\s+(I|II|III|IV|V|VI|VII|VIII|IX|X|XI|XII|XIII|XIV|XV|XVI|XVII|XVIII|XIX|XX|\d+)\s*[\.\:\-]?\s*(.+)$/imu',
            $text,
            $matches,
            PREG_OFFSET_CAPTURE
        );

        /*
        |--------------------------------------------------------------------------
        | TIDAK ADA BAB
        |--------------------------------------------------------------------------
        */

        if (empty($matches[0])) {
            return [];
        }

        $jumlah = count($matches[0]);

        /*
        |--------------------------------------------------------------------------
        | PROSES SETIAP BAB
        |--------------------------------------------------------------------------
        */

        for ($i = 0; $i < $jumlah; $i++) {

            $awal = $matches[0][$i][1];

            $akhir = ($i === $jumlah - 1)
                ? strlen($text)
                : $matches[0][$i + 1][1];

            /*
            |--------------------------------------------------------------------------
            | ISI BAB
            |--------------------------------------------------------------------------
            */

            $isiBab = substr(
                $text,
                $awal,
                $akhir - $awal
            );

            $isiBab = trim($isiBab);

            /*
            |--------------------------------------------------------------------------
            | PARSER PERTEMUAN
            |--------------------------------------------------------------------------
            */

            $pertemuanParser = new PertemuanParser();

            $pertemuan = $pertemuanParser->parse(
                $isiBab
            );

            /*
            |--------------------------------------------------------------------------
            | SIMPAN STRUKTUR BAB
            |--------------------------------------------------------------------------
            */

            $hasil[] = [

                'nomor' => $this->normalisasiNomorBab(
                    $matches[1][$i][0]
                ),

                'judul' => trim(
                    $matches[2][$i][0]
                ),

                'isi' => $isiBab,

                'pertemuan' => $pertemuan,

            ];
        }

        return $hasil;
    }

    /*
    |--------------------------------------------------------------------------
    | NORMALISASI NOMOR BAB
    |--------------------------------------------------------------------------
    */

    private function normalisasiNomorBab($nomor): int
    {
        $nomor = trim((string) $nomor);

        /*
        |--------------------------------------------------------------------------
        | ANGKA BIASA
        |--------------------------------------------------------------------------
        */

        if (is_numeric($nomor)) {
            return (int) $nomor;
        }

        /*
        |--------------------------------------------------------------------------
        | ANGKA ROMAWI
        |--------------------------------------------------------------------------
        */

        $romawi = [

            'I'      => 1,
            'II'     => 2,
            'III'    => 3,
            'IV'     => 4,
            'V'      => 5,
            'VI'     => 6,
            'VII'    => 7,
            'VIII'   => 8,
            'IX'     => 9,
            'X'      => 10,
            'XI'     => 11,
            'XII'    => 12,
            'XIII'   => 13,
            'XIV'    => 14,
            'XV'     => 15,
            'XVI'    => 16,
            'XVII'   => 17,
            'XVIII'  => 18,
            'XIX'    => 19,
            'XX'     => 20,

        ];

        $nomor = strtoupper($nomor);

        return $romawi[$nomor] ?? 1;
    }
}