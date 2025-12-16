<?php
session_start();
require "../database/query.php";
$user = $_SESSION['user_id'];
$id_produk = $_GET['product_id'];
if(isset($_POST['kirim'])){
    $rating_value = $_POST['rating'] ? intval($_POST['rating']) : 0;
    $komen = $_POST['komen'];

    addReview($rating_value, $komen, $user, $id_produk);
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan Pengguna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #dc3545;
        }

        select, button, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #dc3545;
            border-radius: 5px;
            font-size: 14px;
            color: #dc3545;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        button {
            background-color: #dc3545;
            color: white;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 14px;
            border: none;
        }

        button:hover {
            background-color: #c82333;
        }

        .star-rating {
            display: flex;
            justify-content: flex-end;
            flex-direction: row-reverse;
            gap: 5px;
            cursor: pointer;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            font-size: 30px;
            color: #ddd;
            transition: color 0.3s;
        }

        star-rating input:checked ~ label {
            color: #dc3545; /* Warna bintang yang terisi */
        }

        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #dc3545; /* Sorot bintang saat hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Formulir untuk memberikan rating -->
        <div class="rate-review">
            <form method="POST" action="">
                <label for="rating">Pilih Rating:</label>
                <div class="star-rating">
                    <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
                    <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
                    <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
                    <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
                    <input type="radio" id="star5" name="rating" value="5"><label for="star5">★</label>
                </div>

                <label for="komen">Komentar Anda:</label>
                <textarea name="komen" id="komen" placeholder="Tulis komentar Anda di sini..."></textarea>

                <button type="submit" name="kirim">Kirim Rating</button>
            </form>
        </div>
    </div>
</body>
</html>
