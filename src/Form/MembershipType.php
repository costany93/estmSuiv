<?php

namespace App\Form;

use App\Entity\Membership;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembershipType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content',TextareaType::class,$this->getConfiguration('Motif de ','Dites nous en un plus, sur les raisons pour lesquelles vous souhaitez adhérer ou quitter le club'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Membership::class,
        ]);
    }
}
