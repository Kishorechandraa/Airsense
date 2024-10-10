<?php
    if (isset($_POST["submit"])){
        $pm25 = $_POST['pm25'];
        $pm10 = $_POST['pm10'];
        $no = $_POST['no'];
        $no2 = $_POST['no2'];
        $nox = $_POST['nox'];
        $nh3 = $_POST['nh3'];
        $co = $_POST['co'];
        $so2 = $_POST['so2'];
        $o3 = $_POST['o3'];
        $benzene = $_POST['benzene'];
        $toluene = $_POST['toluene'];
        $xylene = $_POST['xylene'];

        $values = $pm25. ' ' .$pm10. ' ' .$no. ' ' .$no2. ' ' .$nox. ' ' .$nh3. ' '.$co. ' '.$so2. ' ' .$o3. ' ' .$benzene. ' ' .$toluene. ' ' .$xylene;
        $output = shell_exec("python ML/predict.py $values 2>&1");
    }
  ?>

<!DOCTYPE html>
<html>
<head>
  <title>AQI Prediction</title>
  <link rel="icon" href="images/Airsense_logo.png" />
  <link rel="stylesheet" href="styles/predict.css" />
</head>
<body>
  <div class="container">
    <div class="sidebar">
        <a href="home.html"><img src="images/Airsense_logo.png" alt="Logo"></a>
      <h1>AirSense</h1>
      <ul>
        <li><a href="year.php">Yearly</a></li>
        <li><a href="month.php">Monthly</a></li>
        <li><a href="day.php">Daily</a></li>
        <li><a href="predict.php" class="link">Prediction</a></li>
      </ul>
    </div>
    <div class="content">
      <div class="chart-container">
        <div class="chart">
            <div class="form-container">
            <h2>AQI Prediction Based on Pollutants</h2><br><br>
            <form method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="pm25">PM<sub>2.5</sub></label>
                        <input type="number" step="0.01" id="pm25" name="pm25" placeholder="<?php echo $pm25 ?? 0?>" required>
                    </div>
                    <div class="form-group">
                        <label for="pm10">PM<sub>10</sub></label>
                        <input type="number" step="0.01" id="pm10" name="pm10" placeholder="<?php echo $pm10 ?? 0?>" required>
                    </div>
                    <div class="form-group">
                        <label for="no">NO</label>
                        <input type="number" step="0.01" id="no" name="no" placeholder="<?php echo $nox ?? 0?>" required>
                    </div>
                    <div class="form-group">
                        <label for="no2">NO<sub>2</sub></label>
                        <input type="number" step="0.01" id="no2" name="no2" placeholder="<?php echo $no ?? 0?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nox">NO<sub>x</sub></label>
                        <input type="number" step="0.01" id="nox" name="nox" placeholder="<?php echo $nox ?? 0?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nh3">NH<sub>3</sub></label>
                        <input type="number" step="0.01" id="nh3" name="nh3" placeholder="<?php echo $nh3 ?? 0?>" required>
                    </div>
                    <div class="form-group">
                        <label for="co">CO</label>
                        <input type="number" step="0.01" id="co" name="co" placeholder="<?php echo $co ?? 0?>" required>
                    </div>
                    <div class="form-group">
                        <label for="so2">SO<sub>2</sub></label>
                        <input type="number" step="0.01" id="so2" name="so2" placeholder="<?php echo $so2 ?? 0?>" required>
                    </div>
                    <div class="form-group">
                        <label for="o3">O<sub>3</sub></label>
                        <input type="number" step="0.01" id="o3" name="o3" placeholder="<?php echo $o3 ?? 0?>" required>
                    </div>
                    <div class="form-group">
                        <label for="benzene">Benzene</label>
                        <input type="number" step="0.01" id="benzene" name="benzene" placeholder="<?php echo $benzene ?? 0?>" required>
                    </div>
                    <div class="form-group">
                        <label for="toluene">Toluene</label>
                        <input type="number" step="0.01" id="toluene" name="toluene" placeholder="<?php echo $toluene ?? 0?>" required>
                    </div>
                    <div class="form-group">
                        <label for="xylene">Xylene</label>
                        <input type="number" step="0.01" id="xylene" name="xylene" placeholder="<?php echo $xylene ?? 0?>" required>
                    </div>
                </div>
                <button type="submit" name="submit" class="submit-btn">Submit</button>
            </form>
        </div>
      </div>
        <div class="chart">
          <h2>Results</h2>
          <p> Predicted AQI : <?php echo $output ?? 0?></p><br><hr><br><br>
          <table>
            <thead>
                <tr>
                    <th>AQI</th>
                    <th>Remark</th>
                    <th>Possible Health Impacts</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>0 - 50</td>
                    <td class="good">Good</td>
                    <td>Minimal impact</td>
                </tr>
                <tr>
                    <td>51 - 100</td>
                    <td class="satisfactory">Satisfactory</td>
                    <td>Minor breathing discomfort to sensitive people</td>
                </tr>
                <tr>
                    <td>101 - 200</td>
                    <td class="moderate">Moderate</td>
                    <td>Breathing discomfort to people with asthma and heart diseases</td>
                </tr>
                <tr>
                    <td>201 - 300</td>
                    <td class="poor">Poor</td>
                    <td>Breathing discomfort to most people on prolonged exposure</td>
                </tr>
                <tr>
                    <td>301 - 400</td>
                    <td class="very-poor">Very Poor</td>
                    <td>Respiratory illness on prolonged exposure</td>
                </tr>
                <tr>
                    <td>401 - 500</td>
                    <td class="severe">Severe</td>
                    <td>Affects healthy people and seriously impacts those with existing diseases</td>
                </tr>
                <tr>
                    <td>> 500</td>
                    <td class="hazardous">Hazardous</td>
                    <td>Serious health effects for everyone</td>
                </tr>
            </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
</body>
</html>