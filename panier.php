<?php
session_start();
include('functions.php');
createCart();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

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

if (isset($_POST['emptyCart'])) {
    emptyCart(true);
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
        include('header.php')
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
            showCartContent("panier.php")
            ?>

            <div class="row justify-content-center text-dark font-weight-bold bg-light p-4">
                <?php
                    showCartTotal();
                ?>
            </div>

            <?php
            showButtons();
            ?>

        </div>

    </main>

    <?php
    include('./footer.php');
    ?>

</body>

</html>