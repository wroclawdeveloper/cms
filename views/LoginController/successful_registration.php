<!DOCTYPE html>
<html lang="pl">

<?php include(dirname(__DIR__) . '/head.html'); ?>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03"
            aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <?php include(dirname(__DIR__) . '/Template/menu.php') ?>
        </ul>
        <ul class="navbar-nav my-2 my-lg-0">
            <?php include(dirname(__DIR__) . '/Template/login_panel.php') ?>
        </ul>
    </div>
</nav>

<div class="container-fluid text-center">
    <div class="row content">
        <div class="col-sm-12 text-middle">

            <h1>Rejestracja</h1>
            <hr>
            <?php if (isset($message)): ?>
                <?php foreach ($message as $item): ?>
                    <div><?= $item ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
</div>

<footer class="container-fluid text-center">
    <?php include(dirname(__DIR__) . '/Template/footer.php'); ?>
</footer>

</body>
</html>