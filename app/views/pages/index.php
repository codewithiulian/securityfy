<?php require APPROOT . '/views/inc/header.php'; ?>
<?php foreach($data['items'] as $item) : ?>
    <div class="card mt-3">
      <div class="card-header">
        <?php echo 'Updated on ' . $item->itemDate ;?>
      </div>
      <div class="card-body">
        <h5 class="card-title"><?php echo $item->itemTitle; ?></h5>
        <p class="card-text"><?php echo $item->itemDescription; ?></p>
        <a href="#" class="btn btn-sm btn-secondary">Check out</a>
      </div>
    </div>
  <?php endforeach; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>