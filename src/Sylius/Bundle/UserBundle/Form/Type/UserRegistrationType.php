<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\UserBundle\Form\Type;

use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sylius\Bundle\UserBundle\Form\EventListener\RegistrationFormListener;

class UserRegistrationType extends AbstractResourceType
{
    /**
     * DataFetcher registry.
     *
     * @var CanonicalizerInterface
     */
    protected $canonicalizer;

    /**
    * Constructor.
    *
    * @param CanonicalizerInterface $canonicalizer
    */
    public function __construct($dataClass, array $validationGroups, CanonicalizerInterface $canonicalizer)
    {
        parent::__construct($dataClass, $validationGroups);
        $this->canonicalizer = $canonicalizer;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventSubscriber(new RegistrationFormListener($this->canonicalizer))
            ->add('firstName', 'text', array(
                'label' => 'sylius.form.user.first_name',
            ))
            ->add('lastName', 'text', array(
                'label' => 'sylius.form.user.last_name',
            ))
            ->add('email', 'text', array(
                'label' => 'sylius.form.user.last_name',
            ))
            ->add('plainPassword', 'repeated', array(
                'type'            => 'password',
                'first_options'   => array('label' => 'sylius.form.user.password.label'),
                'second_options'  => array('label' => 'sylius.form.user.password.confirmation'),
                'invalid_message' => 'sylius.user.plainPassword.mismatch',
            ))
        ;
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_user_registration';
    }
}
