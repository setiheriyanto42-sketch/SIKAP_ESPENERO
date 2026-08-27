<?php

namespace App\Services;

use App\Services\Parser\DocumentParser;

class AIParserService
{
    public function parse(string $text): array
    {
        return (new DocumentParser())->parse($text);
    }
}