<?php

namespace App\Form;

use App\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('title', TextType::class, []);

        $builder->add('text', HiddenType::class,
            [
                'empty_data' => '[]',
            ],
        );

        $builder->add('attachments', CollectionType::class, [
            'entry_type' => NewsAttachmentType::class,  // The form type for each attachment
            'entry_options' => ['label' => false],
            'required' => false,
            'label' => 'Upload Files',
            'allow_add' => true,    // Allow adding new attachments
            'allow_delete' => true, // Allow deleting attachments
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => News::class,
            ]
        );
    }
}
