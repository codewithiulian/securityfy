<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
  <div class="card container mt-5 col-6 align-middle">
    <div class="card-body">
    <h3 class="card-title">Create an account</h3>
      <form action="<?php echo URLROOT . '/users/login'; ?>" method="post">
        <div class="form-group">
          <label for="email">Email address:</label>
          <input type="email" class="form-control <?php echo (!empty($data['emailError'])) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?php echo $data['email']; ?>">
          <span class="invalid-feedback"><?php echo $data['emailError'] ?></span>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" class="form-control <?php echo (!empty($data['passwordError'])) ? 'is-invalid' : ''; ?>" id="password" name="password" value="<?php echo $data['password']; ?>">
          <span class="invalid-feedback"><?php echo $data['passwordError'] ?></span>
        </div>
        <button type="submit" class="btn btn-sm btn-primary align-middle">Login</button>
      </form>
    </div>
    <div class="card-footer bg-white">
      Don't have an account? <a href="<?php echo URLROOT . '/users/register'; ?>" class="card-link">Register</a>
    </div>
  </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>