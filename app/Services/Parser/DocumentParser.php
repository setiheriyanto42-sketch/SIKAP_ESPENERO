<?php

namespace App\Services\Parser;

class DocumentParser
{
    public function parse(string $text): array
    {
        return (new ModulAjarBuilder())->build($text);
    }
}