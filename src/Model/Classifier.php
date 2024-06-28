<?php

namespace Jurager\Commerce\Model;

use SimpleXMLElement;
use Jurager\Commerce\Collections\PropertyCollection;

class Classifier extends Simple
{
    /**
     * @var array<Group>
     */
    protected array $groups = [];
    /**
     * @var array<Warehouse>
     */
    protected array $warehouses = [];
    /**
     * @var array<PriceType>
     */
    protected array $priceTypes = [];
    /**
     * @var ?PropertyCollection
     */
    protected ?PropertyCollection $properties = null;

    /**
     * @return SimpleXMLElement|null
     */
    public function loadXml(): ?SimpleXMLElement
    {
        if ($this->owner->importXml && $this->owner->importXml->Классификатор) {
            return $this->owner->importXml->Классификатор;
        }

        return null;
    }

    /**
     * @param $id
     *
     * @return array<SimpleXMLElement>
     */
    public function getReferenceBookById($id): array
    {
        return $this->xpath('//c:Свойство[c:Ид = :id]/c:ВариантыЗначений/c:Справочник', ['id' => $id]);
    }

    /**
     * @param $id
     *
     * @return SimpleXMLElement|null
     */
    public function getReferenceBookValueById($id): ?SimpleXMLElement
    {
        if ($id) {
            $xpath = '//c:Свойство/c:ВариантыЗначений/c:Справочник[c:ИдЗначения = :id]';
            $type = $this->xpath($xpath, ['id' => $id]);
            return $type ? $type[0] : null;
        }

        return null;
    }

    /**
     * @param $id
     *
     * @return null|Group
     */
    public function getGroupById($id): ?Group
    {
        foreach ($this->getGroups() as $group) {
            if ($group->id === $id) {
                return $group;
            }

            if ($child = $group->getChildById($id)) {
                return $child;
            }
        }
        return null;
    }

    /**
     * @return PropertyCollection
     */
    public function getProperties(): PropertyCollection
    {
        if (count($this->properties) === 0) {
            $this->properties = new PropertyCollection($this->owner, $this->xml->Свойства);
        }
        return $this->properties;
    }

    /**
     * @return array<Group>
     */
    public function getGroups(): array
    {
        if (empty($this->groups) && isset($this->xml->Группы->Группа)) {
            foreach ($this->xml->Группы->Группа as $group) {
                $this->groups[] = new Group($this->owner, $group);
            }
        }
        return $this->groups;
    }

    /**
     * @return array<Warehouse>
     */
    public function getWarehouses(): array
    {
        if (empty($this->warehouses) && isset($this->xml->Склады->Склад)) {
            foreach ($this->xml->Склады->Склад as $warehouse) {
                $this->warehouses[] = new Warehouse($this->owner, $warehouse);
            }
        }
        return $this->warehouses;
    }

    /**
     * @return array<PriceType>
     */
    public function getPriceTypes(): array
    {
        if (empty($this->priceTypes) && isset($this->xml->ТипыЦен->ТипЦены)) {
            foreach ($this->xml->ТипыЦен->ТипЦены as $priceType) {
                $this->priceTypes[] = new PriceType($this->owner, $priceType);
            }
        }
        return $this->priceTypes;
    }
}
