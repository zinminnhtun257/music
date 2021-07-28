<?php
function con(){
    return mysqli_connect('localhost',"root","","music_room");
}

$info = array(
    "name" => "Sample Blog",
    "short"=> "SB",
    "description" => "ကျောင်းသားများအတွက် Sample Project"
);

$role = ['admin','editor','user'];

$url = "http://{$_SERVER["HTTP_HOST"]}/Music_Room";