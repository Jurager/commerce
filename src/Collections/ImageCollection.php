<?php


namespace Jurager\Commerce\Collections;


use Jurager\Commerce\Model\Image;
use Jurager\Commerce\Model\Simple;

/**
 * Class Image
 *
 * @package Jurager\Commerce\Model
 */
class ImageCollection extends Simple
{
    public function init(): void
    {
        if ($this->xml) {
            foreach ($this->xml as $image) {
                $this->append(new Image($this->owner, $image));
            }
        }
        parent::init();
    }
}