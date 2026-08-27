<?php

namespace App\Services;

use Smalot\PdfParser\Parser;
use RuntimeException;

class JadwalPdfParser
{
    /**
     * Kode guru resmi dari jadwal SMPN 2 Jatiroto.
     *
     * Kode AA dan AB harus diperiksa lebih dahulu
     * sebelum kode satu huruf.
     */
    protected array $kodeGuru = [
        'AA',
        'AB',
        'A',
        'B',
        'C',
        'D',
        'E',
        'F',
        'G',
        'H',
        'I',
        'J',
        'K',
        'L',
        'M',
        'N',
        'O',
        'P',
        'Q',
        'R',
        'S',
        'T',
        'U',
        'V',
        'W',
        'X',
        'Y',
        'Z',
    ];

    /**
     * Urutan kolom kelas pada setiap tabel.
     */
    protected array $kelasKolom = [
        '7A',
        '7B',
        '7C',
        '7D',
        '7E',
        '7F',

        '8A',
        '8B',
        '8C',
        '8D',
        '8E',
        '8F',

        '9A',
        '9B',
        '9C',
        '9D',
        '9E',
        '9F',
    ];

    /**
     * Struktur enam tabel dalam PDF.
     *
     * Setiap tabel memiliki sisi kiri dan kanan:
     * kiri = 18 kelas
     * kanan = 18 kelas
     */
    protected array $hari = [
        [
            'nama' => 'Senin',
            'y_min' => 120,
            'y_max' => 275,
        ],
        [
            'nama' => 'Selasa',
            'y_min' => 120,
            'y_max' => 275,
        ],
        [
            'nama' => 'Rabu',
            'y_min' => 275,
            'y_max' => 440,
        ],
        [
            'nama' => 'Kamis',
            'y_min' => 275,
            'y_max' => 440,
        ],
        [
            'nama' => 'Jumat',
            'y_min' => 440,
            'y_max' => 590,
        ],
        [
            'nama' => 'Sabtu',
            'y_min' => 440,
            'y_max' => 590,
        ],
    ];

    /**
     * Parse file PDF jadwal.
     */
    public function parse(string $path): array
    {
        if (! file_exists($path)) {
            throw new RuntimeException(
                "File PDF tidak ditemukan: {$path}"
            );
        }

        $parser = new Parser();

        $pdf = $parser->parseFile($path);

        $pages = $pdf->getPages();

        if (count($pages) === 0) {
            throw new RuntimeException(
                'PDF tidak mempunyai halaman yang dapat dibaca.'
            );
        }

        $page = $pages[0];

        /*
         * getDataTm() dipakai karena kita membutuhkan
         * posisi X/Y setiap teks.
         */
        $data = $page->getDataTm();

        return $this->parsePageData($data);
    }

    /**
     * Mengolah data posisi PDF.
     */
    protected function parsePageData(array $data): array
    {
        $blocks = [];

        foreach ($data as $item) {
            if (! isset($item[0], $item[1])) {
                continue;
            }

            $matrix = $item[0];
            $text = trim((string) $item[1]);

            if ($text === '') {
                continue;
            }

            $x = (float) ($matrix[4] ?? 0);
            $y = (float) ($matrix[5] ?? 0);

            /*
             * PDF mempunyai koordinat Y dari bawah.
             * Kita konversikan nanti berdasarkan tinggi halaman.
             */
            $blocks[] = [
                'x' => $x,
                'y_pdf' => $y,
                'text' => $text,
            ];
        }

        if (empty($blocks)) {
            throw new RuntimeException(
                'PDF terbaca tetapi tidak ditemukan teks.'
            );
        }

        /*
         * Ambil nilai Y maksimum.
         * Koordinat visual kita ubah menjadi
         * top-down seperti pada halaman PDF.
         */
        $maxY = max(
            array_column($blocks, 'y_pdf')
        );

        foreach ($blocks as &$block) {
            $block['y'] = $maxY - $block['y_pdf'];
        }

        unset($block);

        /*
         * Kelompokkan berdasarkan baris.
         */
        $rows = $this->groupByY($blocks);

        $hasil = [];

        /*
         * PDF terdiri dari tiga baris blok:
         *
         * Senin / Selasa
         * Rabu / Kamis
         * Jumat / Sabtu
         */
        $pasanganHari = [
            ['Senin', 'Selasa', 120, 275],
            ['Rabu', 'Kamis', 275, 440],
            ['Jumat', 'Sabtu', 440, 590],
        ];

        foreach ($pasanganHari as $pasangan) {
            [$hariKiri, $hariKanan, $yMin, $yMax] = $pasangan;

            foreach ($rows as $row) {
                if ($row['y'] < $yMin || $row['y'] > $yMax) {
                    continue;
                }

                /*
                 * Bagian kiri PDF.
                 */
                $kiri = $this->ambilBarisTabel(
                    $row['items'],
                    0,
                    297
                );

                /*
                 * Bagian kanan PDF.
                 */
                $kanan = $this->ambilBarisTabel(
                    $row['items'],
                    300,
                    590
                );

                if ($kiri !== null) {
                    $hasil = array_merge(
                        $hasil,
                        $this->buatJadwalBaris(
                            $hariKiri,
                            $kiri
                        )
                    );
                }

                if ($kanan !== null) {
                    $hasil = array_merge(
                        $hasil,
                        $this->buatJadwalBaris(
                            $hariKanan,
                            $kanan
                        )
                    );
                }
            }
        }

        return $hasil;
    }

    /**
     * Kelompokkan teks berdasarkan posisi Y.
     */
    protected function groupByY(array $blocks): array
    {
        usort(
            $blocks,
            fn ($a, $b) => $a['y'] <=> $b['y']
        );

        $rows = [];

        foreach ($blocks as $block) {
            $found = false;

            foreach ($rows as &$row) {
                if (abs($row['y'] - $block['y']) <= 1.5) {
                    $row['items'][] = $block;

                    $row['y'] = (
                        $row['y'] + $block['y']
                    ) / 2;

                    $found = true;

                    break;
                }
            }

            unset($row);

            if (! $found) {
                $rows[] = [
                    'y' => $block['y'],
                    'items' => [$block],
                ];
            }
        }

        return $rows;
    }

    /**
     * Ambil satu baris tabel berdasarkan X.
     */
    protected function ambilBarisTabel(
        array $items,
        float $xMin,
        float $xMax
    ): ?array {
        $items = array_filter(
            $items,
            function ($item) use ($xMin, $xMax) {
                return $item['x'] >= $xMin
                    && $item['x'] <= $xMax;
            }
        );

        if (empty($items)) {
            return null;
        }

        usort(
            $items,
            fn ($a, $b) => $a['x'] <=> $b['x']
        );

        /*
         * Cari nomor jam dan waktu.
         */
        $jamKe = null;
        $jamMulai = null;
        $jamSelesai = null;

        foreach ($items as $item) {
            $text = trim($item['text']);

            /*
             * Nomor JP.
             */
            if (
                $item['x'] < $xMin + 40
                && preg_match(
                    '/^[1-8]$/',
                    $text
                )
            ) {
                $jamKe = (int) $text;
            }

            /*
             * Waktu.
             */
            if (
                preg_match(
                    '/(\d{1,2}\.\d{2})/',
                    $text,
                    $match
                )
            ) {
                if ($jamMulai === null) {
                    $jamMulai = $this->normalisasiJam(
                        $match[1]
                    );
                }

                /*
                 * Bila teks seperti 08.20M1,
                 * jam selesai tetap berhasil diambil.
                 */
                if (
                    preg_match_all(
                        '/(\d{1,2}\.\d{2})/',
                        $text,
                        $matches
                    )
                    && count($matches[1]) >= 2
                ) {
                    $jamMulai = $this->normalisasiJam(
                        $matches[1][0]
                    );

                    $jamSelesai = $this->normalisasiJam(
                        $matches[1][1]
                    );
                }
            }
        }

        /*
         * Jika waktu tersebar di beberapa blok,
         * ambil semua waktu.
         */
        $semuaWaktu = [];

        foreach ($items as $item) {
            preg_match_all(
                '/(\d{1,2}\.\d{2})/',
                $item['text'],
                $matches
            );

            foreach ($matches[1] as $waktu) {
                $semuaWaktu[] = $this->normalisasiJam(
                    $waktu
                );
            }
        }

        if (
            $jamMulai === null
            && count($semuaWaktu) >= 1
        ) {
            $jamMulai = $semuaWaktu[0];
        }

        if (
            $jamSelesai === null
            && count($semuaWaktu) >= 2
        ) {
            $jamSelesai = $semuaWaktu[1];
        }

        /*
         * Cari kode guru.
         */
        $kode = [];

        foreach ($items as $item) {
            /*
             * Hanya area kolom kelas.
             */
            if ($item['x'] < $xMin + 70) {
                continue;
            }

            $text = strtoupper(
                trim($item['text'])
            );

            /*
             * Hilangkan waktu dari teks.
             */
            $text = preg_replace(
                '/\d{1,2}\.\d{2}/',
                '',
                $text
            );

            /*
             * Ambil kode guru.
             *
             * AA dan AB harus diperiksa lebih dahulu.
             * Angka 1/2 setelah kode dianggap penanda,
             * sehingga:
             *
             * M1 -> M
             * A2 -> A
             * X1 -> X
             * Y1 -> Y
             *
             * Ini sesuai pola yang tampak pada jadwal.
             */
            $pattern =
                '/(?:AA|AB|[A-Z])(?:[12])?/';

            preg_match_all(
                $pattern,
                $text,
                $matches
            );

            foreach ($matches[0] as $token) {
                $base = preg_replace(
                    '/[12]$/',
                    '',
                    $token
                );

                if (
                    in_array(
                        $base,
                        $this->kodeGuru,
                        true
                    )
                ) {
                    $kode[] = [
                        'raw' => $token,
                        'kode' => $base,
                        'x' => $item['x'],
                    ];
                }
            }
        }

        if (
            $jamKe === null
            || $jamMulai === null
            || $jamSelesai === null
        ) {
            return null;
        }

        return [
            'jam_ke' => $jamKe,
            'jam_mulai' => $jamMulai,
            'jam_selesai' => $jamSelesai,
            'kode' => $kode,
        ];
    }

    /**
     * Membuat record jadwal berdasarkan posisi kolom.
     */
    protected function buatJadwalBaris(
        string $hari,
        array $baris
    ): array {
        $hasil = [];

        foreach ($baris['kode'] as $item) {
            $kelas = $this->kelasDariX(
                $item['x']
            );

            if ($kelas === null) {
                continue;
            }

            $hasil[] = [
                'hari' => $hari,
                'jam_ke' => $baris['jam_ke'],
                'jam_mulai' => $baris['jam_mulai'],
                'jam_selesai' => $baris['jam_selesai'],
                'kelas' => $kelas,
                'kode_guru_raw' => $item['raw'],
                'kode_guru' => $item['kode'],
            ];
        }

        return $hasil;
    }

    /**
     * Menentukan kelas berdasarkan posisi X.
     */
    protected function kelasDariX(float $x): ?string
    {
        /*
         * Kolom kiri:
         *
         * VII A-F  : sekitar 80-140
         * VIII A-F : sekitar 152-213
         * IX A-F   : sekitar 226-286
         */
        $kolomKiri = [
            80 => '7A',
            92 => '7B',
            104 => '7C',
            116 => '7D',
            128 => '7E',
            140 => '7F',

            152 => '8A',
            165 => '8B',
            177 => '8C',
            188 => '8D',
            201 => '8E',
            213 => '8F',

            226 => '9A',
            238 => '9B',
            249 => '9C',
            261 => '9D',
            273 => '9E',
            286 => '9F',
        ];

        /*
         * Kolom kanan.
         */
        $kolomKanan = [
            360 => '7A',
            372 => '7B',
            384 => '7C',
            396 => '7D',
            408 => '7E',
            420 => '7F',

            432 => '8A',
            445 => '8B',
            457 => '8C',
            469 => '8D',
            481 => '8E',
            493 => '8F',

            504 => '9A',
            516 => '9B',
            528 => '9C',
            540 => '9D',
            552 => '9E',
            565 => '9F',
        ];

        $semuaKolom = $kolomKiri + $kolomKanan;

        $terdekat = null;
        $jarakTerdekat = PHP_FLOAT_MAX;

        foreach ($semuaKolom as $posisi => $kelas) {
            $jarak = abs($x - $posisi);

            if ($jarak < $jarakTerdekat) {
                $jarakTerdekat = $jarak;
                $terdekat = $kelas;
            }
        }

        /*
         * Toleransi posisi PDF.
         */
        if ($jarakTerdekat <= 5) {
            return $terdekat;
        }

        return null;
    }

    /**
     * 07.30 -> 07:30:00
     */
    protected function normalisasiJam(string $jam): string
    {
        $jam = str_replace('.', ':', trim($jam));

        if (strlen($jam) === 4) {
            $jam = '0' . $jam;
        }

        return $jam . ':00';
    }
}