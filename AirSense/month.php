<?php
  include('connection.php');

  if (isset($_POST["city"]) && $_POST["city"]!="" && $_POST["year"]!="") {
    $city = $_POST["city"];
    $year = $_POST["year"];
    $sql = "SELECT AVG(aqi) AS aqi, DATE_FORMAT(date, '%Y-%m') as month from city where city='$city' and date LIKE '$year%' GROUP BY month ORDER BY month;";
    $result = $con->query($sql);

    $values = array();
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $values[] = $row['aqi'];
      }
    }
    $avg = mysqli_query($con, "SELECT ROUND(AVG(aqi), 2) AS aqi from city where city='$city' and date like '$year%';")->fetch_assoc();
    $max = mysqli_query($con, "SELECT aqi, DATE_FORMAT(date, '%Y-%m-%d') AS day FROM city WHERE city = '$city' AND aqi = (SELECT MAX(aqi) FROM city WHERE city = '$city' and date like '$year%') AND date LIKE '$year%';")->fetch_assoc();
    $min = mysqli_query($con, "SELECT aqi, DATE_FORMAT(date, '%Y-%m-%d') AS day FROM city WHERE city = '$city' AND aqi = (SELECT MIN(aqi) FROM city WHERE city = '$city' and date like '$year%') AND date LIKE '$year%';")->fetch_assoc();
  }
  $con->close();
  ?>

<!DOCTYPE html>
<html>
<head>
  <title>Monthly AQI</title>
  <link rel="icon" href="images/Airsense_logo.png" />
  <link rel="stylesheet" href="styles/month.css" />
</head>
<body>
  <div class="container">
    <div class="sidebar">
      <a href="home.html"><img src="images/Airsense_logo.png" alt="Logo"></a>
      <h1>AirSense</h1>
      <ul>
        <li><a href="year.php">Yearly</a></li>
        <li><a href="month.php" class="link">Monthly</a></li>
        <li><a href="day.php">Daily</a></li>
        <li><a href="predict.php">Prediction</a></li>
      </ul>
    </div>
    <div class="content">
      <div class="chart-container">
        <div class="chart">
          <h2>Average Monthly AQI by Year</h2><br>
          <canvas id="myChart"></canvas>
        </div>
      </div>
      <div >
        <div class="chart">
          <h2>Select City & Year</h2><br>
          <form method="post">
            <select name="city" id="city">
            <option value="-">Select City</option>
              <option value="Ahmedabad">Ahmedabad</option>
              <option value="Amaravati">Amaravati</option>
              <option value="Amritsar">Amritsar</option>
              <option value="Bengaluru">Bengaluru</option>
              <option value="Brajrajnagar">Brajrajnagar</option>
              <option value="Chennai">Chennai</option>
              <option value="Coimbatore">Coimbatore</option>
              <option value="Delhi">Delhi</option>
              <option value="Gurugram">Gurugram</option>
              <option value="Hyderabad">Hyderabad</option>
              <option value="Jaipur">Jaipur</option>
              <option value="Jorapokhar">Jorapokhar</option>
              <option value="Kolkata">Kolkata</option>
              <option value="Lucknow">Lucknow</option>
              <option value="Mumbai">Mumbai</option>
              <option value="Patna">Patna</option>
              <option value="Shillong">Shillong</option>
              <option value="Talcher">Talcher</option>
              <option value="Thiruvananthapuram">Thiruvananthapuram</option>
            </select>
            <select name="year" id="year">
                <option value="-">Select Year</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
            </select><br>
            <input type="submit" name="update" class="update" value="Update" onclick="show()">
          </form>
          <div class="chart-stats">
            <div>
              <h3>Max AQI</h3>
              <p><?php echo $max['aqi'] ?? 0;?></p>
              <p>on <?php echo $max['day'] ?? "XX-XX-XXXX";?></p>
            </div>
            <div>
              <h3>Avg AQI</h3><br>
              <p><?php echo $avg['aqi'] ?? 0;?></p>
            </div>
            <div>
              <h3>Min AQI</h3>
              <p><?php echo $min['aqi'] ?? 0;?></p>
              <p>on <?php echo $min['day'] ?? "XX-XX-XXXX";?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <script>
    const xValues = ["Jan","Feb","Mar","Apr","May","June","July","Aug","Sept","Oct","Nov","Dec"];
    var yValues = <?php echo json_encode($values); ?>;

    new Chart("myChart", {
      type: "line",
      data: {
        labels: xValues,
        datasets: [{
          label: "<?php echo $city. ' ' .$year; ?>",

          data: yValues,
          borderColor: "#a616e8",
          fill: false
        }]
      },
      options: {
        scales: {
          xAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Month'
            }
          }],
          yAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'AQI  Value'
            }
          }]
        }
      }
    });

    function show() {
        var selectedCity = document.getElementById("city").value;
        var selectedYear = document.getElementById("year").value;
        if (selectedCity=="-" || selectedYear=="-") {
        alert("Please Select a City & Year!");
        }
    }
    
  </script>
</body>
</html>