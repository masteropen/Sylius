<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Component\User\Security\Generator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @author Łukasz Chruściel <lukasz.chrusciel@lakion.com>
 */
class PinGeneratorSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Component\User\Security\Generator\PinGenerator');
    }

    public function it_implements_generator_interface()
    {
        $this->shouldImplement('Sylius\Component\User\Security\Generator\GeneratorInterface');
    }

    public function it_generates_random_token()
    {
        $this->generate(4)->shouldBeString();
    }
}
