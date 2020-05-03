<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container m-2">
  <h2 class="text-dark font-weight-normal">Dashboard</h2>

  <div class="card">
    <div class="card-header">
      Insights
    </div>
    <div class="card-body">
      <h5 class="card-title">Number of items on your website:</h5>
      <h1 class="card-text text-success"><?php echo $data['totalItems']; ?></h1>
      <h5 class="card-text">Out of which <span class="text-success"><?php echo $data['totalProducts']; ?></span> products and <span class="text-success"><?php echo $data['totalServices']; ?></span> services.</h5>
      <a href="<?php echo URLROOT . '/items/add'; ?>" class="color-white btn btn-sm btn-success">Add more</a>
    </div>
  </div>

  <h2 class="text-dark font-weight-normal mt-5">Your items</h2>

  <div class="row mt-4 d-flex align-items-center">
    <?php foreach ($data['items'] as $item) : ?>
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
            <p class="card-text"><?php echo $item->itemDescription; ?></p>
            <a href="<?php echo URLROOT . '/items/show/' . $item->itemId; ?>" class="card-link">Read more...</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>


</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>