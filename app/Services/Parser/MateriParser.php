<?php

namespace App\Services\Parser;

class MateriParser
{
    public function parse(string $text): array
    {
        if (
            preg_match(
                '/Materi(.*?)(Aktivitas|Kegiatan|Asesmen|$)/isu',
                $text,
                $match
            )
        ) {

            return [

                trim($match[1])

            ];

        }

        return [];
    }
}