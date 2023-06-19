<?php

function redirect($url, $message)
{
    $_SESSION['message'] = $message;
    header('Location: ' . $url);
    exit();
}

function msg($message)
{
     $_SESSION['message'] = $message;

}

?>