<?php

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Category.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate blog category object
  $category = new Category($db);

  // Get ID
  $category->id = isset($_GET['ID']) ? $_GET['ID'] : die();

  // Get post
  $category->read_single();

  // Create array
  $category_arr = array(
    'ID' => $category->ID,
    'username' => $category->username
  );

  // Make JSON
  print_r(json_encode($category_arr));