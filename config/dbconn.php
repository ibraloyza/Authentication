<?php

$conn = mysqli_connect("localhost","root","","Authentication");
if($conn->connect_error){
    echo "$conn->connect_error";
}else {
    //echo "connection successfuly";
}

?>