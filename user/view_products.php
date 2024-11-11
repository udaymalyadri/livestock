<?php
// Include the user header file
include('user_header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h1, h2 {
            margin: 0;
        }

        /* Product List Hero Section */
        .hero {
            background-image: url('../landingpage/images/banner_1.jpg'); /* Replace with a relevant image path */
            background-size: cover;
            background-position: center;
            text-align: center;
            padding: 100px 20px;
            color: #fff;
        }
        .hero h1 {
            font-size: 3em;
            margin-bottom: 20px;
        }
        .hero p {
            font-size: 1.2em;
            margin-bottom: 40px;
        }
        .hero .cta-btn {
            padding: 10px 20px;
            background-color: #ff7f00;
            border: none;
            color: white;
            font-size: 1em;
            cursor: pointer;
            text-transform: uppercase;
        }
        .hero .cta-btn:hover {
            background-color: #e67e00;
        }

        /* Cart Icon */
        .cart-icon {
            position: fixed;
            top: 20px;
            right: 20px;
            font-size: 2em;
            color: #ff7f00;
            cursor: pointer;
            z-index: 1000;
        }
        .cart-icon i {
            position: relative;
        }
        .cart-icon span {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: red;
            color: white;
            border-radius: 50%;
            font-size: 0.8em;
            padding: 3px 8px;
        }

        /* Product Grid */
        .container {
            max-width: 1200px;
            margin: 20px auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 0 20px;
        }
        .product-card {
            background-color: #fff;
            text-align: center;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }
        .product-card h3 {
            font-size: 1.2em;
            margin: 10px 0;
            color: #333;
        }
        .product-card p {
            font-size: 1em;
            color: #666;
            margin: 5px 0;
        }
        .product-card .price {
            font-size: 1.2em;
            font-weight: bold;
            margin: 15px 0;
            color: #ff7f00;
        }
        .product-card button {
            padding: 8px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 1em;
        }
        .product-card button:hover {
            background-color: #218838;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        /* Footer */
        .footer {
            background-color: #000;
            color: white;
            text-align: center;
            padding: 20px 0;
            width: 100%;
            bottom: 0;
        }

    </style>
</head>
<body>
    <!-- Cart Icon -->
    <div class="cart-icon" id="cartIcon">
        <i class="fas fa-shopping-cart"></i>
        <span id="cartCount">0</span>
    </div>

    <!-- Hero Section -->
    <div class="hero">
        <h1>Explore Our Products</h1>
        <p>Find the best livestock and products for your farm</p>
        <button class="cta-btn">Shop Now</button>
    </div>

    <!-- Product List Section -->
    <div class="container" id="product-container">
        <!-- Products will be dynamically inserted here -->
    </div>

    <!-- Footer Section -->
    <div class="footer">
        <p>&copy; 2024 CattleCart. All Rights Reserved.</p>
    </div>

    <script>
        let cart = [];

        // Fetch products from the backend when the page loads
        window.onload = function() {
            fetchProducts();
        };

        // Function to fetch products from backend
        function fetchProducts() {
            fetch('get_products.php')
                .then(response => response.json())
                .then(products => {
                    if (products.error) {
                        console.error(products.error);
                    } else {
                        displayProducts(products);
                    }
                })
                .catch(error => console.error('Error fetching products:', error));
        }

        // Function to dynamically display products
        function displayProducts(products) {
            const container = document.getElementById('product-container');
            container.innerHTML = ''; // Clear any existing content

            products.forEach(product => {
                const productCard = document.createElement('div');
                productCard.classList.add('product-card');
                productCard.setAttribute('data-id', product.id);

                const productImage = document.createElement('img');
                productImage.src = product.image; // Assuming the 'image' field contains the image URL
                productImage.alt = product.name;
                productCard.appendChild(productImage);

                const productTitle = document.createElement('h3');
                productTitle.textContent = product.name;
                productCard.appendChild(productTitle);

                const productPrice = document.createElement('p');
                productPrice.classList.add('price');
                productPrice.textContent = `$${product.price}`;
                productCard.appendChild(productPrice);

                const productDescription = document.createElement('p');
                productDescription.textContent = product.description;
                productCard.appendChild(productDescription);

                const addToCartButton = document.createElement('button');
                addToCartButton.textContent = 'Add to Cart';
                addToCartButton.onclick = function() {
                    addToCart(product.id, product.name, product.price);
                };
                productCard.appendChild(addToCartButton);

                container.appendChild(productCard);
            });
        }

        // Add item to cart
        function addToCart(id, name, price) {
            const product = { id, name, price, quantity: 1 };
            cart.push(product);
            updateCartCount();
            updateBackend();
        }

     
        // Update the cart in the backend (simulate with console.log)
        function updateBackend() {
            // Simulate sending data to the backend
            console.log("Cart updated:", cart);
            // Here you would typically make an AJAX call to update the backend
            // Example:
            // fetch('/update_cart.php', { method: 'POST', body: JSON.stringify(cart) });
        }
    </script>
</body>
</html>
