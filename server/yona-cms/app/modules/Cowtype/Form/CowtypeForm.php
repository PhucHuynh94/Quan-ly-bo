<?php

/**
 * @author dinhnhatbang <dinhnhatbang@gmail.com>
 */

namespace Cowtype\Form;

use Application\Form\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;



class CowtypeForm extends Form
{

    public function initialize()
    {
        $this->add(
            (new Text('name'))
                ->setLabel('Tên giống bò')
        );
        $this->add(
            (new Text('description'))
                ->setLabel('Mô tả ngắn')
        );        
        $this->add(
            (new TextArea('content'))
                ->setLabel('Chi tiết')
        );        
    }
}
