<?php

if(isset($_POST['name']) && isset($_POST['phone'])){

    $link = mysqli_connect("localhost","altenrion_gbland","Altenrion","altenrion_gbland") or die("Error " . mysqli_error($link));
//    $link = mysqli_connect("localhost","root","","altenrion_gbland") or die("Error " . mysqli_error($link));

    $query = "INSERT INTO requests (`name`, `phone`) VALUES ('{$_POST['name']}','{$_POST['phone']}')" or die("Error in the consult.." . mysqli_error($link));

    $result = $link->query($query);
    if(!empty($link->insert_id))
        echo 'success';

}
