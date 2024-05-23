<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* div.productlist{
            width: 80%;

        } */

    </style>
</head>
<body>
    <main>
        <div id="display" class="container">
            <img class="homepageimg" src="images/homepage-img2.jpg" alt="liquor">
            <div class="bottom-left">
                <p>Welcome to Our Store</p>
                <h1>Shop Our Amazing Selection of Liquor</h1>
                <button id="shopnow" onclick="document.getElementById('pop_products').scrollIntoView()">Shop Now</button>
            </div>
        </div>

        <!-- <div>
            <h2 id="pop_products">Popular Products</h2>
            <div id="popular_products">
            </div>
        </div> -->
        <div class="productlist" id="pop_products" >
            <div>
                <h2>Vodka <a href="vodka.php">(View all)</a></h2>
                <div id="vodkaList">
                    <!-- Product list will be displayed here -->
                    <?php include 'vodkaList.php'; ?>

                </div>
            </div>
            <div>
                <h2>Whiskey <a href="whiskey.php">(View all)</a></h2>
                <div id="whiskeyList">
                    <!-- Product list will be displayed here -->
                    <?php include 'whiskeyList.php'; ?>

                </div>
            </div>
            <div>
                <h2>Rum <a href="rum.php">(View all)</a></h2>
                <div id="rumList">
                    <!-- Product list will be displayed here -->
                    <?php include 'rumList.php'; ?>

                </div>
            </div>
            <div>
                <h2>Beer <a href="beer.php">(View all)</a></h2>
                <div id="beerList">
                    <!-- Product list will be displayed here -->
                    <?php include 'beerList.php'; ?>

                </div>
            </div>
            <div>
                <h2>Wine <a href="wine.php">(View all)</a></h2>
                <div id="wineList">
                    <!-- Product list will be displayed here -->
                    <?php include 'wineList.php'; ?>

                </div>
            </div>
        </div>


        <!-- <div id="productList">
             Product list will be displayed here 
        </div> -->

    </main>
</body>
</html>