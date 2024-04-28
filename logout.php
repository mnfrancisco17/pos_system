<?php
// Start session
session_start();

// Include authentication functions
include_once 'auth.php';

// Logout user
logout();
