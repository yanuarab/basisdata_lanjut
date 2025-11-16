<?php
session_start();

function isLogin() {
    return isset($_SESSION['admin']);
}

function mustLogin() {
    if (!isLogin()) {
        header("Location: ../../public/index.php");
        exit();
    }
}
