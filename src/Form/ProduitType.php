<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomproduit',null,['required'=>false])
            ->add('imageproduit',filetype ::class  ,array('data_class' => null,'required' => false))
            ->add('categorieproduit' , null,['required'=>false])
            ->add('prixproduit',null,['required'=>false])
            ->add('quantiteproduit', null,['required'=>false])
            ->add('descriptionproduit', null,['required'=>false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
