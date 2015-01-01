<?php

namespace FrequenceWeb\Bundle\ContactBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface as FormBuilder;

/**
 * The contact form
 *
 * @author Yohan Giarelli <yohan@giarel.li>
 */
class ContactType extends AbstractType
{
    /**
     * @{inheritDoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('email', 'email')
            ->add('subject', 'text')
            ->add('body', 'textarea')
        ;
    }

    /**
     * @{inheritDoc}
     */
    public function getName()
    {
        return 'contact';
    }
}
