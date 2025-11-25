<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

<div class="container mt-4">
    <h2>📨 Contact Messages</h2>
    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
        <tr>
            <th>Sender</th>
            <th>Subject</th>
            <th>Status</th>
            <th>Received</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($messages as $msg): ?>
            <tr style="vertical-align: middle;">
                <td><?= htmlspecialchars($msg['sender_name']) ?></td>
                <td><?= htmlspecialchars($msg['subject']) ?></td>

                <td>
                    <?php if ($msg['status'] == 'replied'): ?>
                        <span class="badge bg-success">Replied</span>
                    
                    <?php elseif ($msg['status'] == 'read'): ?>
                        <span class="badge bg-primary">Read</span>
                    
                    <?php else: ?>
                        <span class="badge bg-warning text-dark">Unread</span>
                    <?php endif; ?>
                    </td>

                <td><?= $msg['created_at'] ?></td>

                <td>
                    <a href="view.php?id=<?= $msg['id'] ?>" class="btn btn-primary btn-sm">
                        View & Reply
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>