<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../../templates/UI/style.css"> 
        <title><?= htmlspecialchars($title) ?></title>
    </head>
    <body>

        <header class="site-header">
            <div class="container">
                <h1><a href="../../index.php">Student Forum</a></h1>
            </div>
        </header>
        <? include '/Coursework/includes/config.php'; ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm mb-4">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mainNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../../controller/user/index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../controller/user/questions.php">Questions List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../controller/user/addquestion.php">Add Question</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../controller/user/contact.php">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../controller/user/inbox.php">My Inbox</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="edit_profile.php">Edit Profile</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="btn btn-outline-danger btn-sm" href="../../controller/auth/logout.php">Log out</a>
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
                &copy; <?= date('Y') ?> Student Forum
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>