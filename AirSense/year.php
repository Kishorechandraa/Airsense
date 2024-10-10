<?php
  include('connection.php');

  if (isset($_POST["city"]) && $_POST["city"]!="") {
    $city = $_POST["city"];
    $year2015 = mysqli_query($con, "SELECT avg(aqi) as aqi FROM city where city='$city' and date like '2015%';")->fetch_assoc();
    $year2016 = mysqli_query($con, "SELECT avg(aqi) as aqi FROM city where city='$city' and date like '2016%';")->fetch_assoc();
    $year2017 = mysqli_query($con, "SELECT avg(aqi) as aqi FROM city where city='$city' and date like '2017%';")->fetch_assoc();
    $year2018 = mysqli_query($con, "SELECT avg(aqi) as aqi FROM city where city='$city' and date like '2018%';")->fetch_assoc();
    $year2019 = mysqli_query($con, "SELECT avg(aqi) as aqi FROM city where city='$city' and date like '2019%';")->fetch_assoc();
    $year2020 = mysqli_query($con, "SELECT avg(aqi) as aqi FROM city where city='$city' and date like '2020%';")->fetch_assoc();

    $avg = mysqli_query($con, "SELECT ROUND(AVG(aqi), 2) AS aqi from city where city='$city';")->fetch_assoc();
    $max = mysqli_query($con, "SELECT aqi, DATE_FORMAT(date, '%Y-%m-%d') AS day FROM city WHERE city = '$city' AND aqi = (SELECT MAX(aqi) FROM city WHERE city = '$city');")->fetch_assoc();
    $min = mysqli_query($con, "SELECT aqi, DATE_FORMAT(date, '%Y-%m-%d') AS day FROM city WHERE city = '$city' AND aqi = (SELECT MIN(aqi) FROM city WHERE city = '$city');")->fetch_assoc();
  }
  $con->close();
  ?>

<!DOCTYPE html>
<html>
<head>
  <title>Yearly AQI</title>
  <link rel="icon" href="images/Airsense_logo.png" />
  <link rel="stylesheet" href="styles/year.css" />
</head>
<body>
  <div class="container">
    <div class="sidebar">
      <a href="home.html"><img src="images/Airsense_logo.png" alt="Logo"></a>
      <h1>AirSense</h1>
      <ul>
        <li><a href="year.php" class="link">Yearly</a></li>
        <li><a href="month.php">Monthly</a></li>
        <li><a href="day.php">Daily</a></li>
        <li><a href="predict.php">Prediction</a></li>
      </ul>
    </div>
    <div class="content">
      <div class="chart-container">
        <div class="chart">
          <h2>Average Yearly AQI</h2><br>
          <canvas id="myChart"></canvas>
        </div>
      </div>
      <div >
        <div class="chart">
          <h2>Select a City</h2><br>
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
    const xValues = [2015, 2016, 2017, 2018, 2019, 2020];
    var yValues = [
      <?php echo $year2015['aqi'];?>,
      <?php echo $year2016['aqi'];?>,
      <?php echo $year2017['aqi'];?>,
      <?php echo $year2018['aqi'];?>,
      <?php echo $year2019['aqi'];?>,
      <?php echo $year2020['aqi'];?>];

    new Chart("myChart", {
      type: "line",
      data: {
        labels: xValues,
        datasets: [{
          label: "<?php echo $city?>",
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
              labelString: 'Year'
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
      if (selectedCity==='-') {
        alert("Please Select a City!");
      }
    }

    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
</body>
</html>