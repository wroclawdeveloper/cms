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
        <div class="col-sm-1 sidenav">
            <?php include(dirname(__DIR__) . '/Template/topic_menu.php') ?>
        </div>
        <div class="col-sm-11 text-left">
            <?php
            /* @var $article Article */
            if (isset($article)) { ?>
            <h1>
                <?php print($article->getTitle()) ?>
                <?php
                if (isset($_SESSION) && !empty($_SESSION)) {
                    if ($_SESSION['id'] == $article->getOwner()->getIdUser() || $_SESSION['role'] == 'admin') {
                        ?>
                        <a href="?page=modify_article&id=<?php print($_GET['id']) ?>" class="btn btn-primary" type="button" onclick="editArticle()">
                            <i class="fas fa-edit"></i></a>
                        <button class="btn btn-danger" type="button" onclick="deleteArticle()">
                            <i class="fas fa-trash-alt"></i></button>

                    <?php }
                } ?>
            </h1>
            <?php ?>
            <p>
                <?php
                print('Utworzono: ' . date("d/m/Y G:i", strtotime($article->getAuditcd())));
                if ($article->getAuditcd() != $article->getAuditmd()) {
                    print('</br>Zmodyfikowano: ' . date("d/m/Y G:i", strtotime($article->getAuditmd())));
                }
                ?>
            </p>
            <hr>
            <div id="article" class="article">
                <p>
                    <?php
                    print($article->getContent());
                    ?>
                </p>
                <?php
                }
                ?>
            </div>
            <hr>
            <div id="output"></div>

        </div>
    </div>
</div>

<footer class="container-fluid text-center">
    <?php include(dirname(__DIR__) . '/Template/footer.php'); ?>
</footer>
<script src="/public/scripts/comments.js"></script>
<script src="/public/scripts/delete_article.js"></script>
</body>
</html>