<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container m-2">
  <h2 class="text-secondary font-weight-normal">Profile</h2>
  <ul class="list-group col-7 mt-3">
    <li class="list-group-item font-weight-bold active">
      <div class="row">
        <div class="col">Profile</div>
        <div class="col"></div>
      </div>
    </li>
    <li class="list-group-item">
      <div class="row">
          <div class="col">First name:</div>
          <div class="col"><span class="font-weight-bold"><?php echo $data['firstName']; ?></span></div>
      </div>
    </li>
    <li class="list-group-item">
      <div class="row">
          <div class="col">Last name:</div>
          <div class="col"><span class="font-weight-bold"><?php echo $data['lastName']; ?></span></div>
      </div>
    </li>
    <li class="list-group-item">
      <div class="row">
          <div class="col">Email address:</div>
          <div class="col"><span class="font-weight-bold"><?php echo $data['email']; ?></span></div>
      </div>
    </li>
    <li class="list-group-item">
      <div class="row">
          <div class="col">Registered on:</div>
          <div class="col"><span class="font-weight-bold"><?php echo $data['registeredOn']; ?></span></div>
      </div>
    </li>
  </ul>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>