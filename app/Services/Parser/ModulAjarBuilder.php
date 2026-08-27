<?php

namespace App\Services\Parser;

class ModulAjarBuilder
{
    public function build(string $text): array
    {
        return [

            'metadata' =>

                (new MetadataParser())
                    ->parse($text),

            'bab' =>

                (new BabParser())
                    ->parse($text),

        ];
    }
}