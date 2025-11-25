<p class="lead mb-4"><?=$totalQuestion?> Question(s) have been submitted.</p>

<div class="row">
    <?php foreach ($questions as $question): ?>
        <div class="col-md-12 mb-4">
            <div class="card question-card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    
                    <div class="fw-bold">
                        Posted by: 
                        <a href="mailto:<?= htmlspecialchars($question['email'], ENT_QUOTES, 'UTF-8') ?>" class="text-decoration-none">
                            <?= htmlspecialchars($question['name'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    </div>

                    <span class="badge bg-primary">
                        <?= htmlspecialchars($question['moduleName'], ENT_QUOTES, 'UTF-8') ?>
                    </span>
                </div>

                <div class="card-body">

                    <p class="card-text fs-5">
                        <?= nl2br(htmlspecialchars($question['text'], ENT_QUOTES, 'UTF-8')) ?>
                    </p>

                    <?php if (!empty($question['img'])): ?>
                        <img src="<?= BASE_URL ?>/images/<?= htmlspecialchars($question['img']) ?>"
                             alt="Question image"
                             class="img-fluid rounded mb-3"
                             style="aspect-ratio: 16/9; object-fit: contain; width: 100%; background-color: #f8f9fa;">
                    <?php endif; ?>

                </div>
                
                <div class="card-footer bg-light d-flex justify-content-between align-items-center">

                    <?php if (isset($_SESSION['user']) && ($question['userid'] == $_SESSION['user']['id'] || $_SESSION['user']['role'] === 'admin')): ?>
                        <a href="editquestion.php?id=<?= $question['id'] ?>" class="btn btn-outline-secondary btn-sm">
                            Edit your question
                        </a>

                        <form action="deletequestion.php" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                            <input type="hidden" name="question_id" value="<?= $question['id'] ?>">
                            <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                        </form>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>