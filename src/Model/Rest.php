<?php

namespace Jurager\Commerce\Model;

class Rest extends Simple
{
    public $type = 'quantity';

    public $warehouses = [];

    public function propertyAliases()
    {
        return [
            'Количество' => 'quantity',
        ];
    }

    public function init(): void
    {
        if ($this->xml && $this->xml->Остаток) {
            if ($this->xml->Остаток->Склад) {
                $this->type = 'warehouse';
                foreach ($this->xml->Остаток as $rest) {
                    $this->warehouses[] = new Warehouse($this->owner, $rest->Склад);
                }
            } else {
                $this->xml = $this->xml->Остаток;
            }
        }
        parent::init();
    }
}
