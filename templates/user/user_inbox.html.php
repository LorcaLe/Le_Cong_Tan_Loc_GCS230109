<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-4">
    <h2>My Message History</h2>
    <p>View your sent messages and replies from the admin.</p>

    <?php if (empty($messages)): ?>
        <div class="alert alert-info">You have not sent any messages yet.</div>
    <?php endif; ?>

    <?php foreach ($messages as $msg): ?>
        <div class="card mb-3">
            <div class="card-header">
                <strong>Subject: <?= htmlspecialchars($msg['subject']) ?></strong>
                <span class="badge 
                    <?php if ($msg['status'] == 'replied'): echo 'bg-success'; 
                          elseif ($msg['status'] == 'read'): echo 'bg-primary';
                          else: echo 'bg-warning text-dark'; endif; ?>
                ">
                    <?= htmlspecialchars($msg['status']) ?>
                </span>
            </div>
            
            <div class="card-body">
                <h6 class="card-title">Your Message (Sent: <?= $msg['created_at'] ?>):</h6>
                <p class="card-text" style="white-space: pre-wrap;"><?= htmlspecialchars($msg['message']) ?></p>
            </div>

            <?php if (!empty($msg['reply_message'])): ?>
                <div class="card-footer bg-light">
                    <h6 class="card-title text-success">Admin's Reply (At: <?= $msg['replied_at'] ?>):</h6>
                    <p class="card-text" style="white-space: pre-wrap;"><?= htmlspecialchars($msg['reply_message']) ?></p>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>