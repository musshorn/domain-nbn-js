<?php
/*
Database backend for NBN-domain lookup

Recives a GET request (ie, localhost/nbn.php?postcode=1234)
And returns the status of that area as defined by NBNCo.
*/
$mysqli = new mysqli('host','user','password','nbn');

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

    /*needed to get num rows*/
    $stmt->store_result();

    /* if this is 0 then return "no work"*/
    $num_of_rows = $stmt->num_rows; 

    /* bind result variables */
    $stmt->bind_result($status,$commence,$complete);

    /* fetch value */
    $stmt->fetch();
    if ($num_of_rows > 0)
    {
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
    }
    elseif ($num_of_rows == 0)
    {
        print "Work has not commenced and is not currently planned to commence";
    }   
    
    /* status statement */
    $stmt->close();
}

/* close connection */
$mysqli->close();
?>