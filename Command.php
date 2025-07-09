<?php

// Import additionnal class into the global namespace
use LaswitchTech\Core\Abstracts\Command;

class AuthCommand extends Command {

    /**
     * Change user password
     */
    public function passwordAction()
    {
        // Import Global Variables
        global $AUTH;

        // Retrieve the username
        $username = $this->Request->getArguments(3);

        // Check if the username is a valid email
        if(!filter_var($username, FILTER_VALIDATE_EMAIL)){

            // Output the error message
            $this->Output->error("Invalid email address. Please provide a valid email address.");
            return;
        }

        // Retrieve the user
        $user = $AUTH->user($username);

        // Retrieve the new password
        $password = $this->Request->getArguments(4);

        // Check if the password is valid
        if(empty($password)){

            // Output the error message
            $this->Output->error("Invalid password. Please provide a valid password.");
            return;
        }

        // Change the password
        if($user->backend()->set('password', $password)->save()){

            // Output the success message
            $this->Output->success("Password changed successfully.");
        } else {

            // Output the error message
            $this->Output->error("Failed to change password.");
        }
    }
}
