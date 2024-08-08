<?php

$conn = mysqli_connect("localhost","root","","crud_operation", 3307);
if($conn->connect_errno){
    echo "$conn->connect_errno";
}else {
    //echo "connection successfuly";
}

?>