<?php include("includes/header.php"); ?>

<div class="page-wrapper">
  <main class="full-height">
    <div class="center-box login-box">
      <h2>Login</h2>
      <form action="process_login.php" method="POST">
        <div class="form-group">
          <label for="role">Login as:</label>
          <select name="role" id="role" required>
            <option value="">-- Select Role --</option>
            <option value="HOD">HOD</option>
            <option value="STAFF">Staff</option>
            <option value="COE">Admin / COE</option>
          </select>
        </div>

        <div class="form-group">
          <label for="username">Username:</label>
          <input type="text" name="username" id="username" required>
        </div>

        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" name="password" id="password" required>
        </div>

        <div class="form-group">
          <button type="submit">Login</button>
        </div>
      </form>
    </div>
  </main>
</div>

<?php include("includes/footer.php"); ?>
