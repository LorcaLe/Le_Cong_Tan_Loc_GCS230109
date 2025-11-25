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
                <h1><a href="../../controller/auth/login.php">Student Forum</a></h1>
            </div>
        </header>


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