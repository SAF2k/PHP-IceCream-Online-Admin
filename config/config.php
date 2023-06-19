<?php

$conn = mysqli_connect("localhost", "root", "", "kushi");

if (!$conn) {
    echo "Connection Failed";
}