<?php


namespace Jurager\Commerce\Collections;


use Jurager\Commerce\Model\Simple;

/**
 * Class SpecificationCollection
 *
 * @package Jurager\Commerce\Model
 */
class SpecificationCollection extends Simple
{
    public function init(): void
    {
        if (isset($this->xml->ХарактеристикаТовара)) {
            foreach ($this->xml->ХарактеристикаТовара as $specification) {
                $this->append(new Simple($this->owner, $specification));
            }
        }
        parent::init();
    }
}