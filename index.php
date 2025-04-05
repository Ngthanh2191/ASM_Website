<?php
include 'db.php'; 

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Ceramic Shop</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="wrapper">
        <div class="header">
            <div class="logo">
                <img id="logo" src="./images/gom.png" alt="Logo">
            </div>
            <div class="form-search">
                <form action="">
                    <input type="text" placeholder="Search for products...">
                    <button type="submit">Search</button>
                </form>
            </div>
        </div>

        <div class="menu">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="product.php">Add Product</a></li>
                <li><a href="#">My Account</a></li>
                <li><a href="#">Cart</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="content">
            <div class="left">
                <div class="category">
                    <h3>Product Categories</h3>
                    <ul>
                        <li><a href="banchaynhat.html">Best Sellers</a></li>
                    </ul>
                </div>
                <div class="brand">
                    <h3>Brands</h3>
                    <ul>
                        <li><a href="gomsubattrang.html">Bat Trang Ceramics</a></li>
                        <li><a href="gomsuminhlong.html">Minh Long Ceramics</a></li>
                        <li><a href="gomsudongtrieu.html">Dong Trieu Ceramics</a></li>
                    </ul>
                </div>
            </div>

            <div class="right">
                <h2>Product List</h2>
                <div class="product">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <div class="single-product">
                            <h3><?php echo $row['name']; ?></h3>
                            <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                            <p>Price: <?php echo number_format($row['price'], 0, ',', '.'); ?>₫</p>
                            <a href="#">View Details</a>
                            <button>Add to Cart</button>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>&copy; 2025 Ceramic Shop - Van Thanh</p>
        </div>
    </div>
</body>
</html>
