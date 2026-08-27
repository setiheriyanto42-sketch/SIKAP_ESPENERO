<?php

namespace App\Services\Parser;


class SectionParser
{
    public function parse(string $text): array
    {
        $hasil = [];

        $baris = preg_split("/\r\n|\n|\r/", $text);

        $judul = null;

        $isi = [];

        foreach ($baris as $line) {

            $line = trim($line);

            if ($line == '') {
                continue;
            }

            /*
             |--------------------------------------------------
             | Heading
             |--------------------------------------------------
             */

            if ($this->isHeading($line)) {

                if ($judul) {

                    $hasil[] = [

                        'nama' => $judul,

                        'isi' => trim(
                            implode("\n", $isi)
                        )

                    ];

                }

                $judul = $line;

                $isi = [];

            } else {

                $isi[] = $line;

            }

        }

        if ($judul) {

            $hasil[] = [

                'nama' => $judul,

                'isi' => trim(
                    implode("\n", $isi)
                )

            ];

        }

        return $hasil;
    }

    private function isHeading($text)
    {
        return strlen($text) < 80
            && strtoupper($text) == $text;
    }
}