<?php

namespace Jurager\Commerce\Model;

class Order extends Simple
{
    /**
     * @var Document[]
     */
    public $documents = [];

    public function loadXml()
    {
        if ($this->owner->ordersXml) {
            foreach ($this->owner->ordersXml->Документ as $document) {
                $this->documents[] = new Document($this->owner, $document);
            }
        }
        return $this->owner->ordersXml;
    }
}