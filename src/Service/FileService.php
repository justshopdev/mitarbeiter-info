<?php

namespace App\Service;

use App\Service\File\FileDTO;
use OndrejVrto\FilenameSanitize\FilenameSanitize;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{
    public function __construct(private readonly string $filePath)
    {
    }

    public function upload(
        UploadedFile $file,
        string $title,
    ): FileDTO {
        $clientOriginalName = $file->getClientOriginalName();
        $lable = $clientOriginalName;
        $filename = $this->generateFilename($clientOriginalName);
        $dirname = $this->generateDirname($title ?? $filename);
        $filetype = $file->guessExtension();
        $filesize = $file->getSize();
        $file->move($dirname, $filename);

        $result = new FileDTO(
            lable: $lable,
            dirname: $dirname,
            filename: $filename,
            filetype: $filetype,
            size: $filesize,
        );

        return $result;
    }

    public function generateFilename(string $filename): string
    {
        return FilenameSanitize::of($filename)->get();
    }

    public function generateDirname(string $title): string
    {
        $title = strtok($title) ?: $title;
        $title = FilenameSanitize::of($title)->get();
        $dir = $this->filePath.DIRECTORY_SEPARATOR.date('Y_m_d').'_'.$title;
        $originalDir = $dir;
        $count = 0;
        while (is_dir($dir)) {
            $dir = $originalDir.'_'.++$count;
        }

        return $dir;
    }
}
