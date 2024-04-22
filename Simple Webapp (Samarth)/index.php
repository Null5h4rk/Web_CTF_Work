<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Simple WebApp</title>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
}

.container {
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

form {
    text-align: center;
}

label {
    display: block;
    font-size: 18px;
    margin-bottom: 5px;
}

input[type="text"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

.result {
    margin-top: 30px;
    font-size: 18px;
    text-align: center;
    color: #333;
}
</style>
</head>
<body>
<div class="container">
    <h1>Welcome to the Simple WebApp Challenge</h1>
    <form action="" method="post">
        <label for="command">Enter a Name:</label>
        <input type="text" id="command" name="command" required>
        <input type="submit" value="Submit">
    </form>

    <div class="result">
        <?php
        session_start();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $command = $_POST['command'];

            if ($command == 'echo *') {
                $files = array('index.html' , '/Work/', 's3cr3t_fl4g.txt' , 'style.css');
                $_SESSION['result'] = "<p>You're nearing completion of the challenge, which is awesome!</p><ul>";
                foreach ($files as $file) {
                    $_SESSION['result'] .=  $file. "     " ;
                }
                $_SESSION['result'] .= "</ul>";
            } else if ($command == 'whoami') {
                $_SESSION['result'] = "A better approach is to start with the\n ~root";
            } else if ($command == 'ls') {
                $_SESSION['result'] = "Inspiring, this command is quite common, but it doesn't seem to do the work here.";
            } else if ($command == 'cat s3cr3t_fl4g.txt') {
                $_SESSION['result'] = "This command is quite common. Perhaps it's time to explore some alternatives.";
            } else if ($command == 'batcat s3cr3t_fl4g.txt') {
                $_SESSION['result'] = "Congratulations! Here is your flag: flag{L1nux_c0mm4nd5_4r3_Aws0m3}";
            } else {
                $_SESSION['result'] = "Hello, " . $command . ". I believe you are enjoying our CTF. Wish you all the best for further challenges!";
            }
            header("Location: ".$_SERVER['PHP_SELF']); // Redirect to clear the POST data
            exit(); // Prevent the form from being displayed again
        }

        if(isset($_SESSION['result'])) {
            echo $_SESSION['result'];
            unset($_SESSION['result']); // Clear the result after displaying it
        }
        ?>
    </div>
</div>
</body>
</html>
