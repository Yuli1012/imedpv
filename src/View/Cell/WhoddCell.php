<?php
namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Whodd cell
 */
class WhoddCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize()
    {
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function display($fieldId=null)
    {
        $this->loadModel('Ccode');
        $contryList = $this->Ccode->find();
        $this->set(compact('fieldId','contryList'));
    }

    public function WhoddBrowser() {
    }
}