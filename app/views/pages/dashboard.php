<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/datatables.php'; ?>

<style>
  thead input {
    width: 100%;
    padding: 3px;
    box-sizing: border-box;
  }
</style>

<script src="<?php echo URLROOT . '/scripts/dashboard.js'; ?>"></script>

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

  <table id="itemsTable" class="table table-striped table-bordered compact display nowrap" style="width:100%">
    <thead>
      <tr>
        <th>Title</th>
        <th>Date</th>
        <th>Type</th>
        <th>Author</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th>Title</th>
        <th>Date</th>
        <th>Type</th>
        <th>Author</th>
      </tr>
    </tfoot>
  </table>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>