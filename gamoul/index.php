<!DOCTYPE html>
<html>
    <head>
        <title>Gamoul.fr</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/header.css">

        <style>
            .badge-notify{
                background:#FB8348;
                position:relative;
                top: -20px;
                right: 10px;
            }
            .my-cart-icon-affix {
                position: fixed;
                z-index: 999;
            }
        </style>
    </head>
    <body>
    <div class="header mb-50">
        <span class="logo"><a href="index.php"><img src="images/logo_gamoul.png" width="280"></a></span>
        <input type="checkbox" id="chk">
        <label for="chk" class="show-menu-btn">
            <i class="fas fa-ellipsis-h">+</i>
        </label>

        <ul class="menu">
            <a href="index.php">Accueil</a>
            <a href="register.php">Inscription</a>
            <a href="login.php">Connexion</a>
            <a href="login.php">Espace Admin</a>
            <label for="chk" class="hide-menu-btn">
                <i class="fas fa-times">x</i>
            </label>
        </ul>
    </div>


        <div class="container site">
            <!--<h1 class="text-logo"><img src="images/logo_gamoul.png" width="500"></h1>-->
            <!-- <span><a href="admin/index.php">Espace Admin</a></span> -->

            <?php
				require 'admin/database.php';

				// MENU
                echo '<nav>
                        <ul class="nav nav-pills">';

                $db = Database::connect();
                $statement = $db->query('SELECT * FROM categories');
                $categories = $statement->fetchAll();
                foreach ($categories as $category)
                {
                    if($category['id'] == '1')
                        echo '<li role="presentation" class="active"><a href="#'. $category['id'] . '" data-toggle="tab">' . $category['name'] . '</a></li>';
                    else
                        echo '<li role="presentation"><a href="#'. $category['id'] . '" data-toggle="tab">' . $category['name'] . '</a></li>';
                }

                echo '<li>             
                        <div style="float: right; cursor: pointer;">
                            <h4><span class="glyphicon glyphicon-shopping-cart my-cart-icon"><span class="badge badge-notify my-cart-badge"></span></span></h4>
                        </div> 
                      </li>';
                echo    '</ul>
                      </nav>';
                // FIN MENU

                echo '<div class="tab-content">';

                foreach ($categories as $category) 
                {
                    if($category['id'] == '1')
                        echo '<div class="tab-pane active" id="' . $category['id'] .'">';
                    else
                        echo '<div class="tab-pane" id="' . $category['id'] .'">';
                    
                    echo '<div class="row">';
                    
                    $statement = $db->prepare('SELECT * FROM items WHERE items.category = ?');
                    $statement->execute(array($category['id']));
                    while ($item = $statement->fetch()) 
                    {
                        echo '<div class="col-sm-6 col-md-4">
                                <div class="thumbnail">
                                    <img src="images/' . $item['image'] . '" alt="...">
                                    <div class="price">' . number_format($item['price'], 2, '.', ''). ' €</div>
                                    <div class="caption">
                                        <h4>' . $item['name'] . '</h4>
                                        <p>' . $item['description'] . '</p>
                                              <button class="btn btn-order my-cart-btn" data-id="'. $item['id'] .'" data-name="'. $item['name'] .'" data-price="'. $item['price'] .'" data-quantity="1" data-image="images/'. $item['image'] .'" >
                                              <span class="glyphicon glyphicon-shopping-cart"></span> Commander</button>
                                    </div>
                                </div>
                            </div>';
                    }
                   
                   echo    '</div>
                        </div>';
                }
                Database::disconnect();
                echo  '</div>';
            ?>
        </div>
    </body>
    <script src="js/jquery-2.2.3.min.js"></script>
    <script type='text/javascript' src="js/bootstrap.min.js"></script>
    <script type='text/javascript' src="js/jquery.mycart.js"></script>
    <script type="text/javascript">
        $(function () {

            var goToCartIcon = function($addTocartBtn){
                var $cartIcon = $(".my-cart-icon");
                var $image = $('<img width="30px" height="30px" src="' + $addTocartBtn.data("image") + '"/>').css({"position": "fixed", "z-index": "999"});
                $addTocartBtn.prepend($image);
                var position = $cartIcon.position();
                $image.animate({
                    top: position.top,
                    left: position.left
                }, 500 , "linear", function() {
                    $image.remove();
                });
            }

            $('.my-cart-btn').myCart({
                currencySymbol: '€',
                classCartIcon: 'my-cart-icon',
                classCartBadge: 'my-cart-badge',
                classProductQuantity: 'my-product-quantity',
                classProductRemove: 'my-product-remove',
                classCheckoutCart: 'my-cart-checkout',
                affixCartIcon: true,
                showCheckoutModal: true,
                numberOfDecimals: 2,
                clickOnAddToCart: function($addTocart){
                    goToCartIcon($addTocart);
                }
            });
        });
    </script>
</html>