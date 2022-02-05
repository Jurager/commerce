<?php

namespace Jurager\Commerce\Model;

class Warehouse extends Simple
{
    public function propertyAliases()
    {
        return [
            'Ид' => 'id',
            'Количество' => 'quantity',
            'Наименование' => 'name',
        ];
    }

}
