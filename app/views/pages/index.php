<?php require APPROOT . '/views/inc/header.php'; ?>
<h1>Index</h1>
<div class="row mt-4 d-flex align-items-center">
  <?php foreach ($data as $item) : ?>
    <div class="col-sm">
      <div class="card mt-3 mb-2" style="width: 18rem;">
        <div class="card-header">
          <div class="row">
            <div class="col"><?php echo $item->itemType . ' added by ' . $item->itemAuthor . ' on ' . $item->itemDate; ?></div>
            <div class="col-1">
              <div class="float-right">
                <a href="<?php echo URLROOT . '/items/delete/' . $item->itemId; ?>"><i class="far fa-trash-alt"></i></a>
              </div>
            </div>
          </div>
        </div>
        <img class="card-img-top" src="data:image;base64,<?php echo base64_encode($item->itemImage); ?>" alt="Card image cap">
        <div class="card-body">
          <h5 class="card-title"><?php echo $item->itemTitle; ?></h5>
          <p class="card-text"><?php echo substr($item->itemDescription, 0, 50) . "..."; ?></p>
          <a href="<?php echo URLROOT . '/items/show/' . $item->itemId; ?>" class="card-link">Read more...</a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>