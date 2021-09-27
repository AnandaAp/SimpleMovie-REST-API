<?php
    require_once "koneksi.php";
    if(function_exists($_GET['function'])) {
        $_GET['function']();
     }
    function get_movie()
    {
        global $connect;      
        $query = $connect->query("SELECT * FROM profile");            
        while($row=mysqli_fetch_object($query))
        {
             $data[] =$row;
        }
        $response=array(
            'profile' => $data
        );
        header('Content-Type: application/json');
        echo json_encode($response);
   }  
?>