<?php

session_start();

function logUserIn($user, $redirectPath){
  $_SESSION['userId'] = $user->userId;
  $_SESSION['firstName'] = $user->firstName;
  $_SESSION['lastName'] = $user->lastName;
  $_SESSION['fullName'] = $user->fullName;
  $_SESSION['email'] = $user->email;
  $_SESSION['registeredOn'] = $user->registeredOn;

  redirect($redirectPath);
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
  return isset($_SESSION['userId'])
      && isset($_SESSION['firstName'])
      && isset($_SESSION['lastName'])
      && isset($_SESSION['fullName'])
      && isset($_SESSION['email']);
}

/**
 * Redirects the user to a specific route.
 */
function redirect($page) {
  header('location: ' . URLROOT . '/' . $page);
}