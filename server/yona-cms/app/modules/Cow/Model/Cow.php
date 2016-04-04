<?php

/**
 * @author dinhnhatbang <dinhnhatbang@gmail.com>
 */

namespace Cow\Model;

class Cow extends \Phalcon\Mvc\Model
{

    public function getSource()
    {
        return "cow";
    }

    private $id;
    
}
