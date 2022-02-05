<?php


namespace Jurager\Commerce\Collections;


use Jurager\Commerce\Model\Simple;

/**
 * Class ValueProperties
 *
 * @package Jurager\Commerce\Model
 */
class RequisiteCollection extends Simple
{
    public function init(): void
    {
        if (isset($this->xml->ЗначениеРеквизита)) {
            foreach ($this->xml->ЗначениеРеквизита as $requisite) {
                $this->append(new Simple($this->owner, $requisite));
            }
        }
        parent::init();
    }

}