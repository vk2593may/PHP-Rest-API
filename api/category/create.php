<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Category.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $category = new Category($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $category->username = $data->username;
  $category->password = $data->password;
  $category->dob = $data->dob;
  $category->emp_id = $data->emp_id;
  $category->doj = $data->doj;
  $category->created = $data->created;
  $category->fullname = $data->fullname;
  // Create Category
  if($category->create()) {
    echo json_encode(
      array('message' => 'User Details Created')
    );
  } else {
    echo json_encode(
      array('message' => 'User Details Not Created')
    );
  }