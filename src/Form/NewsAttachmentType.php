<?php

namespace App\Form;

use App\Entity\NewsAttachment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class NewsAttachmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('delete', CheckboxType::class, [
            'mapped' => false,
            'required' => false,
        ]);

        $builder->add('file', FileType::class, [
            'required' => false,
            'allow_file_upload' => true,
            'attr' => [
                'accept' => '.jpg, .jpeg, .png, .gif, .pdf, .txt, .docx, .xls, .xlsx',
            ],
            'constraints' => [
                new File([
                    'maxSize' => '10024k',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                        'image/gif',
                        'application/pdf',
                        'application/x-pdf',
                        'text/plain',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid PDF document',
                ]),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => NewsAttachment::class,
            ]
        );
    }
}
