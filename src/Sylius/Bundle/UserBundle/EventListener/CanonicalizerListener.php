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

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Sylius\Component\Resource\Exception\UnexpectedTypeException;
use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;
use Sylius\Component\User\Model\UserInterface;

/**
 * User update listener.
 *
 * @author Łukasz Chruściel <lukasz.chrusciel@lakion.com>
 */
class CanonicalizerListener
{
    /**
     * @var CanonicalizerInterface
     */
    protected $canonicalizer;

    function __construct(CanonicalizerInterface $canonicalizer)
    {
        $this->canonicalizer = $canonicalizer;
    }

    public function canonicalize(LifecycleEventArgs $event)
    {
        $item = $event->getEntity();

        if (!$item instanceof UserInterface) {
            return;
        }

        $item->setUsernameCanonical($this->canonicalizer->canonicalize($item->getUsername()));
        $item->setEmailCanonical($this->canonicalizer->canonicalize($item->getEmail()));
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $this->canonicalize($event);
    }

    public function preUpdate(LifecycleEventArgs $event)
    {
        $this->canonicalize($event);
    }
}
