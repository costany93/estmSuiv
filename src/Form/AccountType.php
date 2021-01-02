<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fistname',TextType::class,$this->getConfiguration('Nom','Entrer votre nom'))
            ->add('lastname',TextType::class,$this->getConfiguration('Prénom','Entrer votre prénom'))
            ->add('sexe',ChoiceType::class, [
                'choices' => [
                    'Masculin' => 'masculin',
                    'Feminin' => 'feminin'
                ]
            ])
            ->add('dateNaiss',DateTimeType::class,[
                'widget' => 'single_text'
            ])
            ->add('email',EmailType::class,$this->getConfiguration('Email','Entrer votre email'))
            ->add('phone',NumberType::class,$this->getConfiguration('Numéro de téléphone','Entrer votre numéro de téléphone'))
            ->add('hashPassword',PasswordType::class,$this->getConfiguration('Mot de passe','Entrer votre mot de passe'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
