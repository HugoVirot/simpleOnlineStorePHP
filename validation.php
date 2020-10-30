<?php
session_start();

include('functions.php');

if (isset($_POST['chosenArticle'])) {

    $chosenArticleId = $_POST['chosenArticle'];
    $article = getArticleFromId($chosenArticleId);
    addToCart($article);
}

if (isset($_POST['deletedArticle'])) {
    $deletedArticleId = $_POST['deletedArticle'];
    removeToCart($deletedArticleId);
}

if (isset($_POST['modifiedArticleId'])) {
    updateQuantity();
}

if (isset($_POST['emptyCart']) && $_POST['emptyCart'] == true) {
    emptyCart();
}

var_dump($_POST);
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valider la commande - Arinfo, montres intemporelles</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>

<body>
    <header>
        <?php
        include('header.php');
        ?>
    </header>

    <main>
        <div class="container-fluid pb-5">
            <div class="row text-center">
                <img id="watchPhoto" src="images/watchdesktop.jpg" style="width: 100vw">
            </div>
        </div>

        <div class="container text-center">
            <h3 class="mb-5">Récapitulatif de votre commande</h3>
            <?php
            foreach ($_SESSION['cart'] as $chosenArticle) {
                echo "<div class=\"row text-center text-light align-items-center bg-dark p-3 justify-content-around mb-1\">
                                <img style=\"width: 50px\" src=\"images/" . $chosenArticle['picture'] . "\">
                                <p class=\"font-weight-bold\">" . $chosenArticle['name'] . "</p>
                                <p>" . $chosenArticle['description'] . "</p>
                                <p>" . $chosenArticle['price'] . " €</p>

                                <form class=\"row\" action=\"validation.php\" method=\"post\">
                                <input type=\"hidden\" name=\"modifiedArticleId\" value=\"" . $chosenArticle['id'] . "\">
                                <input class=\"col-2 offset-3\" type=\"text\" name=\"newQuantity\" value=\"" . $chosenArticle['quantity'] . "\">
                                <button type=\"submit\" class=\"col-5 offset-1 btn btn-light\">
                                    Modifier quantité
                                </button>
                                </form>

                                <form action=\"validation.php\" method=\"post\">
                                    <input type=\"hidden\" name=\"deletedArticle\" value=\"" . $chosenArticle['id'] . "\">
                                    <button type=\"submit\" class=\"btn btn-dark\">
                                        <i class=\"fas fa-ban\"></i>
                                    </button>
                                </form>
                              </div>";
            }
            ?>

            <div class="row text-dark justify-content-end font-weight-bold bg-light p-4">
                <?php
                getCartTotal();
                ?>
            </div>
            <?php if (!empty($_SESSION['cart']))
            {
                echo "<div class=\"row justify-content-center text-dark font-weight-bold bg-light p-4\">
                    <button type=\"button\" class=\"btn btn-dark\">Confirmer l'achat</button>
                </div>";
            }?>
        </div>

    </main>

    <?php
    include('./footer.php');
    ?>

</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

</html>