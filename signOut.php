<?php
session_start();

if(isset($_SESSION['logged'])) {
    unset($_SESSION['logged']);
    echo 'Bye, bye :)';
} else {
    echo 'You are not sign in. ';
}