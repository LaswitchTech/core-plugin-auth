<?php

// Import additionnal class into the global namespace
use \LaswitchTech\Core\Base\BaseModel;

class BackendsModel extends BaseModel {

    /**
     * Constructor
     */
    public function __construct()
    {
        // Call the parent constructor
        parent::__construct();

        // Initialize the Model
        $this->init('backends');
    }
}
