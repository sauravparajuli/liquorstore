



<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="newstyles.css">
    <script src="https://kit.fontawesome.com/17561cd3bf.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <header class="header" id="myHeader">
        <ul>
            <!-- <li><a href="index.php"><img src="images/logo.png" alt="" height="100px" width="100px" ></a></li> -->
            <li><a href="index.php"><i class="fa-solid fa-wine-bottle fa-2xl"></i></a></li>
            <li><div class="dropdown">
                    <a href="" class="dropbtn">Categories</a>
                    <div class="dropdown-content">
                        <a href="vodka.php">Vodka</a>
                        <a href="whiskey.php">Whiskey</a>
                        <a href="rum.php">Rum</a>
                        <a href="beer.php">Beer</a>
                        <a href="wine.php">Wine</a>
                    </div>
                </div>
            </li>
            <!-- <li><a href="admin/addcategory.php">Add Product</a></li>
            <li><a href="admin/removeproduct.php">Remove Product</a></li>
            <li><a href="admin/outofstock.php">Out of Stock</a></li>
            <li><a href="admin/restock.php">Restock</a></li> -->


            <li>
                <form action="search.php" method="post">
                    <input type="text" name="search_term" placeholder="Search for products...">
                    <button name="search" type="sumbit" >Search</button>
                </form>
            </li>

            <li><a href="cart.php"><i class="fa-solid fa-cart-shopping fa-xl"></i></a></li>
            <li><a href="orders.php">Orders</a></li>

            <li><div class="dropdown">
                <a href="" class="dropbtn"><i class="fa-solid fa-user fa-xl"></i></a>
                <div class="dropdown-content">
                    <a href="logout.php">Logout</a>
                    <a href="#">Unnamed</a>
                </div>
            </li>
        </ul>
        <!-- <h1>JhyapMandu</h1>
        <input type="text" id="searchInput" placeholder="Search for products...">
        <button onclick="searchProducts()">Search</button> -->
    </header>
</body>
</html>