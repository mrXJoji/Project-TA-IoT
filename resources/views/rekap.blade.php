<!DOCTYPE html>
<html lang="en">
<head>
    <title>IOT Monitoring</title>
    @include('tools-admin.head')
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .latest-values-table, .decision-making-table, .history-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 0.9em;
            background-color: #fff;
            box-shadow: 0 2px 3px rgba(0,0,0,0.1);
        }
        .latest-values-table th, .latest-values-table td,
        .decision-making-table th, .decision-making-table td,
        .history-table th, .history-table td {
            border: 1px solid #ddd;
            padding: 12px;
        }
        .latest-values-table th, .decision-making-table th, .history-table th {
            background-color: #f1f1f1;
            color: #333;
            text-transform: uppercase;
        }
        .decision-making-table tfoot td {
            font-size: 0.875em;
            color: #777;
        }
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 3px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
            border-radius: 8px 8px 0 0;
            padding: 15px;
        }
        .card-title {
            margin: 0;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .brand-link {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }
        .brand-link h4 {
            margin: 0;
            font-size: 1.2em;
            font-weight: 700;
        }
        .pagination {
            margin-top: 20px;
            justify-content: center;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        @include('tools-admin.navbar')

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="" class="brand-link">
                <center>
                  <h4>SISTEM MONITORING</h6>
                  <h4>POLUSI UDARA</h6>
                </center>
              </a>

            <!-- Sidebar -->
            @include('tools-admin.sidebar')
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Halaman Hasil Keputusan</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Keputusan berdasarkan Data Sensor</h3>
                                </div>
                                <div class="card-body">
                                    <h4>Nilai Terbaru</h4>
                                    <table class="latest-values-table">
                                        <thead>
                                            <tr>
                                                <th>Indikator</th>
                                                <th>Nilai Terbaru</th>
                                                <th>Kategori</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Suhu Udara</td>
                                                <td>{{ $latestValues['suhu'] ? $latestValues['suhu'] . ' °C' : 'Data tidak tersedia' }}</td>
                                                <td>{{ $latestValues['suhu'] ? $kategori['suhu'] : 'Data tidak tersedia' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Kelembaban</td>
                                                <td>{{ $latestValues['kelembaban'] ? $latestValues['kelembaban'] . ' %' : 'Data tidak tersedia' }}</td>
                                                <td>{{ $latestValues['kelembaban'] ? $kategori['kelembaban'] : 'Data tidak tersedia' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Gas Amonia</td>
                                                <td>{{ $latestValues['amonia'] ? $latestValues['amonia'] . ' ppm' : 'Data tidak tersedia' }}</td>
                                                <td>{{ $latestValues['amonia'] ? $kategori['amonia'] : 'Data tidak tersedia' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Kecepatan Udara</td>
                                                <td>{{ $latestValues['udara'] ? $latestValues['udara'] . ' km/h' : 'Data tidak tersedia' }}</td>
                                                <td>{{ $latestValues['udara'] ? $kategori['udara'] : 'Data tidak tersedia' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <h4>Hasil</h4>
                                    <table class="decision-making-table">
                                        <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $outputKondisi }}</td>
                                                <td>{{ $tindakan }}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- Tombol Cetak -->
                                    <div class="mt-3">
                                        <a href="{{url('generate-pdf')}}" class="btn btn-primary">Cetak PDF</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data History</h3>
                                </div>
                                <div class="card-body">
                                    <table id="historyTable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Waktu</th>
                                                <th>Suhu Udara (°C)</th>
                                                <th>Kelembaban (%)</th>
                                                <th>Gas Amonia (ppm)</th>
                                                <th>Kecepatan Udara (km/h)</th>
                                                <th>Status</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($latestDataHasil as $history)
                                            <tr>
                                                <td>{{ $history['created_at'] }}</td>
                                                <td>{{ $history['suhu'] }}</td>
                                                <td>{{ $history['kelembaban'] }}</td>
                                                <td>{{ $history['amonia'] }}</td>
                                                <td>{{ $history['udara'] }}</td>
                                                <td>{{ $history['outputKondisi'] }}</td>
                                                <td>{{ $history['tindakan'] }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-center mt-4">
                                        {{ $latestDataHasil->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    @include('tools-admin.script')
    <script>
        $(document).ready(function() {
            $('#historyTable').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "responsive": true
            });
        });
        function checkForNotifications() {
            $.ajax({
                url: '/api/notifications',
                method: 'GET',
                success: function(response) {
                    if (response.NotifBaru) {
                        alert('Notifikasi baru: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Error: " + error);
                }
            });
        }
        setInterval(checkForNotifications, 600000);
    </script>
</body>
</html>
