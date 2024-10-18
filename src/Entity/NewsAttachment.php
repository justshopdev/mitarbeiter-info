<?php

namespace App\Entity;

use App\Enum\FileTypeEnum;
use App\Repository\NewsAttachmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsAttachmentRepository::class)]
class NewsAttachment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    public ?string $file = null;

    #[ORM\Column(length: 24, enumType: FileTypeEnum::class)]
    public FileTypeEnum $type;

    #[ORM\Column(length: 64)]
    public ?string $lable = null;

    #[ORM\Column(length: 255)]
    public ?string $filename = null;

    #[ORM\Column(length: 255)]
    public ?string $dirname = null;
    #[ORM\Column(length: 24)]
    public ?string $filetype = null;

    #[ORM\Column()]
    public int $filesize = 0;

    #[ORM\ManyToOne(targetEntity: News::class, inversedBy: 'attachments')]
    public News $news;
}
