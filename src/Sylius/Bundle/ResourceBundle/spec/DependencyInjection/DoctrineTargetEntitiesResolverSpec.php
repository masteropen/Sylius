<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Bundle\ResourceBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

require_once __DIR__.'/../Fixture/Entity/Foo.php';

/**
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
class DoctrineTargetEntitiesResolverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\ResourceBundle\DependencyInjection\DoctrineTargetEntitiesResolver');
    }

    function it_should_get_interfaces_from_the_container(ContainerBuilder $container, Definition $resolverDefinition)
    {
        $resolverDefinition->hasTag('doctrine.event_listener')
            ->shouldBeCalled()
            ->willReturn(false);

        $resolverDefinition->addTag('doctrine.event_listener', array('event' => 'loadClassMetadata'))
            ->shouldBeCalled();

        $container->hasDefinition('doctrine.orm.listeners.resolve_target_entity')
            ->shouldBeCalled()
            ->willReturn(true);

        $container->findDefinition('doctrine.orm.listeners.resolve_target_entity')
            ->shouldBeCalled()
            ->willReturn($resolverDefinition);

        $container->hasParameter('sylius.resource.interface')
            ->shouldBeCalled()
            ->willReturn(true);

        $container->getParameter('sylius.resource.interface')
            ->shouldBeCalled()
            ->willReturn('spec\Sylius\Bundle\ResourceBundle\Fixture\Entity\FooInterface');

        $container->hasParameter('sylius.resource.model')
            ->shouldBeCalled()
            ->willReturn(true);

        $container->getParameter('sylius.resource.model')
            ->shouldBeCalled()
            ->willReturn('spec\Sylius\Bundle\ResourceBundle\Fixture\Entity\Foo');

        $resolverDefinition->addMethodCall(
            'addResolveTargetEntity',
            array(
                'spec\Sylius\Bundle\ResourceBundle\Fixture\Entity\FooInterface', 'spec\Sylius\Bundle\ResourceBundle\Fixture\Entity\Foo', array()
            ))->shouldBeCalled();

        $this->resolve($container, array(
            'sylius.resource.interface' => 'sylius.resource.model'
        ));
    }

    function it_should_get_interfaces(ContainerBuilder $container, Definition $resolverDefinition)
    {
        $resolverDefinition->hasTag('doctrine.event_listener')
            ->shouldBeCalled()
            ->willReturn(false);

        $resolverDefinition->addTag('doctrine.event_listener', array('event' => 'loadClassMetadata'))
            ->shouldBeCalled();

        $container->hasDefinition('doctrine.orm.listeners.resolve_target_entity')
            ->shouldBeCalled()
            ->willReturn(true);

        $container->findDefinition('doctrine.orm.listeners.resolve_target_entity')
            ->shouldBeCalled()
            ->willReturn($resolverDefinition);

        $container->hasParameter(RepositoryInterface::class)
            ->shouldBeCalled()
            ->willReturn(false);

        $container->hasParameter('spec\Sylius\Bundle\ResourceBundle\Fixture\Entity\Foo')
            ->shouldBeCalled()
            ->willReturn(false);

        $resolverDefinition->addMethodCall(
            'addResolveTargetEntity',
            array(
                RepositoryInterface::class, 'spec\Sylius\Bundle\ResourceBundle\Fixture\Entity\Foo', array()
            ))->shouldBeCalled();

        $this->resolve($container, array(
            RepositoryInterface::class => 'spec\Sylius\Bundle\ResourceBundle\Fixture\Entity\Foo'
        ));
    }
}
