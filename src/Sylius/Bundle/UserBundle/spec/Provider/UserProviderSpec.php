<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Bundle\UserBundle\Provider;

use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\User\Model\User;

class UserProviderSpec extends ObjectBehavior
{
    function let(RepositoryInterface $userRepository)
    {
        $this->beConstructedWith($userRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\UserBundle\Provider\UserProvider');
    }
    
    function it_implements_symfony_user_provider_interface()
    {
        $this->shouldImplement('Symfony\Component\Security\Core\User\UserProviderInterface');
    }

    function it_supports_sylius_user_model()
    {
        $this->supportsClass('Sylius\Component\User\Model\UserInterface')->shouldReturn(true);
    }

    function it_loads_user_by_user_name($userRepository, User $user)
    {
        $userRepository->findOneBy(array('username' => 'testUser'))->willReturn($user);

        $this->loadUserByUsername('testUser')->shouldReturn($user);
    }

    function it_updates_user_by_user_name($userRepository, User $user)
    {
        $userRepository->findOneBy(array('username' => 'testUser'))->willReturn($user);

        $user->getUsername()->willReturn('testUser');

        $this->refreshUser($user)->shouldReturn($user);
    }
}
