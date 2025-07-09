<?php

// Import additionnal class into the global namespace
use \LaswitchTech\Core\Abstracts\Helper;

class AuthHelper extends Helper {

    /**
     * Generate a random string
     *
     * @param int $length
     * @param bool $onlyNumbers
     * @return string
     */
    public function generate(int $length = 8, bool $onlyNumbers = false): string
    {
        $characters = '0123456789';
        if (!$onlyNumbers) {
            $characters .= 'abcdefghijklmnopqrstuvwxyz';
            $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $characters .= '!@#$%^&*()_+{}:<>?';
        }
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
