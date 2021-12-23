<?php
session_start();
include('functions.php');
createCart();

if (isset($_POST['orderValidated'])) {
    emptyCart(false);
    unset($_SESSION['delivery']);
}
?>

<!DOCTYPE html>

<html lang="fr">


<?php
include('./head.php');
?>

<body>

    <?php
    include('./header.php');
    ?>

    <main>
        <div class="container-fluid pb-3">
            <div class="row text-center">
                <img id="watchPhoto" src="images/watch.jpg" style="width: 100vw">
            </div>
        </div>

        <div class="container p-5">
            <div class="row text-center justify-content-center">
                <?php
                showArticles();
                ?>
            </div>
        </div>

    </main>

    <?php
    include('./footer.php');
    ?>

</body>


</html>