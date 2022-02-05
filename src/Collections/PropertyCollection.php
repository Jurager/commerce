<?php

namespace Jurager\Commerce\Collections;

use Jurager\Commerce\Model\Property;
use Jurager\Commerce\Model\Simple;

/**
 * Class ValueProperties
 *
 * @package Jurager\Commerce\Model
 */
class PropertyCollection extends Simple
{
    /**
     * @param $id
     *
     * @return Property|null
     */
    public function getById($id)
    {
        foreach ($this as $property) {
            if ($property->id === (string) $id) {
                return $property;
            }
        }
        return null;
    }

    public function init(): void
    {
        if (isset($this->xml->ЗначенияСвойства)) {
            foreach ($this->xml->ЗначенияСвойства as $property) {
                $this->append(new Simple($this->owner, $property));
            }
        }
        if (isset($this->xml->Свойство)) {
            $this->loadProperties();
        }
        parent::init();
    }

    protected function loadPropertiesValue()
    {
        foreach ($this->xml->ЗначенияСвойства as $property) {
            $properties = $this->owner->classifier->getProperties();
            $object = clone $properties->getById((string) $property->Ид);
            $object->productId = (string) $this->xpath('..')[0]->Ид;
            $object->init();
            $this->append($object);
        }
    }

    protected function loadProperties()
    {
        foreach ($this->xml->Свойство as $property) {
            $this->append(new Property($this->owner, $property));
        }
    }
}