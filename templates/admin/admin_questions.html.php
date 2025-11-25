<p class="lead mb-4"><?=$totalQuestion?> Question(s) have been submitted.</p>

<div class="row">
    <?php foreach ($questions as $question): ?>
        <div class="col-md-12 mb-4">
            <div class="card question-card shadow-sm">
                
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="fw-bold">
                        Posted by: 
                        <a href="mailto:<?= htmlspecialchars($question['email'], ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($question['name'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    </div>
                    
                    <div> 
                        <a href="editquestion.php?id=<?= $question['id'] ?>" class="btn btn-sm btn-outline-primary me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                            </svg>
                            Edit
                        </a>
                        
                        <form action="deletequestion.php" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this question?');">
                            <input type="hidden" name="id" value="<?= $question['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <?php if (!empty($question['img'])): ?>
                        <img src="../../images/<?= htmlspecialchars($question['img']) ?>" alt="Question image" class="img-fluid rounded mb-3" style="aspect-ratio: 16/9; object-fit: contain; width: 100%; background-color: #f8f9fa;">
                    <?php endif; ?>
                    
                    <p class="card-text fs-5">
                        <?= nl2br(htmlspecialchars($question['text'], ENT_QUOTES, 'UTF-8')) ?>
                    </p>
                </div>

                <div class="card-footer bg-light">
                    <span class="badge bg-dark">
                        <?= htmlspecialchars($question['moduleName'], ENT_QUOTES, 'UTF-8') ?>
                    </span>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>