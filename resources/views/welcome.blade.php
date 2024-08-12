<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IOT Monitoring</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Custom CSS for enhancements -->
  <style>
    body {
      font-family: 'Source Sans Pro', sans-serif;
      background-color: #f4f6f9;
      color: #333;
    }
    .brand-link h4 {
      font-weight: 700;
      margin: 0;
    }
    .card {
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .card-header {
      background-color: #007bff;
      color: #fff;
      border-radius: 10px 10px 0 0;
      padding: 15px;
    }
    .card-title {
      margin: 0;
    }
    .card-tools .btn-tool {
      color: #fff;
    }
    .knob-label {
      font-weight: bold;
      font-size: 1.2em;
    }
    .breadcrumb {
      background: none;
      padding: 0;
    }
    .breadcrumb-item a {
      color: #007bff;
    }
    .breadcrumb-item.active {
      color: #6c757d;
    }
    .main-footer {
      background-color: #343a40;
      color: #fff;
    }
    .main-footer a {
      color: #17a2b8;
    }
    .float-right {
      margin-right: 10px;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  @include('tools-admin.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
      <center>
        <h4>SISTEM MONITORING</h4>
        <h4>POLUSI UDARA</h4>
      </center>
    </a>

    <!-- Sidebar -->
    @include('tools-admin.sidebar')
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Beranda</a></li>
              <li class="breadcrumb-item active">Grafik Inline</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="far fa-chart-bar"></i>
                  Data Alat Terkini
                </h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-6 col-md-3 text-center">
                    <input type="text" id="suhuKnob" class="knob" data-thickness="0.2" data-angleArc="250" data-angleOffset="-125"
                           value="0" data-width="120" data-height="120" data-fgColor="#ff3f10" readonly>
                    <div class="knob-label">SUHU UDARA</div>
                  </div>
                  <div class="col-6 col-md-3 text-center">
                      <input type="text" id="kelembabanKnob" class="knob" data-thickness="0.2" data-angleArc="250" data-angleOffset="-125"
                            value="0" data-width="120" data-height="120" data-fgColor="#00c0ef" readonly>
                      <div class="knob-label">KELEMBABAN</div>
                  </div>
                  <div class="col-6 col-md-3 text-center">
                      <input type="text" id="amoniaKnob" class="knob" data-thickness="0.2" data-angleArc="250" data-angleOffset="-125"
                            value="0" data-width="120" data-height="120" data-fgColor="#f39c12" readonly>
                      <div class="knob-label">GAS AMONIA</div>
                  </div>
                  <div class="col-6 col-md-3 text-center">
                      <input type="text" id="udaraKnob" class="knob" data-thickness="0.2" data-angleArc="250" data-angleOffset="-125"
                            value="0" data-width="120" data-height="120" data-fgColor="#00a65a" readonly>
                      <div class="knob-label">KECEPATAN UDARA</div>
                  </div>                
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Line Charts -->
        <div class="row">
          <div class="col-md-6">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="far fa-chart-bar"></i>
                  Grafik Suhu Udara
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div id="line-chart-1" style="height: 300px;"></div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="far fa-chart-bar"></i>
                  Grafik Kelembaban Udara
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div id="line-chart-2" style="height: 300px;"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="far fa-chart-bar"></i>
                  Grafik Gas Amonia
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div id="line-chart-3" style="height: 300px;"></div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="far fa-chart-bar"></i>
                  Grafik Kecepatan Udara
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div id="line-chart-4" style="height: 300px;"></div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>
  </div>

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Versi</b> 3.2.0
    </div>
    <strong>Hak Cipta &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> Hak Cipta Dilindungi.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- jQuery Knob -->
<script src="../../plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- Flot -->
<script src="../../plugins/flot/jquery.flot.js"></script>
<script src="../../plugins/flot/plugins/jquery.flot.resize.js"></script>
<script src="../../plugins/flot/plugins/jquery.flot.pie.js"></script>
<!-- Custom script -->
<script>
  $(function () {
    $('.knob').knob({
      readOnly: true,
      draw: function () {
        if (this.$.data('skin') == 'tron') {
          var a = this.angle(this.cv), 
              sa = this.startAngle, 
              sat = this.startAngle, 
              ea, 
              eat = sat + a, 
              r = true;
          this.g.lineWidth = this.lineWidth;
          this.o.cursor && (sat = eat - 0.3) && (eat = eat + 0.3);
          if (this.o.displayPrevious) {
            ea = this.startAngle + this.angle(this.value);
            this.o.cursor && (sa = ea - 0.3) && (ea = ea + 0.3);
            this.g.beginPath();
            this.g.strokeStyle = this.previousColor;
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
            this.g.stroke();
          }
          this.g.beginPath();
          this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
          this.g.stroke();
          this.g.lineWidth = 2;
          this.g.beginPath();
          this.g.strokeStyle = this.o.fgColor;
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
          this.g.stroke();
          return false;
        }
      }
    });

    function fetchKnobData() {
      $.ajax({
        url: '/data-knob', 
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          $('#suhuKnob').val(response.suhu_udara).trigger('change');
          $('#kelembabanKnob').val(response.kelembaban_udara).trigger('change');
          $('#amoniaKnob').val(response.amonia).trigger('change');
          $('#udaraKnob').val(response.kecepatan_udara).trigger('change');
        },
        error: function(error) {
          console.log(error);
        }
      });
    }

    function fetchLineChartData1() {
      $.ajax({
        url: '/data',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          var data1 = [];
          for (var i = 0; i < response.length; i++) {
            data1.push([response[i].waktu, parseFloat(response[i].suhu_udara)]);
          }

          $.plot('#line-chart-1', [data1], {
            grid: {
              borderWidth: 1,
              borderColor: '#f3f3f3',
              tickColor: '#f3f3f3'
            },
            series: {
              lines: {
                show: true,
              },
              points: {
                show: true
              }
            },
            colors: ['#3c8dbc'],
            xaxis: {
              mode: 'categories',
              tickLength: 0
            }
          });
        },
        error: function(error) {
          console.log(error);
        }
      });
    }

    function fetchLineChartData2() {
      $.ajax({
        url: '/data2',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          var data2 = [];
          for (var i = 0; i < response.length; i++) {
            data2.push([response[i].waktu, parseFloat(response[i].kelembaban_udara)]);
          }

          $.plot('#line-chart-2', [data2], {
            grid: {
              borderWidth: 1,
              borderColor: '#f3f3f3',
              tickColor: '#f3f3f3'
            },
            series: {
              lines: {
                show: true,
              },
              points: {
                show: true
              }
            },
            colors: ['#00a65a'],
            xaxis: {
              mode: 'categories',
              tickLength: 0
            }
          });
        },
        error: function(error) {
          console.log(error);
        }
      });
    }

    function fetchLineChartData3() {
      $.ajax({
        url: '/data3',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          var data3 = [];
          for (var i = 0; i < response.length; i++) {
            data3.push([response[i].waktu, parseFloat(response[i].amonia)]);
          }

          $.plot('#line-chart-3', [data3], {
            grid: {
              borderWidth: 1,
              borderColor: '#f3f3f3',
              tickColor: '#f3f3f3'
            },
            series: {
              lines: {
                show: true,
              },
              points: {
                show: true
              }
            },
            colors: ['#f39c12'],
            xaxis: {
              mode: 'categories',
              tickLength: 0
            }
          });
        },
        error: function(error) {
          console.log(error);
        }
      });
    }

    function fetchLineChartData4() {
      $.ajax({
        url: '/data4',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          var data4 = [];
          for (var i = 0; i < response.length; i++) {
            data4.push([response[i].waktu, parseFloat(response[i].kecepatan_udara)]);
          }

          $.plot('#line-chart-4', [data4], {
            grid: {
              borderWidth: 1,
              borderColor: '#f3f3f3',
              tickColor: '#f3f3f3'
            },
            series: {
              lines: {
                show: true,
              },
              points: {
                show: true
              }
            },
            colors: ['#00c0ef'],
            xaxis: {
              mode: 'categories',
              tickLength: 0
            }
          });
        },
        error: function(error) {
          console.log(error);
        }
      });
    }

    fetchKnobData();
    setInterval(fetchKnobData, 5000);

    fetchLineChartData1();
    fetchLineChartData2();
    fetchLineChartData3();
    fetchLineChartData4();
  });
</script>
</body>
</html>
