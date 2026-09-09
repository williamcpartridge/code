<?php

session_start();
require_once 'config.php';

$rows = $conn->query("SELECT * FROM shop_items");
$selected_catagory = $_POST['catagory'] ?? '';

$empty = FALSE;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="images/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>RockHub</title>
</head>
<body>  
    <div class="header">
        <h1>Rock</h1>
        <h1 style="color: orange;">Hub</h1>
        <a href="profile_check.php"><img style="width: 60px; height: 60px; float: right; margin: 20px; margin-right: 50px;" src="images/profile-2.png" alt="Profile Image"></a>
    </div>

    <nav class="nav">
        <a href="home.php">HOME</a>
        <a href="about.php">ABOUT US</a>
        <a id='active-site' href="shop.php">SHOP</a>
        <a href="explore.php">EXPLORE</a>
    </nav>

    <div class='grid'>
        <div class='box' id='filter'>
            <form action="" method="post">
                <h2>Filter</h2>
                <p>Catagory:</p>
                <select name="catagory">
                    <option value="">All</option>
                    <option value="gear" <?= ($selected_catagory === 'gear') ? 'selected' : ''; ?>>Gear</option>
                    <option value="resource" <?= ($selected_catagory === 'resource') ? 'selected' : ''; ?>>Resources</option>
                </select>
                <button type="submit" name="save">Save</button>
            </form>
        </div>

        <div>
            <h1 id='title'>Shop</h1>
            <div class='box' id='shop-container'>
                <?php

                foreach ($rows as $row) {
                    if ($selected_catagory !== '') {
                        if ($row['catagory'] === $selected_catagory) {
                            $name = $row['item-name'];
                            $cost = "$" . $row['cost'];
                            $img = "<img src='" . $row['img-src'] . "'>";
                            $stock = ($row['stock'] > 0) ? "<span id='green'>In Stock</span>" : "<span id='red'>Out of Stock</span>";
            
                            echo "<div class='merch'>" . $name . "&nbsp;&nbsp;-&nbsp;&nbsp;" . $cost . $img . $stock . "</div>";
                            $empty = TRUE;
                        }
                    } else {
                        $name = $row['item-name'];
                        $cost = "$" . $row['cost'];
                        $img = "<img src='" . $row['img-src'] . "'>";
                        $stock = ($row['stock'] > 0) ? "<span id='green'>In Stock</span>" : "<span id='red'>Out of Stock</span>";

                        echo "<div class='merch'>" . $name . "&nbsp;&nbsp;-&nbsp;&nbsp;" . $cost . $img . $stock . "</div>";
                        $empty = TRUE;
                    }

                }

                if ($empty === FALSE) {
                    echo "<h1>Sorry no results found :(</h1>";
                }

                ?>
            </div>
        </div>
    </div>

</body>
<footer>
    <div>
        <p>&copy; RockHub, inc.<br><br>Contact:&nbsp;&nbsp;info@rockhub.co.nz<br><br>Website by William Partridge</p>
        <ul>
            <li><a href="account.php">NAVIGATE:</a></li>
            <li><a href="home.php">HOME</a></li>
            <li><a href="about.php">ABOUT US</a></li>
            <li><a href="shop.php">SHOP</a></li>
            <li><a href="explore.php">EXPLORE</a></li>
        </ul>
        <ul>
            <li><a href="home.php">SOCIAL MEDIA:</a></li>
            <li><a href="shop.php">FACBOOK</a></li>
            <li><a href="about.php">INSTAGRAM</a></li>
            <li><a href="account.php">REDIT</a></li>
            <li><a href="explore.php">DISCORD</a></li>
        </ul>
    </div>
</footer>
</html>