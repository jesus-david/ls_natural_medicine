<?php 

    $items = isset($_SESSION["carrito"]) ? $_SESSION["carrito"] : [];
?>

<div class="py-1" style="background: #113169;">
    <div class="container">
        <div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
            <div class="col-lg-12 d-block">
                <div class="row d-flex">
                    <div class="col-md pr-4 d-flex topper align-items-center">
                        <div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>
                        <span class="text">+ 1235 2355 98</span>
                    </div>
                    <div class="col-md pr-4 d-flex topper align-items-center">
                        <div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
                        <span class="text">youremail@email.com</span>
                    </div>
                    <div class="col-md-5 pr-4 d-flex topper align-items-center text-lg-right">
                        <!-- <span class="text">3-5 Business days delivery &amp; Free Returns</span> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="index">LS NATURAL MEDICINE</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>
        
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php echo (isset($_GET['action']) && $_GET['action'] == 'index') ? 'active' : '' ?>"><a href="index" class="nav-link">Inicio</a></li>
                <li class="nav-item dropdown <?php echo (isset($_GET['action']) && $_GET['action'] == 'shop') ? 'active' : '' ?>">

                    <a href="shop" class="nav-link">Tienda</a>

                    <!-- <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tienda</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown04">
                        <a class="dropdown-item" href="shop">Shop</a>
                        <a class="dropdown-item" href="wishlist.html">Wishlist</a>
                        <a class="dropdown-item" href="product-single.html">Single Product</a>
                        <a class="dropdown-item" href="cart.html">Cart</a>
                        <a class="dropdown-item" href="checkout.html">Checkout</a>
                    </div> -->
                </li>
                <li class="nav-item <?php echo (isset($_GET['action']) && $_GET['action'] == 'about') ? 'active' : '' ?>">
                    <a href="about" class="nav-link">Sobre nosotros</a>
                </li>
                <li class="nav-item <?php echo (isset($_GET['action']) && $_GET['action'] == 'contact') ? 'active' : '' ?>"><a href="contact" class="nav-link">Contacto</a></li>

                <?php if (isset($_SESSION["logged"])) { ?>

                    <li class="nav-item <?php echo (isset($_GET['action']) && $_GET['action'] == 'profile') ? 'active' : '' ?>" >
                        <a class="nav-link" href="profile">
                            <span class="icon-user"></span>
                            Mi Cuenta
                        </a>

                    </li>
                    <li class="nav-item cta cta-colored">
                        <a href="cart" class="nav-link">
                            <span class="icon-shopping_cart"></span>
                            [<span class="num_items_cart"><?php echo count($items) ?></span>]
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cerrarSesion" style="text-decoration: underline;">Salir</a>
                    </li>
                    <?php } ?>
                <?php if (!isset($_SESSION["logged"])) { ?>

                    <li class="nav-item <?php echo (isset($_GET['action']) && $_GET['action'] == 'registro') ? 'active' : '' ?>">
                        <a class="nav-link" href="registro">Registrate</a>
                    </li>

                    <li class="nav-item <?php echo (isset($_GET['action']) && $_GET['action'] == 'login') ? 'active' : '' ?>" >
                        <a class="nav-link route" href="login">Ingresar</a>
                    </li>

                <?php } ?>
                
                
            </ul>
        </div>
    </div>
</nav>