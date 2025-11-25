<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <p>Enter your email address and we will (simulate) send you a link to reset your password.</p>
                
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?= $message_type ?>">
                        <?= $message ?>
                    </div>
                <?php endif; ?>

                <form action="forgot_password.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Find Account</button>
                </form>
            </div>
        </div>
    </div>
</div>