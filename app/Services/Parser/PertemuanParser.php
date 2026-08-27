<?php

namespace App\Services\Parser;

class PertemuanParser
{
    /**
     * Parse isi BAB menjadi daftar pertemuan.
     */
    public function parse(string $isiBab): array
    {
        $isiBab = $this->normalisasi($isiBab);

        if ($isiBab === '') {
            return [];
        }

        /*
        |--------------------------------------------------------------------------
        | 1. DETEKSI PERTEMUAN EKSPLISIT
        |--------------------------------------------------------------------------
        |
        | Mendukung:
        | Pertemuan 1
        | Pertemuan Ke-1
        | Pertemuan ke 1
        | Pertemuan 1:
        |
        */

        preg_match_all(
            '/(?:^|\n)\s*Pertemuan\s*(?:Ke[-\s]*)?(\d+)\s*:?\s*\n?(.*?)(?=\n\s*Pertemuan\s*(?:Ke[-\s]*)?\d+\s*:?\s*\n?|\z)/isu',
            $isiBab,
            $matches,
            PREG_SET_ORDER
        );

        /*
        |--------------------------------------------------------------------------
        | JIKA PERTEMUAN DITEMUKAN
        |--------------------------------------------------------------------------
        */

        if (!empty($matches)) {

            $hasil = [];

            foreach ($matches as $match) {

                $nomor = (int) $match[1];

                $isi = trim($match[2]);

                if ($isi === '') {
                    $isi = $isiBab;
                }

                $hasil[] = [
                    'nomor' => $nomor,

                    'tujuan' => $this->ambilBagian(
                        $isi,
                        [
                            'Tujuan Pembelajaran',
                            'Tujuan Kegiatan Pembelajaran',
                            'Tujuan',
                        ]
                    ),

                    'materi' => $this->ambilBagian(
                        $isi,
                        [
                            'Materi Pembelajaran / Topik',
                            'Materi Pembelajaran',
                            'Materi',
                            'Topik',
                        ]
                    ),

                    'aktivitas' => $this->ambilBagian(
                        $isi,
                        [
                            'Kegiatan Pembelajaran',
                            'Aktivitas Pembelajaran',
                            'Langkah Pembelajaran',
                            'Aktivitas',
                            'Kegiatan',
                        ]
                    ),

                    'asesmen' => $this->ambilBagian(
                        $isi,
                        [
                            'Asesmen Pembelajaran',
                            'Penilaian Pembelajaran',
                            'Asesmen',
                            'Penilaian',
                        ]
                    ),

                    'isi' => $isi,
                ];
            }

            return $hasil;
        }

        /*
        |--------------------------------------------------------------------------
        | 2. FALLBACK
        |--------------------------------------------------------------------------
        |
        | Jika tidak ada "Pertemuan 1", seluruh isi BAB dianggap
        | sebagai satu pertemuan.
        |
        */

        return [
            [
                'nomor' => 1,

                'tujuan' => $this->ambilBagian(
                    $isiBab,
                    [
                        'Tujuan Pembelajaran',
                        'Tujuan Kegiatan Pembelajaran',
                        'Tujuan',
                    ]
                ),

                'materi' => $this->ambilBagian(
                    $isiBab,
                    [
                        'Materi Pembelajaran / Topik',
                        'Materi Pembelajaran',
                        'Materi',
                        'Topik',
                    ]
                ),

                'aktivitas' => $this->ambilBagian(
                    $isiBab,
                    [
                        'Kegiatan Pembelajaran',
                        'Aktivitas Pembelajaran',
                        'Langkah Pembelajaran',
                        'Aktivitas',
                        'Kegiatan',
                    ]
                ),

                'asesmen' => $this->ambilBagian(
                    $isiBab,
                    [
                        'Asesmen Pembelajaran',
                        'Penilaian Pembelajaran',
                        'Asesmen',
                        'Penilaian',
                    ]
                ),

                'isi' => $isiBab,
            ]
        ];
    }


    /**
     * Normalisasi teks.
     */
    private function normalisasi(string $text): string
    {
        /*
        | Normalisasi line ending.
        */
        $text = preg_replace(
            "/\r\n|\r/",
            "\n",
            $text
        );

        /*
        | Hilangkan spasi/tab berlebihan.
        */
        $text = preg_replace(
            "/[ \t]+/",
            " ",
            $text
        );

        /*
        | Rapikan baris kosong.
        */
        $text = preg_replace(
            "/\n{3,}/",
            "\n\n",
            $text
        );

        return trim($text);
    }


    /**
     * Mengambil isi berdasarkan heading.
     */
    private function ambilBagian(
        string $text,
        array $labels
    ): ?string {

        foreach ($labels as $label) {

            /*
            |--------------------------------------------------------------------------
            | POLA 1
            |--------------------------------------------------------------------------
            | Heading dengan titik dua:
            |
            | Tujuan Pembelajaran:
            | ...
            |
            */

            $pattern = '/'
                . '(?:^|\n)'
                . '\s*'
                . preg_quote($label, '/')
                . '\s*[:\-]?\s*'
                . '(.*?)'
                . '(?='
                . '\n\s*'
                . '(?:'
                . '[A-Z]\.'
                . '|'
                . '[A-Z][A-Za-zÀ-ÿ\s\/&]{2,80}'
                . '\s*[:\-]'
                . ')'
                . '|'
                . '\z'
                . ')'
                . '/isu';

            if (preg_match($pattern, $text, $match)) {

                $hasil = trim($match[1]);

                if ($hasil !== '') {
                    return $hasil;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | POLA 2
            |--------------------------------------------------------------------------
            | Heading tanpa titik dua tetapi diikuti isi.
            |
            | Tujuan Pembelajaran
            | Peserta didik ...
            |
            */

            $pattern = '/'
                . '(?:^|\n)'
                . '\s*'
                . preg_quote($label, '/')
                . '\s*'
                . '\n'
                . '(.*?)'
                . '(?='
                . '\n\s*'
                . '(?:'
                . '[A-Z]\.'
                . '|'
                . '[A-Z][A-Za-zÀ-ÿ\s\/&]{2,80}'
                . '\s*[:\-]'
                . ')'
                . '|'
                . '\z'
                . ')'
                . '/isu';

            if (preg_match($pattern, $text, $match)) {

                $hasil = trim($match[1]);

                if ($hasil !== '') {
                    return $hasil;
                }
            }
        }

        return null;
    }
}