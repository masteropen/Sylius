<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Core\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Channel\Model\Channel as BaseChannel;
use Sylius\Component\Currency\Model\CurrencyInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Payment\Model\PaymentMethodInterface;
use Sylius\Component\Shipping\Model\ShippingMethodInterface as BaseShippingMethodInterface;

/**
 * Core channel model.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Channel extends BaseChannel implements ChannelInterface
{
    /**
     * @var CurrencyInterface[]
     */
    protected $currencies;

    /**
     * @var LocaleInterface[]
     */
    protected $locales;

    /**
     * @var PaymentMethodInterface[]
     */
    protected $paymentMethods;

    /**
     * @var BaseShippingMethodInterface[]
     */
    protected $shippingMethods;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->currencies = new ArrayCollection();
        $this->locales = new ArrayCollection();
        $this->paymentMethods = new ArrayCollection();
        $this->shippingMethods = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrencies()
    {
        return $this->currencies;
    }

    /**
     * {@inheritdoc}
     */
    public function addCurrency(CurrencyInterface $currency)
    {
        if (!$this->hasCurrency($currency)) {
            $this->currencies->add($currency);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeCurrency(CurrencyInterface $currency)
    {
        if ($this->hasCurrency($currency)) {
            $this->currencies->removeElement($currency);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasCurrency(CurrencyInterface $currency)
    {
        return $this->currencies->contains($currency);
    }

    /**
     * {@inheritdoc}
     */
    public function getLocales()
    {
        return $this->locales;
    }

    /**
     * {@inheritdoc}
     */
    public function addLocale(LocaleInterface $locale)
    {
        if (!$this->hasLocale($locale)) {
            $this->locales->add($locale);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeLocale(LocaleInterface $locale)
    {
        if ($this->hasLocale($locale)) {
            $this->locales->removeElement($locale);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasLocale(LocaleInterface $locale)
    {
        return $this->locales->contains($locale);
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingMethods()
    {
        return $this->shippingmethods;
    }

    /**
     * {@inheritdoc}
     */
    public function addShippingMethod(BaseShippingMethodInterface $shippingMethod)
    {
        if (!$this->hasShippingMethod($shippingMethod)) {
            $this->shippingmethods->add($shippingMethod);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeShippingMethod(BaseShippingMethodInterface $shippingMethod)
    {
        if ($this->hasShippingMethod($shippingMethod)) {
            $this->shippingmethods->removeElement($shippingMethod);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasShippingMethod(BaseShippingMethodInterface $shippingMethod)
    {
        return $this->shippingmethods->contains($shippingMethod);
    }

    /**
     * {@inheritdoc}
     */
    public function getPaymentMethods()
    {
        return $this->paymentmethods;
    }

    /**
     * {@inheritdoc}
     */
    public function addPaymentMethod(PaymentMethodInterface $paymentMethod)
    {
        if (!$this->hasPaymentMethod($paymentMethod)) {
            $this->paymentmethods->add($paymentMethod);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removePaymentMethod(PaymentMethodInterface $paymentMethod)
    {
        if ($this->hasPaymentMethod($paymentMethod)) {
            $this->paymentmethods->removeElement($paymentMethod);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasPaymentMethod(PaymentMethodInterface $paymentMethod)
    {
        return $this->paymentmethods->contains($paymentMethod);
    }
}
