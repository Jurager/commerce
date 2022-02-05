<?php

namespace Jurager\Commerce\Model;

class PriceType extends Simple
{
    public function propertyAliases()
    {
        return [
            'Ид' => 'id',
            'Наименование' => 'name',
            'Валюта' => 'currency',
        ];
    }
}