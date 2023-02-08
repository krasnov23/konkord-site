<?php

namespace App\Form;

use App\Entity\Feedback;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FeedbackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('clientName')
            ->add('communicationData')
            ->add('description',TextareaType::class,['attr' => [
        'class' => 'form-control','id' => 'exampleFormControlTextarea1','row'=>3
    ]])
            ->add('photo',FileType::class,
                ['label'=>'Приложите фото, если есть необходимость',
                    'mapped' => false,
                    'required' => false,
                    'constraints' =>
                        [new File(['maxSize' => '1024k','mimeTypes' => ['image/jpeg','image/png'],
                            'mimeTypesMessage' => 'Please upload a valid PNG/JPEG image']) ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Feedback::class,
        ]);
    }
}
