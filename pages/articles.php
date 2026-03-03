
<div class="row justify-content-center">
    <div class="col-md-8 text-center">
        <h1 class="display-4">Ez a cikkek listája</h1>
    </div>
</div>

<?php 

if (isset($app->getUrlParts()[1])) {
    $article = $app->getUrlParts()[1];
}

if (isset($_GET["page"])) {
    echo "Ez a " . $_GET["page"] . ". oldal. <br />";
}


if (isset($article)) {
    echo $article;
}

?>
