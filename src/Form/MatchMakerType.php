<?php

namespace App\Form;

use App\Entity\MatchMaker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatchMakerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('player1')
            ->add('player2')
            ->add('winner')
            ->add('scorePlayer1')
            ->add('scorePlayer2')
            ->add('status')
            ->add('encounterDate')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MatchMaker::class,
        ]);
    }
}
