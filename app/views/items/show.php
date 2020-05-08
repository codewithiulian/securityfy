<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container mt-5 align-center">
  <div class="row">
    <div class="col"></div>
    <div class="col-8">
      <div class="card">
        <img class="card-img-bottom" src="data:image;base64,<?php echo base64_encode($data->itemImage); ?>" alt="Item image">
        <div class="card-body">
          <h5 class="card-title"><?php echo $data->itemTitle; ?></h5>
          <p class="card-text"><?php echo $data->itemDescription; ?></p>
          <p class="card-text"><small class="text-muted">Last updated by <?php echo $data->itemAuthor . " on " . $data->updatedOn; ?></small></p>
        </div>
      </div>
    </div>
    <div class="col"></div>
  </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>