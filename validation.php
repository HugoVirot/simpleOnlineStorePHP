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

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valider la commande - Arinfo, montres intemporelles</title>
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

        <div class="container text-center mb-3">
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
                $cartTotal = getCartTotal();
                if ($_SESSION['cart']) {
                    $cartTotal = number_format($cartTotal, 2, ',', ' ');
                    echo "Total des achats : " . $cartTotal . "€";
                }
                ?>

            </div>

            <div class="row text-dark justify-content-end font-weight-bold bg-light p-4">
                <?php
                if ($_SESSION['cart']) {
                    $shippingFees = calculateShippingFees();
                    $shippingFees = number_format($shippingFees, 2, ',', ' ');
                    echo "Frais de port (3,00 € par montre) : " . $shippingFees . "€";
                }
                ?>
            </div>

            <div class="row text-dark justify-content-end font-weight-bold bg-light p-4">
                <?php
                if ($_SESSION['cart']) {
                    $totalPrice = calculateTotalPrice();
                    $totalPrice = number_format($totalPrice, 2, ',', ' ');
                    echo "<h5>TOTAL A PAYER : " . $totalPrice . "€</h5>";
                }
                ?>
            </div>

            <?php if (!empty($_SESSION['cart'])) {
                echo "<div class=\"row justify-content-center text-dark font-weight-bold bg-light p-4\">
                    <button type=\"button\" class=\"btn btn-dark\" data-toggle=\"modal\" data-target=\"#confirmation\">Confirmer l'achat</button>
                </div>";
            } ?>

            <!-- Modal -->
            <div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="confirmation" aria-hidden="true">
                <div class="modal-dialog" role="document" pointer-events="all">
                    <div class="modal-content">
                        <div class="modal-header text-light bg-dark text-center">
                            <h5 class="modal-title text-center" id="exampleModalLabel">Félicitations !</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h4 class="text-success mt-3">Votre commande a été validée.</h4><br>
                            <br>
                            <h5>Montant total : <?php echo $totalPrice ?> €</h5><br>
                            <br>
                            Elle sera expédiée le <span class="font-weight-bold"><?php
                                                                                    echo date('d-m-Y', strtotime(date('d-m-Y') . ' + 3 days')); ?></span><br>
                            <br>
                            Merci pour votre confiance.
                        </div>
                        <div class="modal-footer">
                            <form action="index.php" method="post">
                                <input type="hidden" name="orderValidated" value="true">
                                <input type="submit" class="btn btn-secondary" value="Retour à l'accueil">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <?php
    include('./footer.php');
    ?>

</body>
<script>

</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

</html>