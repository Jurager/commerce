<?php

namespace Jurager\Commerce\Model;

use Jurager\Commerce\Collections\ImageCollection;
use Jurager\Commerce\Collections\PropertyCollection;
use Jurager\Commerce\Collections\RequisiteCollection;
use Jurager\Commerce\Collections\SpecificationCollection;

class Product extends Simple
{
    /**
     * @var PropertyCollection|null Свойства продукта
     */
    protected ?PropertyCollection $properties = null;
    /**
     * @var RequisiteCollection|null
     */
    protected ?RequisiteCollection $requisites = null;
    /**
     * @var SpecificationCollection|null
     */
    protected ?SpecificationCollection $specifications = null;

    /**
     * @var mixed
     */
    protected mixed $prices = null;
    /**
     * @var mixed
     */
    protected mixed $group = null;

    protected ?ImageCollection $images = null;

    /**
     * @return PropertyCollection<Property>
     */
    public function getProperties(): PropertyCollection
    {
        if (! $this->properties) {
            $this->properties = new PropertyCollection($this->owner, $this->xml->ЗначенияСвойств);
        }
        return $this->properties;
    }

    /**
     * @return SpecificationCollection|array|null
     *
     */
    public function getSpecifications(): SpecificationCollection|array|null
    {
        return $this->getOffer()?->getSpecifications();
    }

    /**
     * @return array|Price
     *
     */
    public function getPrices(): array|Price
    {
        return $this->getOffer()?->getPrices() ?: [];
    }

    /**
     * @return RequisiteCollection
     */
    public function getRequisites(): RequisiteCollection
    {
        if (! $this->requisites) {
            $this->requisites = new RequisiteCollection($this->owner, $this->xml->ЗначенияРеквизитов);
        }
        return $this->requisites;
    }

    /**
     * @return Group|string|null
     */
    public function getGroup(): Group|string|null
    {
        if (! $this->group) {

            if (!$this->Группы || count($this->Группы) === 0) {
                return null;
            }

            $this->group = (string) $this->Группы->Ид;
        }
        return $this->group;
    }

    /**
     * @return Offer|null
     *
     */
    public function getOffer(): ?Offer
    {
        return $this->owner->offerPackage->getOfferById($this->getClearId());
    }

    /**
     * @return array<Offer>
     */
    public function getOffers(): array
    {
        return $this->owner->offerPackage->getOffersById($this->getClearId());
    }

    /**
     * @return ImageCollection
     */
    public function getImages(): ImageCollection
    {
        if (! $this->images) {
            $this->images = new ImageCollection($this->owner, $this->xml->Картинка);
        }
        return $this->images;
    }
}
