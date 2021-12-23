<?php
session_start();
include('functions.php');
createCart();

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
        <?php
        if (isset($_POST['articleToDisplay'])) {
            $articleToDisplayId = $_POST['articleToDisplay'];
            $articleToDisplay = getArticleFromId($articleToDisplayId);
            showArticleDetails($articleToDisplay);
        }
        ?>
    </main>

    <?php
    include('./footer.php');
    ?>

</body>

</html>