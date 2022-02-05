<?php

namespace Jurager\Commerce\Model;

use Jurager\Commerce\Collections\PropertyCollection;
use Jurager\Commerce\Collections\SpecificationCollection;

class Offer extends Simple
{
    /**
     * @var PropertyCollection|null Свойства продукта
     */
    protected ?PropertyCollection $properties = null;

    /**
     * @var array|Price
     */
    protected Price|array $prices = [];

    /**
     * @var array|Rest
     */
    protected array|Rest $rest = [];

    /**
     * @var array|SpecificationCollection
     */
    protected array|SpecificationCollection $specifications = [];

    /**
     * @return array|SpecificationCollection
     */
    public function getSpecifications(): array|SpecificationCollection
    {
        if (count($this->specifications) === 0) {
            $this->specifications = new SpecificationCollection($this->owner, $this->ХарактеристикиТовара);
        }
        return $this->specifications;
    }

    /**
     * @return array|Price
     */
    public function getPrices(): array|Price
    {
        if ($this->xml && count($this->prices) === 0) {
            $this->prices = new Price($this->owner, $this->xml->Цены);
        }
        return $this->prices;
    }

    /**
     * @return Rest|array
     */
    public function getRest(): Rest|array
    {
        if ($this->xml && count($this->rest) === 0) {
            $this->rest = new Rest($this->owner, $this->xml->Остатки);
        }
        return $this->rest;
    }

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
}
