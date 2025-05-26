<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="{{ asset('logo/logo.png') }}" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">
  <title>It INTERNS</title>
</head>

<body>

  <main>
    <div class="it" style="width: 100%; max-height:250px;margin-bottom:10px; "> 
        <img src="{{ asset('intern/group.jpg') }}" alt="" width="100%" height="250px" style="border-radius: 10px;">
    </div>
      <div class="profile"> 
        <!-- Info profile -->
        <div class="info" >
          <div class="photo">
            <div>
              <img src="{{ asset('intern/aprilyn.jpg') }}" alt="" >
            </div>
            
            <div>
              <h2>Aprilyn Manicia</h2>
              <span class="award">Im the Leader</span>
            </div>
          </div>

          <div class="dados">
            <div class="table1">
              <table>
                <tr>
                  <th style="width:100px">Facebook:</th>
                  <td>facebook</td>
                </tr>
                <tr>
                  <th>Contact No.:</th>
                  <td>09482726597</td>
                </tr>
                <tr>
                  <th>School:</th>
                  <td>UCU</td>
                </tr>
                <tr>
                  <th>E-mail:</th>
                  <td>maniciaaprilyn.bsit@gmail.com</td>
                </tr>
              </table>
            </div>
            <!-- <div class="table2">
              <table>
               
           
              </table>
            </div> -->
          </div>

        </div>

        <div class="chart" id="progress1"></div>
      </div>
    </div>
    <div class="profile"> 
        <!-- Info profile -->
        <div class="info" >
          <div class="photo">
            <div>
              <img src="{{ asset('intern/jimwell.png') }}" alt="">
            </div>
            
            <div>
              <h2>Jimwell Ocampo </h2>
              <span class="award">Im the Senior Programmer</span>
            </div>
          </div>

          <div class="dados">
            <div class="table1">
              <table>
                <tr>
                  <th style="width:100px">Facebook:</th>
                  <td><a href="https://www.facebook.com/jimwell.ocampo.92/" target="_blank" style="color:blue;">Find ME!</a></td>
                </tr>
                <tr>
                  <th>Contact No.:</th>
                  <td>09106288467</td>
                </tr>
                <tr>
                  <th>School:</th>
                  <td>UCU</td>
                </tr>
                <tr>
                  <th>E-mail:</th>
                  <td>jimwellreevenocampo.bsit.ucu@gmail.com</td>
                </tr>
              </table>
            </div>
            <!-- <div class="table2">
              <table>
               
           
              </table>
            </div> -->
          </div>

        </div>

        <div class="chart" id="progress2"></div>
      </div>
    </div>
    <div class="profile"> 
        <!-- Info profile -->
        <div class="info" >
          <div class="photo">
            <div>
              <img src="{{ asset('intern/jims.jpg') }}" alt="">
            </div>
            
            <div>
              <h2>Jimmy Bautista</h2>
              <span class="award">Junior Programmer</span>
            </div>
          </div>

          <div class="dados">
            <div class="table1">
              <table>
                <tr>
                  <th style="width:100px">Facebook:</th>
                  <td><a href="https://www.facebook.com/jimjimyaw" target="_blank" style="color:blue;">Find ME!</a></td>
                </tr>
                <tr>
                  <th>Contact No.:</th>
                  <td>09274415182</td>
                </tr>
                <tr>
                  <th>School:</th>
                  <td>UCU</td>
                </tr>
                <tr>
                  <th>E-mail:</th>
                  <td>bautistajimmy.dev@gmail.com</td>
                </tr>
              </table>
            </div>
            <!-- <div class="table2">
              <table>
               
           
              </table>
            </div> -->
          </div>

        </div>

        <div class="chart" id="progress3"></div>
      </div>
    </div>
    <div class="profile"> 
        <!-- Info profile -->
        <div class="info" >
          <div class="photo">
            <div>
              <img src="{{ asset('intern/vincent.png') }}" alt="">
            </div>
            
            <div>
              <h2>Vincent Mahipus</h2>
              <span class="award">Junior Programmer</span>
            </div>
          </div>

          <div class="dados">
            <div class="table1">
              <table>
                <tr>
                  <th style="width:100px">Facebook:</th>
                  <td>facebook</td>
                </tr>
                <tr>
                  <th>Contact No.:</th>
                  <td>09129391613</td>
                </tr>
                <tr>
                  <th>School:</th>
                  <td>UCU</td>
                </tr>
                <tr>
                  <th>E-mail:</th>
                  <td>vincentmahipus.bsit.ucu@gmail.com</td>
                </tr>
              </table>
            </div>
            <!-- <div class="table2">
              <table>
               
           
              </table>
            </div> -->
          </div>

        </div>

        <div class="chart" id="progress4"></div>
      </div>
    </div>
  </main>

</body>
<style>
    * {
  margin: 0px;
  padding: 0px;
}

:root {
  --color-title: #293042;
  --color-text: #808A9D;
  --box-padding: 25px;
  --box-border-radius: 10px;
}

body {
  background-color: #E9ECEF;
  font-family: 'Open Sans', sans-serif;
  font-size: 12px;
  padding: 20px;
  color: var(--color-text);
}

.profile {
  margin-bottom: 10px;
  background: #FFF;
  box-shadow: 0px 0px 20px #2930420D;
  border-radius: var(--box-border-radius);
  opacity: 1;
  padding: var(--box-padding);
  display: grid;
  grid-template-columns: 1fr 0.2fr;
  align-items: center;
  gap: 20px;
}

.profile .photo {
  display: flex;
  gap: 20px;
  align-items: center;
}

.profile .dados {
  margin-top: 10px;
  margin-left: 80px;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
}

.profile .photo img{
  width: 60px;
  height: 60px;
  border-radius: 100%;
}

.profile h2 {
  font-size: 20px;
  color: var(--color-title);
}

.profile span.award {
  font-size: 12px;
  margin: 5px 0px;
  display: flex;
}

table, th, td {
  border: 0px solid black;
  border-collapse: collapse;
}

th {
  min-width: 100px;
}

th, td {
  text-align: left;
}

@media (max-width:768px) {
   .profile {
    display: grid;
    grid-template-columns: 1fr 0.5fr;
    align-items: center;
    gap: 20px;
  }
   body {
    font-size: 12px;
  }
  .profile h2 {
    font-size: 16px;
  }
  .profile .photo img{
  width: 40px;
  height: 40px;
  }
}

@media (max-width:768px) {
  .profile .dados {
  margin-left: 60px;
  display: grid;
  grid-template-columns: 1fr;
  gap: 0px;
  }
}

@media (max-width:480px) {
   .profile {
    display: block;
    grid-template-columns: 1fr;
    gap: 0px;
  }
  td {
    word-break: break-all;
  }
  .profile .photo {
    display: flex;
    align-items: flex-start;
  }
  .profile .dados {
    margin-left: 0;
  }
  .profile .info img{
  width: 40px;
  height: 40px;
  }

}

@media (max-width:600px) {
   .profile {
    display: block;
    grid-template-columns: 1fr;
    gap: 0px;
  }
  td {
    word-break: break-all;
  }
  .profile .photo {
    display: flex;
    align-items: flex-start;
  }
  .profile .dados {
    margin-left: 0;
  }
  .profile .info img{
  width: 40px;
  height: 40px;
  }

}

</style>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
  function createChart(elementId, percentage, label, color) {
  var options = {
    chart: {
      height: 200,
      type: "radialBar"
    },
    series: [percentage],
    plotOptions: {
      radialBar: {
        hollow: {
          margin: 10,
          size: "50%"
        },
        dataLabels: {
          showOn: "always",
          name: {
            offsetY: -10,
            show: true,
            color: "#808A9D",
            fontSize: "14px",
            fontWeight: "400",
            fontFamily: "Open sans, sans-serif"
          },
          value: {
            offsetY: 0,
            color: "#293042",
            fontSize: "24px",
            fontWeight: "bold",
            fontFamily: "Open sans, sans-serif",
            show: true
          }
        }
      }
    },
    fill: {
      type: "gradient",
      gradient: {
        gradientToColors: [color], // Custom color for each chart
        stops: [0, 100]
      }
    },
    stroke: {
      lineCap: "round",
    },
    labels: [label]
  };

  var chart = new ApexCharts(document.querySelector(`#${elementId}`), options);
  chart.render();
}

// Create multiple charts with different percentages
createChart("progress1", 50, "Development", "#5338FC");
createChart("progress2", 20, "Development", "#5338FC");
createChart("progress3", 10, "Development", "#5338FC");
createChart("progress4", 20, "Development", "#5338FC");

</script>
</html>