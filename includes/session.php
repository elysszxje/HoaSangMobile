<?php
session_start();

function isLoggedIn()
{
    return isset($_SESSION['user']);
}

function isRole($role)
{
    return isset($_SESSION['user']['Role']) && $_SESSION['user']['Role'] === $role;
}

function redirectBasedOnRole()
{
    $role = $_SESSION['user']['Role'];
    if ($role === 'Admin') {
        header('Location: admin/dashboard.php');
    } else {
        header('Location: index.php');
    }
    exit();
}
