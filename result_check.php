<?php include 'includes/header.php'; ?>

<div class="page-wrapper">
    <div class="content">
        <div class="center-box">
            <h2>Check Result</h2>
            <form method="POST" action="view_result.php">
                <div class="form-group">
                    <label for="regno">Register Number</label>
                    <input type="text" name="regno" id="regno" required>
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" name="dob" id="dob" required>
                </div>
                <div class="form-group">
                    <button type="submit">Check Result</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
