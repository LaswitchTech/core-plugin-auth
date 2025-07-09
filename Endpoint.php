<?php

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
            case "/auth/users":
                $this->Level = 1;
                break;
            case "/auth/setActive":
            case "/auth/setInactive":
                $this->Level = 3;
                break;
        }
    }

    /**
     * Set the User as Active
     */
    public function setActiveAction(): array
    {
        return ["status" => 200, "message" => "OK", "data" => ["status" => $this->Model->Users->update($this->Auth->user()->id, ["isInactive" => 0])]];
    }

    /**
     * Set the User as Inactive
     */
    public function setInactiveAction(): array
    {
        return ["status" => 200, "message" => "OK", "data" => ["status" => $this->Model->Users->update($this->Auth->user()->id, ["isInactive" => 1])]];
    }

    /**
     * Get the organization's users
     */
    public function usersAction(): array
    {
        // Set the default message
        $message = ["status" => 200, "message" => "OK", "data" => ["records" => $this->Model->Users->fetchAll([["key" => "organization", "operator" => "=", "value" => $this->Auth->user()->organization()->id]])]];

        // Return the message
        return $message;
    }
}
