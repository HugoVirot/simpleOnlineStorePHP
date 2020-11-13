<?php

// ****************** récupérer la liste des articles **********************

function getArticles()
{

    $article1 = [
        'name' => 'Dark Watch',
        'id' => '1',
        'price' => 149.99,
        'description' => 'Moderne et élégante',
        'detailedDescription' => 'Designée par nos experts, elle impose son style partout où elle passe. 
                                  Elle allie le noir profond au plus beau bleu royal.
                                  Equipée d\'un altimètre, elle affiche également la météo.  
                                  Prix agressif et allure avant-gardiste : vous ne serez pas déçu.',
        'picture' => 'watch1.jpg'
    ];

    $article2 = [
        'name' => 'Classic Leather',
        'id' => '2',
        'price' => 229.49,
        'description' => 'Affiche l\'heure de 250 pays',
        'detailedDescription' => 'Une montre qui respire la maturité avec son superbe bracelet en cuir authentique. 
                                  Fonction incroyable permettant de consulter toutes les heures du globe.
                                  Elégance garantie avec son cadran cerclé d\'argent.
                                  Elle est destinée aux pères de famille qui aiment se faire plaisir.',
        'picture' => 'watch2.jpg'
    ];

    $article3 = [
        'name' => 'Silver Star',
        'id' => '3',
        'price' => 345.99,
        'description' => 'La classe à l\'état pur',
        'detailedDescription' => '100% acier inoxydable haute résistance. 
                                  Vous allez impressionner la galerie avec cette merveille !
                                  Aiguilles phosphorescentes et cadran incassable avec vitre en plexiglas.  
                                  N\'attendez plus et révélez le sportif en vous !',
        'picture' => 'watch3.jpg'
    ];

    $articles = array();

    array_push($articles, $article1);
    array_push($articles, $article2);
    array_push($articles, $article3);

    return $articles;
}



// ****************** afficher l'ensemble des articles **********************

function showArticles()
{
    $articles = getArticles();

    foreach ($articles as $article) {
        echo "<div class=\"card col-md-5 col-lg-3 p-3 m-3\" style=\"width: 18rem;\">
                <img class=\"card-img-top\" src=\"images/" . $article['picture'] . "\" alt=\"Card image cap\">
                <div class=\"card-body\">
                    <h5 class=\"card-title font-weight-bold\">" . $article['name'] . "</h5>
                    <p class=\"card-text font-italic\">" . $article['description'] . "</p>
                    <p class=\"card-text font-weight-light\">" . $article['price'] . " €</p>
                    <form action=\"product.php\" method=\"post\">
                        <input type=\"hidden\" name=\"articleToDisplay\" value=\"" . $article['id'] . "\">
                        <input class=\"btn btn-light\" type=\"submit\" value=\"Détails produit\">
                    </form>
                    <form action=\"panier.php\" method=\"post\">
                        <input type=\"hidden\" name=\"chosenArticle\" value=\"" . $article['id'] . "\">
                        <input class=\"btn btn-dark mt-2\" type=\"submit\" value=\"Ajouter au panier\">
                    </form>
                </div>
            </div>";
    }
}



// ****************** récupérer un article à partir de son id **********************

function getArticleFromId($id)
{

    $articles = getArticles();

    foreach ($articles as $article) {
        if ($article['id'] == $id) {
            $searchedArticle = $article;
            break;
        }
    }
    return $searchedArticle;
}



// ****************** afficher le détail d'un article sur la page produit **********************

function showArticleDetails($articleToDisplay)
{
    echo "<div class=\"container p-2\">
            <div class=\"row justify-content-center\">
                <img src=\"images/" . $articleToDisplay['picture'] . "\">
            </div>
          </div>

          <div class=\"container w-50 border border-dark bg-light mb-4\">
            <div class=\"row pt-5 text-center font-weight-bold align-items-center bg-light p-3 justify-content-center\">
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
            </div>
          </div>";
}



// ****************** ajouter un article au panier **********************

function addToCart($article)
{
    $isArticleAlreadyAdded = false;

    for ($i = 0; $i < count($_SESSION['cart']); $i++) {

        if ($_SESSION['cart'][$i]['id'] == $article['id']) {
            echo "<script> alert(\"Article déjà présent dans le panier !\");</script>";
            $isArticleAlreadyAdded = true;
        }
    }

    if (!$isArticleAlreadyAdded) {
        $article['quantity'] = 1;
        array_push($_SESSION['cart'], $article);
    }
}



// ****************** enlever un article au panier **********************

function removeToCart($articleId)
{

    for ($i = 0; $i < count($_SESSION['cart']); $i++) {
        if ($_SESSION['cart'][$i]['id'] == $articleId) {
            array_splice($_SESSION['cart'], $i, 1);
        }
    }
    echo "<script> alert(\"Article retiré du panier\");</script>";
}



// ************ modifier la quantité d'un article dans le panier ***********

function updateQuantity()
{

    $newQuantity = checkTypedQuantity();

    if (is_numeric($newQuantity)) {

        $modifiedArticleId = $_POST['modifiedArticleId'];

        for ($i = 0; $i < count($_SESSION['cart']); $i++) {

            if ($_SESSION['cart'][$i]['id'] == $modifiedArticleId) {
                $_SESSION['cart'][$i]['quantity'] = $newQuantity;
            }
        }
    }
}



// ************ afficher le contenu du panier ***********

function showCartContent($pageName)
{
    foreach ($_SESSION['cart'] as $chosenArticle) {
        echo "<div class=\"row text-center text-light align-items-center bg-dark p-3 justify-content-around mb-1\">
                        <img class=\"col-md-2\" style=\"width: 150px\" src=\"images/" . $chosenArticle['picture'] . "\">
                        <p class=\"font-weight-bold col-md-2\">" . $chosenArticle['name'] . "</p>
                        <p class=\"col-md-2\">" . $chosenArticle['description'] . "</p>
                        <p class=\"col-md-2\">" . $chosenArticle['price'] . " €</p>

                        <form class=\"col-lg-3\" action=\"" . $pageName . "\" method=\"post\">
                            <div class=\"row pt-2\">
                            <input type=\"hidden\" name=\"modifiedArticleId\" value=\"" . $chosenArticle['id'] . "\">
                            <input class=\"col-2 offset-2\" type=\"text\" name=\"newQuantity\" value=\"" . $chosenArticle['quantity'] . "\">
                            <button type=\"submit\" class=\"col-5 offset-1 btn btn-light\">
                                Modifier quantité
                            </button>
                            </div>
                        </form>

                        <form class=\"col-lg-1\" action=\"" . $pageName . "\" method=\"post\">
                            <input type=\"hidden\" name=\"deletedArticle\" value=\"" . $chosenArticle['id'] . "\">
                            <button type=\"submit\" class=\"btn btn-dark\">
                                <i class=\"fas fa-ban\"></i>
                            </button>
                        </form>
                      </div>";
    }
}



// ************ afficher les boutons "vider panier" et "valider la commande"  ***********

function showButtons()
{
    if ($_SESSION['cart']) {
        echo   "<form action=\"panier.php\" method=\"post\" class=\"row justify-content-center text-dark font-weight-bold p-2\">
                 <input type=\"hidden\" name=\"emptyCart\" value=\"true\">
                <button type=\"submit\" class=\"btn btn-danger\">Vider le panier</button>
            </form>
            <a href=\"validation.php\">
                <div class=\"row justify-content-center p-2\">
                    <button type=\"button\" class=\"btn btn-dark\">Valider la commande</button>
                </div>
            </a>";
    }
}


// ************vérifie que la quantité entrée est un nombre entre 1 et 10  ***********

function checkTypedQuantity()
{

    if (isset($_POST['newQuantity'])) {
        $typedQuantity = $_POST['newQuantity'];
    } else {
        $typedQuantity = null;
    }

    if (is_numeric($typedQuantity) && $typedQuantity >= 1 && $typedQuantity <= 9) {
        return $typedQuantity;
    } else {
        echo "<script> alert(\"Quantité saisie incorrecte !\");</script>";
    }
}



// ****************** calculer le total du panier **********************

function getCartTotal()
{
    $cartTotal = 0;

    if (isset($_SESSION['cart']) && count($_SESSION['cart']) !== 0) {

        foreach ($_SESSION['cart'] as $article) {
            $cartTotal += $article['price'] * $article['quantity'];
        }
        return $cartTotal;
    } else {
        echo "Votre panier est vide !";
    }
}


// ****************** afficher le total du panier **********************

function showCartTotal()
{
    $cartTotal = getCartTotal();
    if ($_SESSION['cart']) {
        $cartTotal = number_format($cartTotal, 2, ',', ' ');
        echo "Total des achats : " . $cartTotal . "€";
    }
}



// ****************** calculer le montant des frais de port (3€ / montre) **********************


function calculateShippingFees()
{
    $totalArticlesQuantity = 0;

    $cart = $_SESSION['cart'];

    for ($i = 0; $i < count($cart); $i++) {

        $totalArticlesQuantity += $cart[$i]['quantity'];
    }

    return  3 * $totalArticlesQuantity;
}



// ****************** calculer le montant total de la commande **********************

function calculateTotalPrice()
{
    $cartTotal = getCartTotal();
    $shippingFees = calculateShippingFees();
    return $cartTotal + $shippingFees;
}



// ****************** vider le panier **********************


function emptyCart($showConfirmation)
{
    $_SESSION['cart'] = [];

    if ($showConfirmation) {
        echo "<script> alert(\"Le panier a bien été vidé\");</script>";
    }
}
