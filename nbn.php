<?php
$mysqli = new mysqli("localhost","root",'onose','nbn');

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

/* create a prepared statement */
if ($stmt = $mysqli->prepare("SELECT status,commencment,completion  FROM lookup WHERE postcode=?")) {

    /* bind parameters for markers */
    $stmt->bind_param("s", $_GET['postcode']);

    /* execute query */
    $stmt->execute();

    /* bind result variables */
    $stmt->bind_result($status,$commence,$complete);

    /* fetch value */
    $stmt->fetch();

    if ($commence == "")
    {
    	printf("%s\n", $status);
    }
    elseif ($complete == "")
    {
    	printf("%s started %s",$status,$commence);
    }
    else
    {
    	printf("%s started %s due to complete %s",$status,$commence,$complete);
    }

    /* status statement */
    $stmt->close();
}

/* close connection */
$mysqli->close();
?>