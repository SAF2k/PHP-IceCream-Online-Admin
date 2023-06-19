<?php

function redirect($url, $message)
{
    $_SESSION['message'] = $message;
    header('Location: ' . $url);
    exit();
}

function msg($message,$method)
{
     $_SESSION['message'] = $message;
    $_SESSION['method'] = $method;

}

?>