<?php
session_start();
include_once('./Bot.php');
require_once('PHPExcel.php');
require_once('readExcel.php');

use classes\Bot;

$bot = new Bot;

$messagesFromFile = readExcelFile();

// print_r($messagesFromFile['reply']);die();
function getBotResponse($msg, $messagesFromFile){
   
    $res = '';
    foreach ($messagesFromFile['msg'] as $key => $value) {
        if (strpos($key, $msg)) {
            $res = $value;
        }
        
    }
    return $res;
}

function getBotQuestion($qtn, $messagesFromFile){
     $res = '';
    foreach ($messagesFromFile['qtn'] as $key => $value) {
        // echo $key;
        if ($qtn == $key ) {
            $res = $value;
        }
        
    }
    return $res;
}


function getBotCareMessage($cm, $messagesFromFile){
     $res = '';
    foreach ($messagesFromFile['reply'] as $key => $value) {
        // echo $key;
        if ($cm == $key ) {
            $res = $value;
        }
        
    }
    return $res;
}

$questionArray = [
    'what is php' => 'PHP is a server side programming language',
    'hi kojo' => 'Hi there.',
    'what is your name' => "my name is ".$bot->getBotName(),
    'what is your gender' => "i am a " .$bot->getBotGender(),
];

if (isset($_POST['msg'])) {
    $message = trim(strtolower($_POST['msg']));

    $bot->hears($message, function(Bot $botty){
        global $message;
        global $questionArray;
        global $messagesFromFile;

        
// unset($_SESSION['gender']);
// print_r($_SESSION);
// session_destroy();die();
        if ($message == 'reset') {
            session_destroy();
            $botty->reply('Welcome to the covid 19 health screening. The purpose of the Coronavirus Self-Checker is to help you make decisions about seeking appropriate medical care.  This system is not intended for the diagnosis or treatment of disease, including COVID-19.');
            $botty->reply('<br><br>');
            $botty->reply(' Do you consent to use this checker?');
            //    unset($_SESSION['symptoms']);
                exit();
        }

        if(isset($_SESSION['gender']) && $_SESSION['gender'] == 'yes' ){
            if ($_SESSION['symptoms'] == 'yes' && $message == 'yes') {
                // echo'hi';
                $botty->reply(getBotCareMessage('cm5', $messagesFromFile));
                session_destroy();
            //    unset($_SESSION['symptoms']);
                exit();
            }

            if (isset($_SESSION['symptoms']) && $_SESSION['symptoms'] == 'yes' && $message == 'no') {
                $_SESSION['sick'] = 'yes';
                $_SESSION['symptoms'] = 'no';
                $botty->reply(getBotQuestion('qtn3', $messagesFromFile));
                exit();
            }

            if (isset($_SESSION['sick']) && $_SESSION['sick'] == 'yes') {
                if($message == 'yes'){

                    $_SESSION['symp-path'] = 'yes';
                    $_SESSION['asymp-path'] = 'no';
                    $_SESSION['sick'] = 'no';
                    $botty->reply(getBotQuestion('qtn6', $messagesFromFile));
                    exit();
                }elseif($message == 'no'){
                    $_SESSION['asymp-path'] = 'yes';
                    $_SESSION['symp-path'] = 'no';
                    $_SESSION['sick'] = 'no';
                    $botty->reply(getBotQuestion('qtn25', $messagesFromFile));
                    exit();
                }else{
                    $botty->reply('sorry!, i do not understand your response');
                    exit();
                }
            }

            //asymp
             if(isset($_SESSION['asymp-path']) && $_SESSION['asymp-path'] == 'yes'){
                // echo 'hi';
                if ($message =='yes') {
                    $_SESSION['asymp-path'] = 'no';
                    $_SESSION['asymp-path-assess'] = 'yes';
                   $botty->reply(getBotQuestion('qtn26', $messagesFromFile));
                    exit();
                }elseif($message == 'no'){
                    // $botty->reply(getBotCareMessage('cm1', $messagesFromFile));
                    $botty->reply(getBotCareMessage('cm16', $messagesFromFile));
                     exit();
                }else{
                    $botty->reply('sorry!, i do not understand your response');
                    exit();
                }
               
            }

            if (isset($_SESSION['asymp-path-assess']) && $_SESSION['asymp-path-assess'] == 'yes') {
                if ($message == 'yes') {
                    $_SESSION['asymp-path-assess'] = 'no';
                    $botty->reply(getBotCareMessage('cm25', $messagesFromFile));
                    $botty->reply('<br><br>');
                    $botty->reply(getBotCareMessage('cmt3', $messagesFromFile));
                     
                     exit();
                }elseif($message == 'no'){
                     $_SESSION['asymp-path-assess'] = 'no';
                      $_SESSION['asymp-path-volunteer'] = 'yes';
                    $botty->reply(getBotQuestion('qtn27', $messagesFromFile));
                    exit();
                }else{
                    $botty->reply('sorry!, i do not understand your response');
                    exit();
                }
            }

            if (isset($_SESSION['asymp-path-volunteer']) && $_SESSION['asymp-path-volunteer'] == 'yes') {
               if ($message == 'yes') {
                  $_SESSION['asymp-path-volunteer'] = 'no';
                  $_SESSION['asymp-path-protect'] = 'yes';
                   $botty->reply(getBotQuestion('qtn28', $messagesFromFile));
                    exit();
               }elseif($message == 'no'){
                   $_SESSION['asymp-path-volunteer'] = 'no';
                   $botty->reply(getBotCareMessage('cm18', $messagesFromFile));
                    $botty->reply('<br><br>');
                    $botty->reply(getBotCareMessage('cmt3', $messagesFromFile));
                    exit();
               }else{
                    $botty->reply('sorry!, i do not understand your response');
                    exit();
                }
            }


            if (isset($_SESSION['asymp-path-protect']) && $_SESSION['asymp-path-protect'] == 'yes') {
                if ($message == 'yes') {
                   $_SESSION['asymp-path-protect'] = 'no';
                    $botty->reply(getBotCareMessage('cm17', $messagesFromFile));
                    $botty->reply('<br><br>');
                    $botty->reply(getBotCareMessage('cmt3', $messagesFromFile));
                    exit();
                }elseif($message == 'no'){
                    $_SESSION['asymp-path-protect'] = 'no';
                    $botty->reply(getBotCareMessage('cm15', $messagesFromFile));
                    $botty->reply('<br><br>');
                    $botty->reply(getBotCareMessage('cmt3', $messagesFromFile));
                    exit();
                }else{
                    $botty->reply('sorry!, i do not understand your response');
                    exit();
                }
                
            }

            //symp
            if(isset($_SESSION['symp-path']) && $_SESSION['symp-path'] == 'yes'){
                if($message == 'yes' || $message == 'no'){
                    $botty->reply(getBotQuestion('qtn31', $messagesFromFile));
                    $_SESSION['exposure-path'] = 'yes';
                    $_SESSION['symp-path'] = 'no';
                    $_SESSION['sick'] = 'no';
                    
                    exit();
                }else{
                    $botty->reply('sorry!, i do not understand your response');
                    exit();
                }
                
            }

            if (isset($_SESSION['exposure-path']) && $_SESSION['exposure-path'] == 'yes') {
                // $botty->reply(getBotQuestion('qtn8', $messagesFromFile));

                 if ($message =='yes') {
                    $_SESSION['test'] = 'yes';
                    $_SESSION['exposure-path'] = 'no';
                     $botty->reply(getBotQuestion('qtn7', $messagesFromFile));
                    
                    exit();
                }elseif($message == 'no'){
                    
                    $_SESSION['exposure-path'] = 'no';
                    $botty->reply(getBotCareMessage('cm10', $messagesFromFile));
                    $botty->reply('<br><br>');
                    $botty->reply(getBotCareMessage('cmt3', $messagesFromFile));
                      exit();
                }else{
                    $botty->reply('sorry!, i do not understand your response');
                    exit();
                }

                
            }


            if (isset($_SESSION['test']) && $_SESSION['test'] == 'yes') {
                
                if($message == 'yes'){
                    //  echo 'iii';
                    $_SESSION['test'] = 'no';
                    $_SESSION['symp-path-volunteer'] = 'yes';
                    $botty->reply(getBotQuestion('qtn8', $messagesFromFile));
                    
                    exit();
                   

                }elseif($message == 'no'){
                    $_SESSION['test'] = 'no';
                    $botty->reply(getBotCareMessage('cm7', $messagesFromFile));
                    $botty->reply('<br><br>');
                    $botty->reply(getBotCareMessage('cmt5', $messagesFromFile));
                    exit();
                }else{
                    $botty->reply('sorry!, i do not understand your response');
                    exit();
                }
            }


            if (isset($_SESSION['symp-path-volunteer']) && $_SESSION['symp-path-volunteer'] == 'yes') {
                if ($message == 'yes') {
                    $_SESSION['symp-path-volunteer'] = 'no';
                    $botty->reply(getBotCareMessage('cm8', $messagesFromFile));
                    $botty->reply('<br><br>');
                    $botty->reply(getBotCareMessage('cmt5', $messagesFromFile));
                    exit();
                }elseif($message == 'no'){
                     $_SESSION['symp-path-volunteer'] = 'no';
                    $_SESSION['symp-path-apply'] = 'yes';
                     $botty->reply(getBotQuestion('qtn9', $messagesFromFile));
                    
                    exit();
                }else{
                    $botty->reply('sorry!, i do not understand your response');
                    exit();
                }
            }


            if (isset($_SESSION['symp-path-apply']) && $_SESSION['symp-path-apply'] == 'yes') {
                if ($message == 'yes') {
                    $_SESSION['symp-path-apply'] = 'no';
                    $botty->reply(getBotCareMessage('cm8', $messagesFromFile));
                    $botty->reply('<br><br>');
                    $botty->reply(getBotCareMessage('cm29', $messagesFromFile));
                    $botty->reply('<br><br>');
                    $botty->reply(getBotCareMessage('cmt50', $messagesFromFile));
                    exit();

                   
                }elseif($message == 'no'){
                     $_SESSION['symp-path-apply'] = 'no';
                     $_SESSION['symp-path-apply-testing'] = 'yes';
                    $botty->reply(getBotQuestion('qtn10', $messagesFromFile));
                    
                    exit();
                    
                }else{
                    $botty->reply('sorry!, i do not understand your response');
                    exit();
                }
            }


            if (isset($_SESSION['symp-path-apply-testing']) && $_SESSION['symp-path-apply-testing'] == 'yes') {
                if ($message == 'yes') {
                    $_SESSION['symp-path-apply-testing'] = 'no';
                    $botty->reply(getBotCareMessage('cm8', $messagesFromFile));
                    $botty->reply('<br><br>');
                    $botty->reply(getBotCareMessage('cm27', $messagesFromFile));
                    $botty->reply('<br><br>');
                    $botty->reply(getBotCareMessage('cm19', $messagesFromFile));
                    $botty->reply('<br><br>');
                    $botty->reply('End of Covid-19 checker. Please reset if you want to try again.');
                    session_destroy();
                    exit();

                   
                }elseif($message == 'no'){
                     $_SESSION['symp-path-apply-testing'] = 'no';
                   $botty->reply(getBotCareMessage('cm18', $messagesFromFile));
                    $botty->reply('<br><br>');
                    $botty->reply(getBotCareMessage('cm19', $messagesFromFile));
                    $botty->reply('<br><br>');
                    $botty->reply('End of Covid-19 checker. Please reset if you want to try again.');
                                 session_destroy();       
                    exit();
                    
                }else{
                    $botty->reply('sorry!, i do not understand your response');
                    exit();
                }
            }

            

        }

        if (isset($_SESSION['intro']) && $_SESSION['intro'] == 'yes') {

            if($message == 'no'){
           
                $botty->reply(getBotResponse('msg12', $messagesFromFile));
                exit();
            }


            if($message == 'yes' || $message == 'ok'){
            // var_dump($message);
                $botty->reply('I’m going to ask you some questions. I will use your answers to give you advice about the level of medical care you should seek. But first, if you are experiencing a life-threatening emergency, please call 911 immediately. If you are not experiencing a life-threatening emergency, let’s get started. During the assessment, you can refresh the page if you need to start again.');

                $botty->reply('<br><br>');

                $botty->reply('What is your (their) age?. Choose these options. a) below 10 years, b) below 17 years but above 9 years and c) 20 years and above.');

                    exit();
            }

            if($message == 'a'){
                $botty->reply(getBotResponse('msg20', $messagesFromFile));
                $botty->reply('<br><br>');
                $botty->reply('What is your gender? male or female');
                exit();
            }

            if ($message == 'b') {
                $botty->reply(getBotResponse('msg21', $messagesFromFile));
                $botty->reply('<br><br>');
                $botty->reply('What is your gender? male or female');
                exit();
            }

            if ($message == 'c') {
                // echo 'hi';
                $botty->reply('What is your gender?  male or  female');
                exit();

            }

            if ($message == 'male' || $message == 'female') {
                $_SESSION['gender'] = 'yes';
                $_SESSION['symptoms'] = 'yes';
                // $_SESSION['female']
                $botty->reply(getBotQuestion('qtn1', $messagesFromFile));
            

                // var_dump($_SESSION);
                exit();
            }

            $optionList = ['hi', 'hello', 'yes', 'no', 'male', 'female', 'a', 'b', 'c'];

// var_dump(in_array($message, $optionList));
// var_dump($message .'hi');
            
            if (!in_array($message, $optionList)) {
                
                $botty->reply('sorry!, i do not understand your response');
                exit();
            }

            if($message == 'hi' || $message == 'hello' || $message == 'hi kojo' || $message != 'hello kojo'){
                
                $botty->reply('hi user, the covid checker is running. Do you want to reset it?');
                $botty->reply('<br><br>');
                $botty->reply('Type "reset" to start fresh.');
                $botty->reply('<br><br>');
                $botty->reply('Do you consent to use this checker?');
                exit();

            }

            
        }

        if($message == 'hi' || $message == 'hello' || $message == 'hi kojo' || $message != 'hello kojo'){
            $_SESSION['intro'] = 'yes';
            $botty->reply('Welcome to the covid 19 health screening. The purpose of the Coronavirus Self-Checker is to help you make decisions about    seeking appropriate medical care.  This system is not intended for the diagnosis or treatment of disease, including COVID-19.');
            $botty->reply('<br><br>');
            $botty->reply(' Do you consent to use this checker?');
            exit();

        }else{
            $botty->reply('sorry!, i do not understand your response');
            exit();
        }
               
        
     
        // if($botty->ask($message, $questionArray) == ''){
        //     $botty->reply("Sorry!, can't respond to that question");
        //     exit();
        // }
        // else{
        //     $botty->reply($botty->ask($message, $questionArray));
        // }

    });

    


}



