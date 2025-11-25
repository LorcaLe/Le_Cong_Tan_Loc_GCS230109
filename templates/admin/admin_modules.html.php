<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">Manage Modules</h2>

        <div class="card mb-4 shadow-sm border-<?= $moduleToEdit ? 'warning' : 'primary' ?>">
            <div class="card-header <?= $moduleToEdit ? 'bg-warning text-dark' : 'bg-primary text-white' ?>">
                <?= $moduleToEdit ? 'Edit Module' : 'Add New Module' ?>
            </div>
            <div class="card-body">
                <form action="manage_modules.php" method="POST" class="d-flex gap-2">
                    
                    <?php if ($moduleToEdit): ?>
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?= $moduleToEdit['id'] ?>">
                        
                        <input type="text" name="moduleName" class="form-control" 
                               value="<?= htmlspecialchars($moduleToEdit['moduleName']) ?>" required>
                        
                        <button type="submit" class="btn btn-warning">Update</button>
                        <a href="manage_modules.php" class="btn btn-secondary">Cancel</a>
                        
                    <?php else: ?>
                        <input type="hidden" name="action" value="add">
                        
                        <input type="text" name="moduleName" class="form-control" 
                               placeholder="Enter new module name..." required>
                        
                        <button type="submit" class="btn btn-primary" style="min-width: 100px;">Add</button>
                    <?php endif; ?>
                    
                </form>
            </div>
        </div>

        <h3 class="mt-4">Existing Modules</h3>
        <ul class="list-group">
            <?php foreach ($modules as $module): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center <?= ($moduleToEdit && $moduleToEdit['id'] == $module['id']) ? 'list-group-item-warning' : '' ?>">
                    
                    <span class="fw-bold">
                        <?= htmlspecialchars($module['moduleName']) ?>
                    </span>
                    
                    <div>
                        <a href="manage_modules.php?action=edit&id=<?= $module['id'] ?>" class="btn btn-sm btn-warning me-2">
                            Edit
                        </a>

                        <form action="manage_modules.php" method="POST" class="d-inline" onsubmit="return confirm('WARNING: Deleting this module will delete all related questions. Continue?');">
                            <input type="hidden" name="module_id" value="<?= $module['id'] ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>