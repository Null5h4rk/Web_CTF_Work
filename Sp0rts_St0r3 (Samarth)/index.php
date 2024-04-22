<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Store</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 500px;
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        header {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        header h1 {
            margin: 0;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            font-size: 18px;
            display: block;
            margin-bottom: 10px;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .note {
            font-size: 14px;
            color: #6c757d;
            margin-top: 10px;
        }

        .result {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Sports Store</h1>
        </header>
        <form method="get" action="">
            <label for="inputField">Choose a number (0-25):</label>
            <input type="number" id="inputField2" name="username" required min="0" max="25">
            <button type="submit" name="sub">Submit</button>
            <p class="note">Note: Please enter a number between 0 and 25.</p>
        </form>
        <div class="result">
            <?php
            if(isset($_GET["sub"])){
                $namee=sanitize_input($_GET["username"]);
                $sql3 = "SELECT name FROM sport WHERE id='$namee'";
                $result = mysqli_query($conn,$sql3);
                if (!$result) {
                    echo "Error: " . mysqli_error($conn);
                }
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo $row["name"];
                        echo "<br>";
                    }
                } else {
                    echo "No results found";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
