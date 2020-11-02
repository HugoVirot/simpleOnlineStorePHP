<?php
session_start();

include('functions.php');

if (isset($_POST['articleToDisplay'])) {

    $articleToDisplayId = $_POST['articleToDisplay'];
    $articleToDisplay = getArticleFromId($articleToDisplayId);
}
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arinfo, montres intemporelles - <?php?></title>
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
        <div class="container p-5">
            <div class="row justify-content-center">
                <img src="images/<?php echo $articleToDisplay['picture'] ?>">
            </div>
        </div>

        <div class="container w-50 border border-dark bg-light mb-4">

            <?php
            echo "<div class=\"row pt-5 text-center font-weight-bold align-items-center bg-light p-3 justify-content-center\">
                                <h2>" . $articleToDisplay['name'] . "</h2>
                        </div>
                      <div class=\"row text-center font-italic align-items-center bg-light p-3 justify-content-center\">
                                <h5>" . $articleToDisplay['description'] . "<h5>
                      </div>
                      <div class=\"row text-center align-items-center bg-light p-3 ml-5 mr-5 justify-content-center\">
                      <p>" . $articleToDisplay['detailedDescription'] . "<p>
                     </div>
                      <div class=\"row text-center font-weight-light align-items-center bg-light p-3 justify-content-center\">    
                                <h4>" . $articleToDisplay['price'] . " €</h4>
                      </div>
                      <div class=\"row pb-5 text-center align-items-center bg-light p-3 justify-content-center\"> 
                             <form action=\"panier.php\" method=\"post\">
                                <input type=\"hidden\" name=\"chosenArticle\" value=\"" . $articleToDisplay['id'] . "\">
                                <input class=\"btn btn-dark mt-2\" type=\"submit\" value=\"Ajouter au panier\">
                             </form>
                      </div>";
            ?>

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