<?php
?>
<!doctype html>
<html>

<header>
    <div class="container-fluid text-center">
        <h1 class="pt-5">Arinfo</h1>
        <h4 class="font-weight-light pt-1 pb-5">Montres intemporelles</h2>
            <nav class="navbar navbar-expand-md navbar-light bg-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php">Accueil<span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="panier.php">Panier (<span><?php echo count($_SESSION['cart']) ?></span>)
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
    </div>
</header>

</html>

<!-- <span id="totalCost"> 
   <?php
    // if (isset($_SESSION['panier']))
    // {
    //     $cartTotal = number_format(cartTotal(), 2, ',', ' ');
    //     echo $cartTotal . "€";
    //  }
    ?>
            </span> -->