<?php
/**
 * Created by PhpStorm.
 * User: grzes
 * Date: 07.10.2018
 * Time: 22:25
 */

namespace AppBundle\Form;


use AppBundle\Entity\Upload;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UploadType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("name", TextType::class, ['label' => 'Imie'])
            ->add("surname", TextType::class, ['label' => 'Nazwisko'])
            ->add("file", FileType::class, ['label' => 'Dodaj plik'])
            ->add("submit", SubmitType::class, ['label' => 'Wyślij']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(["data_class" => Upload::class]);
    }

}