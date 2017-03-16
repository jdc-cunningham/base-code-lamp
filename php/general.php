<?php
  // require db connection 
  require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR.'db-connect.php');

  if ($_SERVER['REQUEST_METHOD'] === "POST"){
  
    // get post variable
    $var = $_POST['var_name'];

    // query MYSQL table with PHP-PDO with bindParam
    $stmt = $dbh->prepare('SELECT col FROM table WHERE something=:something GROUP BY col');
    $stmt->bindParam(':something', $some_var, PDO::PARAM_STR);
    if($stmt->execute()) {
      $result = $stmt->fetchAll();
      // create a status object in the results_array
      $results_array["status"] = "success";
      // create a query-results object in the results_array
      $results_array["query-results"] = array();
      foreach($result as $row) {
        array_push($results_array["query-results"], $row['col']);
      }
    }
    else {
      $results_array["status"] = "fail";
    }

    // json encode and output 
    echo json_encode($results_array);

  }