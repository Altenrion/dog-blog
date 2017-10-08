<?php

if(isset($_POST['email'])){

    $link = mysqli_connect("localhost","altenrion_gbland","Altenrion","altenrion_gbland") or die("Error " . mysqli_error($link));
//    $link = mysqli_connect("localhost","root","","altenrion_gbland") or die("Error " . mysqli_error($link));

    $query = "INSERT INTO subscription (`email`) VALUES ('{$_POST['email']}')" or die("Error in the consult.." . mysqli_error($link));

    $result = $link->query($query);
    if(!empty($link->insert_id))
        echo 'success';

}
