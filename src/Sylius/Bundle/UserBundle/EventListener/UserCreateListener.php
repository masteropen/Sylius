<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\UserBundle\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Sylius\Component\Resource\Exception\UnexpectedTypeException;
use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;
use Sylius\Component\User\Model\UserInterface;
use Sylius\Component\User\Security\PasswordUpdaterInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * User register listener.
 *
 * @author Łukasz Chruściel <lukasz.chrusciel@lakion.com>
 */
class UserCreateListener
{
    /**
     * @var PasswordUpdaterInterface
     */
    protected $passwordUpdater;

    /**
     * @var CanonicalizerInterface
     */
    protected $canonicalizer;

    public function __construct(PasswordUpdaterInterface $passwordUpdater, CanonicalizerInterface $canonicalizer)
    {
        $this->passwordUpdater = $passwordUpdater;
        $this->canonicalizer = $canonicalizer;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $item = $args->getEntity();

        if (!$this->supports($item)) {
            return;
        }

        if (null !== $item->getPlainPassword()) {
            $this->passwordUpdater->updatePassword($item);
        }

        $item->setUsernameCanonical($this->canonicalizer->canonicalize($item->getUsername()));
        $item->setEmailCanonical($this->canonicalizer->canonicalize($item->getEmail()));
    }

    private function supports($item)
    {
        return $item instanceof UserInterface;
    }
}
