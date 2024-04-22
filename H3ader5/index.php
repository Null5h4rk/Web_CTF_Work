<!DOCTYPE html>
<html>
<head>
    <title>Welcome to the SUPER SECRET SITE</title>
</head>
<body>
    <h1>Welcome to the SUPER SECRET SITE</h1>
    <?php
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $referer = $_SERVER['HTTP_REFERER'];
    $date = $_SERVER['HTTP_DATE'];
    $upgradeInsecureRequests = $_SERVER['HTTP_UPGRADE_INSECURE_REQUESTS'];
    $downtime = $_SERVER['HTTP_DOWNTIME'];
    
    if ($userAgent !== 'lorbrowser') {
        echo 'But wait...you dont look like a lorbrowser user to me';
        exit();
    } else if ( $referer !== 'https://vishwactf.com/' ) {
        echo 'But wait...hacktify people come from the vishwactf.com website, are you a spy?';
        exit();
    } else if ($date !== '2043') {
        echo 'But wait..you are mere mortal who lives in the present. We are divine beings living 20 years in the future. We are not the same.';
        exit();
    } else if ($upgradeInsecureRequests !== '10') {
        echo 'But wait...server expressing the clients preference for an encrypted and authenticated response check out it.';
        exit();
    } else if ($downtime !== '999999999') {
        echo 'But wait..Nine times header field provides the approximate bandwidth of the clients connection to the server' ; 
        exit();
    } else {
        echo 'Congrats! Here is flag : VishwaCTF{s3cret_sit3_http_head3rs_r_c0o1}';
        exit();
    }
    ?>
</body>
</html>
