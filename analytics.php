<?php
  $list = array();
  $error = null;
  $timestamp = '';
  $period = '';
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $timestamp = isset($_POST['timestamp']) ? $_POST['timestamp'] : '';
    $period = isset($_POST['period']) ? $_POST['period'] : '';
    if (filter_var($timestamp, FILTER_VALIDATE_INT, [ 'options' => ['min_range' => 0, 'max_range' => PHP_INT_MAX]]) === false) {
      $error = 'Invalid timestamp';
    }
    elseif (filter_var($period, FILTER_VALIDATE_INT, [ 'options' => ['min_range' => 0, 'max_range' => 3600]]) === false) {
      $error = 'Invalid period';
    }
    else {
      $mysqli = new mysqli("localhost", "root", "vertrigo", "home");

      if ($mysqli->connect_errno) {
          printf("No connection: %s\n", $mysqli->connect_error);
          exit();
      }

      $actions = [];
      if ($result = $mysqli->query("SELECT * FROM actions WHERE timestamp BETWEEN FROM_UNIXTIME($timestamp) AND FROM_UNIXTIME($timestamp) + INTERVAL $period SECOND ORDER BY timestamp ASC")) {
        while($row = $result->fetch_object()){
          $actions[$row->userid][] = $row;
        }
      }      

      $result->close();
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Analytics</title>
</head>
<body>
  <form action="" method="post">
    <fieldset class="field-group">
      <label><b>Timestamp:</b>
      <input type="number" name="timestamp" min="0" max="<?= PHP_INT_MAX ?>" value="<?= $timestamp; ?>">
      </label>
      <label><b>Period:</b>
      <input type="number" name="period" min="0" max="3600" value="<?= $period; ?>">
      </label>
      <button type="submit">Submit</button>
    </fieldset>   

  </form>
  <div>
    <?= $error ?>
  </div>
  
  <ul>
    <li>1</li>
    <li>2</li>
  </ul>

  
</body>
</html>