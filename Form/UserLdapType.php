<?php

namespace Yunai39\Bundle\SimpleLdapBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserLdapType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idLdap')
            ->add('valid')
            ->add('roles');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yunai39\Bundle\SimpleLdapBundle\Entity\UserLdap'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'yunai39_bundle_simpleldapbundle_userldap';
    }
}
