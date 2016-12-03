<head>
    <title>login</title>
</head>
<?php
    $pw = $_POST["pw"];
    echo $pw;
    $password = "notPassword";
    if($pw == $password)
    {
        header("location: loading.html");
    }
    else
    {
        header("location: index.html");
        echo '<script type="text/javascript">alert("Incorrect Password");</script>';
    }

?>