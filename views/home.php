<?php require_once 'views/layout.php'; ?>

<div class="container mt-5">

    <div class="text-center mb-4">
        <h1 class="display-5 fw-bold text-success">EcoServis</h1>
        <p class="lead">Prijavite komunalni problem i pratite njegovo rešavanje.</p>
    </div>

    <?php if (isset($_SESSION['user'])): ?>
        <div class="row justify-content-center g-4">

            <div class="col-md-3">
                <div class="card border-success text-center h-100">
                    <div class="card-body">
                        <h5 class="card-title">Novi problem</h5>
                        <p class="card-text">Prijavite novi kvar ili komunalni problem u vašem okruženju.</p>
                        <a href="index.php?page=prijavi-problem" class="btn btn-outline-success">Prijavi</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-primary text-center h-100">
                    <div class="card-body">
                        <h5 class="card-title">Moje prijave</h5>
                        <p class="card-text">Pregledajte sve probleme koje ste do sada prijavili.</p>
                        <a href="index.php?page=moje-prijave" class="btn btn-outline-primary">Pogledaj</a>
                    </div>
                </div>
            </div>

            <?php if ($_SESSION['user']['tip'] === 'admin'): ?>
                <div class="col-md-3">
                    <div class="card border-warning text-center h-100">
                        <div class="card-body">
                            <h5 class="card-title">Admin panel</h5>
                            <p class="card-text">Upravljajte svim prijavama, statusima i statistikom.</p>
                            <a href="index.php?page=admin-prijave" class="btn btn-outline-warning">Ulaz</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-md-3">
                <div class="card border-danger text-center h-100">
                    <div class="card-body">
                        <h5 class="card-title">Odjava</h5>
                        <p class="card-text">Završite sesiju i bezbedno se odjavite.</p>
                        <a href="index.php?page=logout" class="btn btn-outline-danger">Odjavi se</a>
                    </div>
                </div>
            </div>

        </div>
    <?php else: ?>
        <div class="text-center mt-5">
            <p class="fs-4">Da biste prijavili komunalni problem, potrebno je da se prijavite ili registrujete.</p>
            <a href="index.php?page=login" class="btn btn-success me-2">Prijavi se</a>
            <a href="index.php?page=register" class="btn btn-outline-secondary">Registruj se</a>
        </div>
    <?php endif; ?>

</div>
