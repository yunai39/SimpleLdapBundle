<?php

namespace Yunai39\Bundle\SimpleLdapBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class RoleLdapType
 * @package Yunai39\Bundle\SimpleLdapBundle\Form
 */
class RoleLdapType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roleName');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yunai39\Bundle\SimpleLdapBundle\Entity\RoleLdap'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'yunai39_bundle_simpleldapbundle_roleldap';
    }
}
