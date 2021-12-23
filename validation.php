<?php
session_start();
include('functions.php');
createCart();

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

if (isset($_POST['delivery'])) {
    $_SESSION['delivery'] = $_POST['delivery'];
}
?>

<!DOCTYPE html>

<html lang="en">

<?php
include('./head.php');
?>

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
            showCartContent("validation.php")
            ?>

            <div class="row text-dark justify-content-center font-weight-bold bg-light p-4">
                <?php
                showCartTotal();
                ?>

            </div>

            <div class="row text-dark justify-content-center font-weight-bold bg-light p-4">
                <?php
                if ($_SESSION['cart']) {
                    $shippingFees = calculateShippingFees();
                    $shippingFees = number_format($shippingFees, 2, ',', ' ');
                    echo "Frais de port (3,00 € par montre) : " . $shippingFees . "€";
                }
                ?>
            </div>

            <div>
                <h3 class="p-3">Type de livraison</h3>
                <form method="post" action="validation.php">
                    <div class="form-group">
                        <input type="radio" name="delivery" id="domicile" value="domicile" <?php if (isset($_SESSION['delivery']) && $_SESSION['delivery'] === "domicile") { ?> checked <?php } ?>>
                        <label for="classique">à domicile: 10 €</label>
                    </div>
                    <div class="form-group">
                        <input type="radio" name="delivery" id="pointrelais" value="pointrelais" <?php if (isset($_SESSION['delivery']) && $_SESSION['delivery'] === "pointrelais") { ?> checked <?php } ?>>
                        <label for="classique">en point-relais : 5 €</label>
                    </div>
                    <button type="submit" class="btn btn-info mb-3">Valider</button>
                </form>
            </div>

            <div class="row text-dark justify-content-center font-weight-bold bg-light p-4">
                <?php
                if ($_SESSION['cart']) {
                    $totalPrice = calculateTotalPrice();

                    if (isset($_SESSION['delivery'])) {
                        if ($_SESSION['delivery'] === "domicile") {
                            $totalPrice += 10;
                        } else {
                            $totalPrice += 5;
                        }
                    }

                    $totalPrice = number_format($totalPrice, 2, ',', ' ');
                    echo "<h5>TOTAL A PAYER : " . $totalPrice . "€</h5>";
                }
                ?>
            </div>

            <?php if (!empty($_SESSION['cart']) && isset($_SESSION['delivery'])) {
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

                            Elle sera expédiée le
                            <span class="font-weight-bold">
                                <?php
                                // date version 1 : affichée ainsi : 6 juin 2021
                                setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
                                $date = date("Y-m-d");
                                echo utf8_encode(strftime("%A %d %B %Y", strtotime($date . " + 2 days")));
                                // date version 2 : date affichée ainsi : 06-06-2021
                                // echo date('d-m-Y', strtotime(date('d-m-Y') . ' + 3 days')); 
                                ?>
                            </span><br><br>

                            Livraison prévue le
                            <span class="font-weight-bold">
                                <?php echo utf8_encode(strftime("%A %d %B %Y", strtotime($date . " + 9 days"))); ?>
                            </span><br><br>
                            Merci pour votre confiance.
                        </div>
                        <div class="modal-footer mt-3">
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

</html>