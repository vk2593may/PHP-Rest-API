<?php
date_default_timezone_set('Asia/Kolkata');
  class Category {
    // DB Stuff
    private $conn;
    private $table = 'admin_logins';

    // Properties
    public $ID;
    public $username;
    public $password;
    public $dob;
    public $doj;
    public $emp_id;
    public $fullname;
    public $created;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get categories
    public function read() {
      // Create query
      $query = 'SELECT
        *
      FROM
        ' . $this->table;

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Category
  public function read_single(){
    // Create query
    $query = 'SELECT
          ID,
          username
        FROM
          ' . $this->table . '
      WHERE ID = ?
      LIMIT 0,1';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->ID);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set properties
      $this->ID = $row['ID'];
      $this->username = $row['username'];
  }

  // Create Category
  public function create() {
    // Create Query
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
    username = :username,
    password = :password,
    dob = :dob,
    emp_id =:emp_id,
    doj = :doj,
    created = :created,
    fullname = :fullname';

  // Prepare Statement
  $stmt = $this->conn->prepare($query);
  // Clean data
  $this->username = htmlspecialchars(strip_tags($this->username));
  $this->password = htmlspecialchars(strip_tags($this->password));
  $this->dob = date('Y-m-d',strtotime($this->dob));
  $this->emp_id = htmlspecialchars(strip_tags($this->emp_id));
  $this->doj = date('Y-m-d',strtotime($this->doj));
  $this->created = date('Y-m-d H:i:s');
  $this->fullname = htmlspecialchars(strip_tags($this->fullname));

  // Bind data
  $stmt-> bindParam(':username', $this->username);
  $stmt-> bindParam(':password', $this->password);
  $stmt-> bindParam(':dob', $this->dob);
  $stmt-> bindParam(':emp_id', $this->emp_id);
  $stmt-> bindParam(':doj', $this->doj);
  $stmt-> bindParam(':created', $this->created);
  $stmt-> bindParam(':fullname', $this->fullname);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false;
  }

  // Update Category
  public function update() {
    // Create Query
    $query = 'UPDATE ' .
      $this->table . '
    SET
    username = :username
      WHERE
      ID = :ID';

  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->username = htmlspecialchars(strip_tags($this->username));
  $this->ID = htmlspecialchars(strip_tags($this->ID));

  // Bind data
  $stmt-> bindParam(':username', $this->username);
  $stmt-> bindParam(':ID', $this->ID);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false;
  }

  // Delete Category
  public function delete() {
    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE ID = :ID';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // clean data
    $this->ID = htmlspecialchars(strip_tags($this->ID));

    // Bind Data
    $stmt-> bindParam(':ID', $this->ID);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

    return false;
    }
  }