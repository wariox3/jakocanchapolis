<?php

namespace App\Form\Type;

use App\Entity\Entidad;
use App\Entity\Grupo;
use App\Entity\Jurisdiccion;
use App\Entity\Subgrupo;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NormaType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('entidadRel', EntityType::class, array(
                'class' => Entidad::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                        ->orderBy('e.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => true,
            ))
            ->add('jurisdiccionRel', EntityType::class, array(
                'class' => Jurisdiccion::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('j')
                        ->orderBy('j.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => true,
            ))
            ->add('grupoRel', EntityType::class, array(
                'class' => Grupo::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('g')
                        ->orderBy('g.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => true,
            ))
            ->add('subgrupoRel', EntityType::class, array(
                'class' => Subgrupo::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('sg')
                        ->orderBy('sg.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
            ))
            ->add('nombre', TextType::class, array('required' => true))
            ->add('descripcion',TextareaType::class, array('required' => true))
            ->add('guardar', SubmitType::class,array('label'=>'Guardar'));
    }

}