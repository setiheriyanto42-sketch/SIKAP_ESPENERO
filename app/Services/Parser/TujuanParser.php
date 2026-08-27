<?php

namespace App\Services\Parser;

class TujuanParser
{
    public function parse(string $text): array
    {
        $hasil = [];

        $baris = preg_split('/\R/', $text);

        $ambil = false;

        foreach ($baris as $barisText) {

            $barisText = trim($barisText);

            if ($barisText == '') {
                continue;
            }

            if (
                stripos($barisText, 'Tujuan Pembelajaran') !== false
            ) {
                $ambil = true;
                continue;
            }

            if ($ambil) {

                if (
                    preg_match('/^[A-Z]\./', $barisText)
                    ||
                    stripos($barisText, 'Materi') !== false
                    ||
                    stripos($barisText, 'Aktivitas') !== false
                    ||
                    stripos($barisText, 'Asesmen') !== false
                ) {
                    break;
                }

                $hasil[] = $barisText;
            }
        }

        return $hasil;
    }
}