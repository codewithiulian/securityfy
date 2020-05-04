<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


  <title><?php echo SITENAME; ?></title>
</head>

<body>
  <input type="hidden" id="urlRoot" name="urlRoot" value="<?php echo URLROOT; ?>">
  <input type="hidden" id="appRoot" name="appRoot" value="<?php echo APPROOT; ?>">

  <?php require APPROOT . '/views/inc/navbar.php'; ?>
  <div class="container">