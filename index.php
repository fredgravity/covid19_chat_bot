<?php
session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Covid 19 ChatBot</title>
    <link rel="stylesheet" href="./assets/css/all.css">
    <link rel="stylesheet" href="./assets/css/botStyle.css">
    <link rel="stylesheet" href="./assets/fontawesome/css/fontawesome.css">
</head>
<body>
    <div class="grid-container" id="wrapper">
        <h4 class="text-center" style="color: ghostWhite;">Covid 19 Chat Bot</h4>
    
        <div class="grid-x grid-padding-x" id="chatbox">
            <div class="small-12 medium-2"></div>

            <div class="small-12 medium-8 cell">
                <div class="grid-x grid-padding-x ">
                    <!-- <div class=""> -->
                        <div class="small-12 medium-6 cell icon">
                            <p class="float-left"> <i class="fa fa-user"></i> Kojo</p>
                        </div> 
                        <div class="small-12 medium-6 cell icon">
                            <p class=" float-right"> User <i class="fa fa-user"></i></p>
                        </div>
                                        
                </div>
                <div class="grid-x">
                    <div class="card chatbox-card">
                   
                        <div class="card-section" id="chat-display">
                            <p class="message-tag bot">hi there!, i am Kojo. You can type 'reset' to start again. Say 'Hi' now.</p>
                        <!-- <p class="message-tag user float-right"> hi there!</p> -->
                        </div>
                    
                    </div> 
                </div>
<img src="./assets/images/giphy.gif" alt=""  id="wave-image">
                <div class="grid-x">
                    <div class="card-divider cell">
                        <div class="grid-x cell">
                            <div>
                                <div class="grid-x grid-padding-x">
                                    <div class="small-12 medium-5 cell">
                                        <label for="rate" style="color: white;" >Rate</label>
                                        <input type="range" name="rate" id="rate" min="0.5" max="2" value="1" step="0.1">
                                    </div>
                                     <div class="small-12  medium-5 cell " style="color: white;">
                                        <div class="float-right">
                                            <label for="pitch" style="color: white;" >Pitch</label>
                                            <input type="range" name="pitch" id="pitch" min="0.5" max="2" value="1" step="0.1">
                                            
                                        </div>
                                       
                                    </div>
                                    <div class="small-12  medium-2 cell" style="color: white; ">
                                       <button class="button  alert" id="stop-kojo" style="outline:none;"> <small>Stop Kojo</small> </button>
                                    </div>
                                   
                                </div>
                                
                            </div>

                            <div class="input-group ">
                                <input class="input-group-field" type="text" placeholder="type anything..." value="" id="chat-input-text">
                            </div>
                        </div>
                        
                        
                    </div>
                    <button class="button cell" id="chat-btn" style="outline: none;">Ok</button>
                </div>

                
            </div>

            <div class="small-12 medium-2">
               
            </div>

           

        
        </div>

    
    </div>

    <script src="./assets/js/jQuery.min.js" defer></script>
    <script src="./assets/fontawesome/js/allfonts.js" defer></script>
    <script src="./assets/js/chat.js" defer></script>
    <script src="./assets/js/axios.js" defer></script>
    <script src="./assets/js/xlsl.js" defer></script>
</body>
</html>


