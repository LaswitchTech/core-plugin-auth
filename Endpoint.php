<?php

/**
 * Core Framework - AuthEndpoint
 *
 * @license    MIT (https://mit-license.org/)
 * @author     Louis Ouellet <louis@laswitchtech.com>
 */

// Import additionnal class into the global namespace
use \LaswitchTech\Core\Objects;
use \LaswitchTech\Core\Abstracts\Endpoint;

class AuthEndpoint extends Endpoint {

    /**
     * Constructor
     */
    public function __construct()
    {

        // Call Parent Constructor
        parent::__construct();

        // Retrieve the namespace
        $namespace = $this->Request->getNamespace();

        // Set Global access
        $this->Public = false;
        $this->Level = 1;

        // Set Properties
        switch($namespace){
            case "/auth/login":
            case "/auth/members":
            case "/auth/associates":
            case "/auth/vcard":
                $this->Level = 1;
                break;
        }
    }

    /**
     * Retrieve Login Information
     */
    public function loginAction(): array
    {
        // Set the default message
        $message = ["status" => 200, "message" => "OK", "data" => [
            "isAuthenticated" => $this->Auth->isAuthenticated(),
            "isLoaded" => $this->Auth->isAuthenticated(),
            "method" => $this->Auth->method(),
        ]];

        // Return the message
        return $message;
    }

    /**
     * Retrieve Object Members
     */
    public function membersAction(): array
    {
        // Retrieve the request parameters
        $name = $this->Request->getParams('REQUEST','name');
        $type = strtoupper($this->Request->getParams('REQUEST','type'));

        // Set the default message
        $message = ["status" => 200, "message" => "OK", "data" => []];

        // Check if both parameters are set
        if($type){

            // Check if the type is valid
            if(in_array($type,['ROLE','ROLES','GROUP','GROUPS'])){

                // Check if a name is set
                if($name){

                    // Create the object
                    switch($type){
                        case 'ROLE':
                        case 'ROLES':
                            $object = new Objects\Role($name);
                            break;
                        case 'GROUP':
                        case 'GROUPS':
                            $object = new Objects\Group($name);
                            break;
                    }

                    // Retrieve the members
                    $members = $object->members('users');

                    // Set the message
                    $message["data"] = $members;
                } else {
                    $message = ["status" => 400, "message" => "Bad Request", "data" => []];
                }
            } else {
                $message = ["status" => 400, "message" => "Bad Request", "data" => []];
            }
        } else {
            $message = ["status" => 400, "message" => "Bad Request", "data" => []];
        }

        // Return the message
        return $message;
    }

    /**
     * Retrieve User's Associates
     */
    public function associatesAction(): array
    {
        // Set the default message
        $message = ["status" => 200, "message" => "OK", "data" => []];

        // Retrieve the user's associates
        $associates = $this->Auth->user()->associates();

        // Set the message
        $message["data"] = $associates;

        // Return the message
        return $message;
    }

    /**
     * Retrieve User's Colleagues
     */
    public function colleaguesAction(): array
    {
        // Set the default message
        $message = ["status" => 200, "message" => "OK", "data" => []];

        // Retrieve the user's colleagues
        $colleagues = $this->Auth->user()->colleagues();

        // Set the message
        $message["data"] = $colleagues;

        // Return the message
        return $message;
    }

    /**
     * Retrieve User's vCard
     */
    public function vcardAction(): array
    {
        // Set the default message
        $message = ["status" => 200, "message" => "OK", "data" => $this->Auth->user()->vcard()];

        // Return the message
        return $message;
    }
}
