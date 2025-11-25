<div class="card">
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            
            <input type="hidden" name="questionid" value="<?= htmlspecialchars($question['id']) ?>">
            
            <div class="mb-3">
                <label for="text" class="form-label">Question text:</label>
                <textarea name="text" id="text" rows="5" class="form-control" required><?= htmlspecialchars($question['text']) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="moduleid" class="form-label">Module:</label>
                <select name="moduleid" id="moduleid" class="form-select" required>
                    <?php foreach ($modules as $module): ?>
                        <option value="<?= htmlspecialchars($module['id']) ?>"
                            <?php if ($module['id'] == $question['moduleid']) echo 'selected'; ?>
                        >
                            <?= htmlspecialchars($module['moduleName']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Current Image:</label><br>
                <?php if (!empty($question['img'])): ?>
                    <img src="../../images/<?= htmlspecialchars($question['img']) ?>" 
                         alt="Current image" 
                         class="img-thumbnail mb-2"
                         style="max-width:250px;">
                <?php else: ?>
                    <p class="text-muted">No current image.</p>
                <?php endif; ?>
                
                <label for="image" class="form-label">Upload New Image (Optional):</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
            </div>

            <input type="submit" name="submit" value="Save Changes" class="btn btn-success">
            <a href="questions.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>