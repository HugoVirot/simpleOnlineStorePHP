<?php

// ****************** récupérer la liste des articles **********************

function getArticles()
{

    $article1 = [
        'name' => 'Dark Watch',
        'id' => '1',
        'price' => 150,
        'description' => 'Moderne et élégante',
        'picture' => 'watch1.jpg'
    ];

    $article2 = [
        'name' => 'Classic Leather',
        'id' => '2',
        'price' => 200,
        'description' => 'Affiche l\'heure de 250 pays',
        'picture' => 'watch2.jpg'
    ];

    $article3 = [
        'name' => 'Silver Star',
        'id' => '3',
        'price' => 350,
        'description' => 'Bracelet acier inoxydable',
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
        echo "<div class=\"card col-md-3 p-3 m-3\" style=\"width: 18rem;\">
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



// ****************** ajouter un article au panier **********************

function addToCart($article)
{

    array_push($_SESSION['cart'], $article);
}



// ****************** enlever un article au panier **********************

function removeToCart($articleId)
{

    for ($i = 0; $i < count($_SESSION['cart']); $i++) {
        if ($_SESSION['cart'][$i]['id'] == $articleId) {
            array_splice($_SESSION['cart'], $i, 1);
        }
    }
}



// ****************** calculer le total du panier **********************

function getCartTotal()
{
    $cartTotal = 0;

    if (isset($_SESSION['cart']) && count($_SESSION['cart']) !== 0) {

        foreach ($_SESSION['cart'] as $article) {
            $cartTotal += $article['price'];
        }
        echo "Total à payer : " . $cartTotal . "€";
    } else {
        echo "Votre panier est vide !";
    }
}



// ****************** vider le panier **********************


function emptyCart()
{
    $_SESSION['cart'] = [];
}
