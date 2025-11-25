<div class="card">
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            
            <div class="mb-3">
                <label for="text" class="form-label">Question text:</label>
                <textarea name="text" id="text" rows="5" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label for="moduleid" class="form-label">Select Module:</label>
                <select name="moduleid" id="moduleid" class="form-select" required>
                    <option value="">Select a Module</option>
                    <?php foreach ($modules as $module): ?>
                    <option value="<?= htmlspecialchars($module['id'], ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($module['moduleName'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="image" class="form-label">Select image (Optional):</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
            </div>
            
            <input type="submit" value="Add Question" class="btn btn-primary">
            
        </form>
    </div>
</div>