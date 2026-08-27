<?php

namespace App\Services\Parser;

class AktivitasParser
{
    public function parse(string $text): array
    {
        if (
            preg_match(
                '/(Aktivitas|Kegiatan)(.*?)(Asesmen|$)/isu',
                $text,
                $match
            )
        ) {

            return [

                trim($match[2])

            ];

        }

        return [];
    }
}