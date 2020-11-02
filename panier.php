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
    emptyCart($showConfirmation = true);
}

// var_dump($_POST);

// var_dump($_SESSION['cart']);
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier - Arinfo, montres intemporelles</title>
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
                <img id="watchPhoto" src="images/watchdark.jpg" style="width: 100vw">
            </div>
        </div>

        <div class="container text-center">
            <h3 class="mb-5">Panier</h3>
            <?php
            foreach ($_SESSION['cart'] as $chosenArticle) {
                echo "<div class=\"row text-center text-light align-items-center bg-dark p-3 justify-content-around mb-1\">
                                <img class=\"col-md-2\" style=\"width: 150px\" src=\"images/" . $chosenArticle['picture'] . "\">
                                <p class=\"font-weight-bold col-md-2\">" . $chosenArticle['name'] . "</p>
                                <p class=\"col-md-2\">" . $chosenArticle['description'] . "</p>
                                <p class=\"col-md-2\">" . $chosenArticle['price'] . " €</p>

                                <form class=\"col-lg-3\" action=\"panier.php\" method=\"post\">
                                    <div class=\"row pt-2\">
                                    <input type=\"hidden\" name=\"modifiedArticleId\" value=\"" . $chosenArticle['id'] . "\">
                                    <input class=\"col-2 offset-2\" type=\"text\" name=\"newQuantity\" value=\"" . $chosenArticle['quantity'] . "\">
                                    <button type=\"submit\" class=\"col-5 offset-1 btn btn-light\">
                                        Modifier quantité
                                    </button>
                                    </div>
                                </form>

                                <form class=\"col-lg-1\" action=\"panier.php\" method=\"post\">
                                    <input type=\"hidden\" name=\"deletedArticle\" value=\"" . $chosenArticle['id'] . "\">
                                    <button type=\"submit\" class=\"btn btn-dark\">
                                        <i class=\"fas fa-ban\"></i>
                                    </button>
                                </form>
                              </div>";
            }
            ?>

            <div class="row justify-content-center text-dark font-weight-bold bg-light p-4">
                <?php
                $cartTotal = getCartTotal();
                if ($_SESSION['cart']) {
                    $cartTotal = number_format($cartTotal, 2, ',', ' ');
                    echo "Total des achats : " . $cartTotal . "€";
                }
                ?>
            </div>

            <?php if ($_SESSION['cart']) {
                echo   "<form action=\"panier.php\" method=\"post\" class=\"row justify-content-center text-dark font-weight-bold p-3\">
                             <input type=\"hidden\" name=\"emptyCart\" value=\"true\">
                            <button type=\"submit\" class=\"btn btn-danger\">Vider le panier</button>
                        </form>
                        <a href=\"validation.php\">
                            <div class=\"row justify-content-center p-4\">
                                <button type=\"button\" class=\"btn btn-dark\">Valider la commande</button>
                            </div>
                        </a>";
            } ?>

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