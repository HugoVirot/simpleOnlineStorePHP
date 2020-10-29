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
        'description' => 'affiche l\'heure de 250 pays',
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


// ****************** récupérer un article à partir de son id **********************

function getArticleFromId($id){

    $articles = getArticles();
    
    foreach ($articles as $article)
    {
        if ($article['id'] == $id)
        {
            $searchedArticle = $article;
            break;
        }
    }
    return $searchedArticle;
}


// ****************** ajouter un article au panier **********************

function addToCart($article){

    array_push($_SESSION['cart'],$article);

}


// ****************** calculer le total du panier **********************

function getCartTotal()
{
    $cartTotal = 0;

    if (isset($_SESSION['cart'])) {

        foreach ($_SESSION['cart'] as $article) {
            $cartTotal += $article['price'];
        }
        echo "Total à payer : " . $cartTotal . "€";
    } else {
        echo "Votre panier est vide";
    }
}


// ****************** vider le panier **********************


function emptyCart()
{

    $_SESSION = [];

}
