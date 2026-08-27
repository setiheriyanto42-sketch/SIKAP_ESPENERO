<?php

namespace App\Services\Parser;

class MetadataParser
{
    public function parse(string $text): array
    {
        return [

            'mata_pelajaran' => $this->ambil($text, [
                'Mata Pelajaran',
                'Mapel',
                'Bidang Studi',
            ]),

            'kelas' => $this->ambil($text, [
                'Kelas',
            ]),

            'fase' => $this->ambil($text, [
                'Fase',
            ]),

            'semester' => $this->ambil($text, [
                'Semester',
            ]),

            'tahun_ajaran' => $this->ambil($text, [
                'Tahun Pelajaran',
                'Tahun Ajaran',
            ]),

            'alokasi_waktu' => $this->parseAlokasiWaktu(
                $this->ambil($text, [
                    'Alokasi Waktu',
                ])
            ),

        ];
    }

    private function ambil(string $text, array $label)
    {
        foreach ($label as $nama) {

            if (
                preg_match(
                    "/".$nama."\s*[:\-]?\s*(.+)/iu",
                    $text,
                    $m
                )
            ) {

                return trim($m[1]);

            }

        }

        return null;
    }

    private function parseAlokasiWaktu(?string $text): ?array
    {
        if (!$text) {
            return null;
        }

        $hasil = [
            'teks' => $text,
            'jp' => null,
            'menit_per_jp' => 40,
            'total_menit' => null,
        ];

        if (preg_match('/(\d+)\s*JP/i', $text, $m)) {
            $hasil['jp'] = (int) $m[1];
        }

        if (preg_match('/(\d+)\s*menit/i', $text, $m)) {
            $hasil['menit_per_jp'] = (int) $m[1];
        }

        if ($hasil['jp']) {
            $hasil['total_menit'] =
                $hasil['jp'] * $hasil['menit_per_jp'];
        }

        return $hasil;
    }
}