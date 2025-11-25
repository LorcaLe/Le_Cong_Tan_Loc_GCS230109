<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="/Coursework/templates/UI/style.css"> 
        
    <title>ADMIN - <?= htmlspecialchars($title) ?></title>
</head>
<body>
    
    <header class="admin-header">
        <div class="container">
            <h1>Student Forum</h1>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm mb-4">
        <div class="container">
            <!-- <span class="navbar-brand">Admin Menu</span> -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../../controller/admin/index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../controller/admin/questions.php">Questions List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../controller/admin/addquestion.php">Add Question</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../controller/admin/inbox.php">View Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../controller/admin/manage_modules.php">Manage Modules</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../controller/admin/manage_users.php">Manage Users</a> </li>
                    <li class="nav-item">
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm" href="../../controller/auth/logout.php">Log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <main class="container mt-4">

        <?=$output?>


    </main>

    <footer class="site-footer">
            <div class="container text-center">
                &copy; <?= date('Y') ?> Student Forum - Admin Area
            </div>
        </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>