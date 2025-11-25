<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
    <h3>Message from <?= htmlspecialchars($msg['sender_name']) ?></h3>

    <div class="card mt-3">
        <div class="card-body">
            <h5><?= htmlspecialchars($msg['subject']) ?></h5>
            <p><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
            <small class="text-muted"><?= $msg['created_at'] ?></small>
        </div>
    </div>

    <h4 class="mt-4">Reply</h4>

    <form action="reply.php" method="POST">
        <input type="hidden" name="id" value="<?= $msg['id'] ?>">

        <textarea name="reply" class="form-control" rows="5" required><?= htmlspecialchars($msg['reply_message']) ?></textarea>

        <button class="btn btn-success mt-3">Send Reply</button>
    </form>
</div>
