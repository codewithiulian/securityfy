<?php

session_start();

function logUserIn($userId, $userName){
  $_SESSION['userId'] = $userId;
  $_SESSION['userName'] = $userName;
}

/**
 * Checks for session variables.
 * Checks against given user id and name.
 */
function isUserLoggedIn($userId, $userName){
  if(isset($_SESSION['userId']) && isset($_SESSION['userName'])){
    if($_SESSION['userId'] == $userId && $_SESSION['userName'] == $userName){
      return true;
    }
  }
  return false;
}

/**
 * Checks for session variables.
 */
function isLoggedIn(){
  return isset($_SESSION['userId']) && isset($_SESSION['userName']);
}