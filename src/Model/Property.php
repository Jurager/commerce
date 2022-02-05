<?php namespace Jurager\Commerce\Model;

use SimpleXMLElement;

class Property extends Simple
{
    public $productId;
    protected $_value;

    /**
     * @return SimpleXMLElement[]
     */
    public function getAvailableValues()
    {
        return $this->owner->classifier->getReferenceBookById($this->id);
    }

    /**
     * @return Simple|null
     */
    public function getValueModel(): ?Simple
    {
        if ($this->productId && !$this->_value && ($product = $this->owner->catalog->getById($this->productId))) {

            $xpath = "c:ЗначенияСвойств/c:ЗначенияСвойства[c:Ид = '$this->id']";
            $valueXml = $product->xpath($xpath)[0];
            $value = $this->_value = (string)$valueXml->Значение;

            if ($property = $this->owner->classifier->getReferenceBookValueById($value)) {
                $this->_value = new Simple($this->owner, $property);
            } else {
                $this->_value = new Simple($this->owner, $valueXml);
            }
        }

        return $this->_value;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->getValueModel() ? $this->getValueModel()->value : null;
    }
}