<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MitarbeiterInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, []);

        $builder->add('text', HiddenType::class,
            [
                'empty_data' => '[]'
            ],
        );

        $builder->add('files', FileType::class, [
            'multiple' => true,
            'label' => 'Upload Files',
            'required' => false,
            'mapped' => false, // Not mapped to an entity property
            'attr' => [
                'accept' => '.jpg, .jpeg, .png, .gif, .pdf, .txt, .docx',
                'onclick' => 'addFileInput(this)',
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}
