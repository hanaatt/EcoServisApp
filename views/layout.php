<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>EcoServis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: bold;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm px-4 py-2">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="index.php">EcoServis</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">

                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.php?page=prijavi-problem">Prijavi problem</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.php?page=moje-prijave">Moje prijave</a>
                    </li>
                    <?php if ($_SESSION['user']['tip'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="index.php?page=admin-prijave">Admin panel</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link text-danger fw-semibold" href="index.php?page=logout">Odjavi se</a>
                    </li>
                    <li class="nav-item ms-3">
                        <span class="nav-link disabled text-white-50">Dobrodošao, <?= htmlspecialchars($_SESSION['user']['ime']) ?></span>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.php?page=login">Prijava</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.php?page=register">Registracija</a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>

<main class="container mt-4">
