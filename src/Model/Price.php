<?php

namespace Jurager\Commerce\Model;

class Price extends Simple
{
    protected $type = null;

    public function __get($name)
    {
        if (($result = parent::__get($name)) && $this->type && ($value = $this->type->{$name})) {
            return $value;
        }
        return $result;
    }

    public function propertyAliases()
    {
        return [
            'Представление' => 'performance',
            'ИдТипаЦены' => 'id',
            'ЦенаЗаЕдиницу' => 'cost',
            'Валюта' => 'currency',
            'Единица' => 'unit',
            'Коэффициент' => 'rate',
        ];
    }

    public function getType()
    {
        if (!$this->type && ($id = $this->id) && $type = $this->owner->offerPackage->xpath('//c:ТипЦены[c:Ид = :id]', ['id' => $id])) {
            $this->type = new Simple($this->owner, $type[0]);
        }

        return $this->type;
    }

    public function init(): void
    {
        if ($this->xml && $this->xml->Цена) {

            foreach ($this->xml->Цена as $price) {
                $this->append(new self($this->owner, $price));
            }

            $this->getType();
        }

        parent::init();
    }
}