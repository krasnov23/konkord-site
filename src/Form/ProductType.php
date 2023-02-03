<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('mainPagePhoto',FileType::class,
                ['label'=>'Фото на главной странице ( JPG or PNG )',
                    'mapped' => false,
                    'required' => false,
                    'constraints' =>
                    [new File(['maxSize' => '1024k','mimeTypes' => ['image/jpeg','image/png'],
                        'mimeTypesMessage' => 'Please upload a valid PNG/JPEG image']) ]] )
            ->add('subtitle1')
            ->add('subtitle2')
            ->add('subtitle3')
            ->add('photo1',FileType::class,
                ['label'=>'Фото первого товара ( JPG or PNG )',
                    'mapped' => false,
                    'required' => false,
                    'constraints' =>
                        [new File(['maxSize' => '1024k','mimeTypes' => ['image/jpeg','image/png'],
                            'mimeTypesMessage' => 'Please upload a valid PNG/JPEG image']) ]])
            ->add('photo2',FileType::class,
                ['label'=>'Фото второго товара ( JPG or PNG )',
                    'mapped' => false,
                    'required' => false,
                    'constraints' =>
                        [new File(['maxSize' => '1024k','mimeTypes' => ['image/jpeg','image/png'],
                            'mimeTypesMessage' => 'Please upload a valid PNG/JPEG image']) ]])
            ->add('photo3',FileType::class,
                ['label'=>'Фото третьего товара ( JPG or PNG )',
                    'mapped' => false,
                    'required' => false,
                    'constraints' =>
                        [new File(['maxSize' => '1024k','mimeTypes' => ['image/jpeg','image/png'],
                            'mimeTypesMessage' => 'Please upload a valid PNG/JPEG image']) ]])
            ->add('description1',TextType::class,['required'=>false])
            ->add('description2',TextType::class,['required'=>false])
            ->add('description3',TextType::class,['required'=>false])
            ->add('submit',SubmitType::class);
    }




    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
