<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <p>Enter your new password for <?= htmlspecialchars($user['email']) ?>.</p>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                        <script>
                            setTimeout(() => {
                                window.location.href = "../../templates/auth/login.html.php";
                            }, 2000);
                        </script>
                <?php else: ?>
                    <form action="reset_password.php?token=<?= htmlspecialchars($token) ?>" method="POST">
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Confirm New Password</label>
                            <input type="password" name="password_confirm" id="password_confirm" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>