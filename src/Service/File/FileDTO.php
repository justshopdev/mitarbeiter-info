<?php

namespace App\Service\File;

class FileDTO
{
    public function __construct(
        public readonly string $lable,
        public readonly string $dirname,
        public readonly string $filename,
        public readonly string $filetype,
        public readonly int $size,
    ) {
    }
}
