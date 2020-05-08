<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container m-2">
  <h2 class="text-secondary font-weight-normal">Add item</h2>
  <div class="row">
    <div class="card container mt-5 col-10 align-middle">
      <div class="card-body">
        <form action="<?php echo URLROOT . '/items/add'; ?>" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control <?php echo (!empty($data['titleError'])) ? 'is-invalid' : ''; ?>" id="title" name="title" value="<?php echo $data['title']; ?>">
            <span class="invalid-feedback"><?php echo $data['titleError'] ?></span>
          </div>
          <div class="form-group">
            <label for="type">Type:</label>
            <select name="type" id="type" class="form-control">
              <option value="1">Product</option>
              <option value="2">Service</option>
            </select>
          </div>
          <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control <?php echo (!empty($data['descriptionError'])) ? 'is-invalid' : ''; ?>" id="description" name="description" rows="3"><?php echo $data['description']; ?></textarea>
            <span class="invalid-feedback"><?php echo $data['descriptionError'] ?></span>
          </div>
          <div class="form-group">
            <label for="image">Select image:</label>
            <input type="file" class="form-control-file <?php echo (!empty($data['imageError'])) ? 'form-control is-invalid' : ''; ?>" id="image" name="image">
            <span class="invalid-feedback"><?php echo $data['imageError'] ?></span>
          </div>
          <button type="submit" class="btn btn-sm btn-primary align-middle">Add</button>
        </form>
      </div>
      <div class="card-footer bg-white">
        <a href="<?php echo URLROOT . '/pages/dashboard'; ?>" class="card-link">Cancel</a>
      </div>
    </div>
  </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>