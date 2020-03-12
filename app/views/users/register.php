<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
  <div class="card container mt-5 col-6 align-middle">
    <div class="card-body">
    <h3 class="card-title">Create an account</h3>
      <form action="<?php echo URLROOT . '/users/register'; ?>" method="post">
        <div class="form-group">
          <label for="firstName">First name:</label>
          <input type="text" class="form-control <?php echo (!empty($data['firstName_err'])) ? 'is-invalid' : ''; ?>" id="firstName" name="firstName" value="<?php echo $data['firstName']; ?>">
          <span class="invalid-feedback"><?php echo $data['firstName_err'] ?></span>
        </div>
        <div class="form-group">
          <label for="lastName">Last name:</label>
          <input type="text" class="form-control <?php echo (!empty($data['lastName_err'])) ? 'is-invalid' : ''; ?>" id="lastName" name="lastName" value="<?php echo $data['lastName']; ?>">
          <span class="invalid-feedback"><?php echo $data['lastName_err'] ?></span>
        </div>
        <div class="form-group">
          <label for="email">Email address:</label>
          <input type="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" id="email" aria-describedby="emailHelp" value="<?php echo $data['email']; ?>">
          <span class="invalid-feedback"><?php echo $data['email_err'] ?></span>
          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" id="password" name="password">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-sm btn-primary align-middle">Register</button>
      </form>
    </div>
    <div class="card-footer bg-white">
      Already have an account? <a href="<?php echo URLROOT . '/users/login'; ?>" class="card-link">Login</a>
    </div>
  </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>