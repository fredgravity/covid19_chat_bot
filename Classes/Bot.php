<?php

namespace classes;

class Bot {
    private $botName = 'Kojo';
    private $botGender = 'Male';
    private $userName;
    private $userGender;

    public function setUserName ($name) {
        if (is_string(strtolower($name))) {
             $this->userName = $name;
        }else{
            throw new \Exception('your name should be valid characters');
        }

       
    }

    public function setUserGender ($gender) {
        if (strtolower($gender) != 'male' || strtolower($gender) != 'female') {
           throw new \Exception('your gender should be either a male or a female');
        }

        $this->userName = strtolower($gender);
    }

    public function getBotName(){
        return $this->botName;
    }

    public function getBotGender(){
        return $this->botGender;
    }

    public function getUserName(){
        return $this->userName;
    }

    public function getUserGender(){
        return $this->userGender;
    }

    public function hears($message, callable $call){
        $call(new Bot);
        return $message;
    }

    public function reply($response){
        echo $response;
    }

    public function ask($question, array $questionArray){
        $question = trim($question);
        foreach($questionArray as $covidQuestion => $value){
            if($covidQuestion == $question){
                return $value;
            }
        }
    }
    
}


?>
