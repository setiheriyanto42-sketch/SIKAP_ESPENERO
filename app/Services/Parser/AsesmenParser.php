<?php

namespace App\Services\Parser;

class AsesmenParser
{
    public function parse(string $text): array
    {
        if (
            preg_match(
                '/Asesmen(.*)$/isu',
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