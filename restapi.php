<?php
require_once "koneksi.php";
   if(function_exists($_GET['function'])) {
         $_GET['function']();
      }   
   function get_movie()
   {
      global $connect;      
      $query = $connect->query("SELECT * FROM movie");            
      while($row=mysqli_fetch_object($query))
      {
         $data[] =$row;
      }
      $response=array(
                     'status' => 1,
                     'message' =>'Success',
                     'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
   }   
   
   function get_movie_id()
   {
      global $connect;
      if (!empty($_GET["id"])) {
         $id = $_GET["id"];      
      }            
      $query ="SELECT * FROM movie WHERE id= $id";      
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
   function insert_movie()
      {
         global $connect;   
         $check = array('title' => '', 'genre' => '', 'rating' => '');
         $check_match = count(array_intersect_key($_POST, $check));
         if($check_match == count($check)){
         
               $result = mysqli_query($connect, "INSERT INTO movie SET
               title = '$_POST[title]',
               genre = '$_POST[genre]',
               rating = '$_POST[rating]'");
               
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
   function update_movie()
      {
         global $connect;
         if (!empty($_GET["id"])) {
            $id = $_POST["id"];      
            $check = array('title' => '', 'genre' => '', 'rating' => '');
            $check_match = count(array_intersect_key($_POST, $check));         
            if($check_match == count($check)){
            
               $result = mysqli_query($connect, "UPDATE movie SET               
                  title = '$_POST[title]',
                  genre = '$_POST[genre]',
                  rating = '$_POST[rating]' WHERE id = $id");
            
               if($result)
               {
                  $response=array(
                     'status' => 1,
                     'message' =>'Update Success'                  
                  );
               }
               else
               {
                  $response=array(
                     'status' => 0,
                     'message' =>'Update Failed'                  
                  );
               }
            }   
         }else{
            $response=array(
                     'status' => 0,
                     'message' =>'Wrong Parameter',
                     'data'=> $id
                  );
         }
         header('Content-Type: application/json');
         echo json_encode($response);
      }
   function delete_movie()
   {
      global $connect;
      $id = $_POST['id'];
      $query = "DELETE FROM movie WHERE id=".$id;
      if(mysqli_query($connect, $query))
      {
         $response=array(
            'status' => 1,
            'message' =>'Delete Success'
         );
      }
      else
      {
         $response=array(
            'status' => 0,
            'message' =>'Delete Fail.'
         );
      }
      header('Content-Type: application/json');
      echo json_encode($response);
   }
 ?>