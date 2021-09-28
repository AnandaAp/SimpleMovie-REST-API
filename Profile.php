<?php
    require_once "koneksi.php";
    if(function_exists($_GET['function'])) {
        $_GET['function']();
     }
    function get_pengguna()
    {
        global $connect;
        $profile = null;      
        $query = $connect->query("SELECT * FROM pengguna");            
        while($row=mysqli_fetch_object($query))
        {
            $profile[] = $row;
        }
        $response=array(
            'profile' => $profile
        );
        header('Content-Type: application/json');
        echo json_encode($response);
   } 
    function get_pengguna_by_id(){
        global $connect;
        if (!empty($_GET['id'])) {
            $id = $_GET["id"];
            $query = "SELECT * FROM pengguna WHERE id = $id";
            $result = $connect->query($query);
            while($row = mysqli_fetch_object($result)){
                $profile[] = $row;
            }            
            if($profile){
                $response = array(
                                'status' => 1,
                                'message' =>'Sucess retrieve data',
                                'profile' => $profile
                            );               
            }else {
                $response=array(
                            'status' => 0,
                            'message' =>'No Data Found'
                        );
            }

            header('Content-Type: application/json');
            echo json_encode($response);
        }
        else{
            // echo "nope";

        }   
    }
    function insert_pengguna(){
        global $connect;   
        $check = array( 
            'Name' => '', 
            'Email' => '', 
            'Password' => '', 
            'Profile_Picture_Path' => ''
        );
        $check_match = count(array_intersect_key($_POST, $check));
        if($check_match == count($check)){ 
            $result = mysqli_query($connect, "INSERT INTO pengguna SET
            Name = '$_POST[Name]',
            Email = '$_POST[Email]',
            password = '$_POST[Password]',
            Profile_Picture_Path = '$_POST[Profile_Picture_Path]'");   
            if($result)
            {
                $response=array(
                    'status' => 1,
                    'message' =>'Insert Success'
                );
            }
            else
            {
                $response=array(
                    'status' => 0,
                    'message' =>'Insert Failed.'
                );
            }
        }else{
            $response=array(
                     'status' => 0,
                     'message' =>'Wrong Parameter'
                  );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function upload_picture(){
        $image = $_FILES['file']['tmp_name'];
        $imagename = $_FILES['file']['name'];
        
        $file_path = $_SERVER['DOCUMENT_ROOT'] . '/ilist/profiles/pictures';
        
        $response = "";
        
        if (!file_exists($file_path)) {
            mkdir($file_path, 0777, true);
        }
        
        if(!$image){
            $response=array(
                'status' => 0,
                'message' =>'Gambar Tidak Ditemukan'
            );;
        }
        else{
            if(move_uploaded_file($image, $file_path.'/'.$imagename)){
                $response=array(
                    'status' => 1,
                    'message' =>'Insert Success',
                    'picture_path' => $file_path. '/' .$imagename
                );
            }
        }
        print_r(json_encode($response));
    }
    function sign_in(){
        global $connect;
        $email = $_GET['email'];
        $password = $_GET['password'];
        $query = "SELECT * FROM `pengguna` WHERE email = '$email' and password = '$password'";
        $result = $connect->query($query);
        while($row = mysqli_fetch_object($result))
        {
           $data[] = $row;
        }
        if($data)
        {
        $response = array(
                        'status' => 1,
                        'message' =>'Success',
                        'data' => $data
                    );               
        }else {
            $response=array(
                        'status' => 0,
                        'message' =>'No Data Found'
                    );
        } 
        header('Content-Type: application/json');
        echo json_encode($response);
    } 
?>