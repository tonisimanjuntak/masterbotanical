<?php  
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
?>


  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Dashboard Management</h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">Dashboard Management</li>
      </ol>
      
    </div>
  </div>
  
  <div class="row" id="toni-content">
    <div class="col-md-12">
      <div class="card" id="cardcontent">
        <div class="card-body">


            <div class="row">
              <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><i class="fa fa-shopping-cart"></i> <span id="jlhorder">0</span></h3>
                    <p>New Orders On Progress</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="<?php echo site_url('penjualankonfirmasi') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3><i class="fa fa-registered"></i> <span id="jlhnewkonsumen">0</span></h3>

                    <p>New Costumer</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3><i class="fa fa-envelope"></i> <span id="jlhfreeconsultation">0</span></h3>
                    <p>New Free Consultation</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="<?php echo site_url('consultation') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3><i class="fa fa-boxes"></i> <span id="jlhoutofstock">0</span></h3>
                    <p>Out Of Stock</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="<?php echo site_url('batchnumber') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>


              <div class="col-6">
                <div class="card">
                  <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                      <h3 class="card-title">Grafik Penjualan</h3>
                      <!-- <a href="javascript:void(0);">View Report</a> -->
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex">
                      <p class="d-flex flex-column">
                        <span class="text-bold text-lg"><span id="totalsemua">0</span></span>
                        <span>Penjualan Bulan Ini</span>
                      </p>
                      <p class="ml-auto d-flex flex-column text-right">
                        <span class="text-success">
                          <span id="averagebulanini">$0</span>
                        </span>
                        <span class="text-muted">Rata-rata Perhari</span>
                      </p>
                    </div>

                    <div class="position-relative mb-4">
                      <canvas id="penjualan-chart" height="200"></canvas>
                    </div>

                    <div class="d-flex flex-row justify-content-end">
                      <span class="mr-2">
                        <i class="fas fa-square text-primary"></i> Penjualan
                      </span>

                      <!-- <span>
                        <i class="fas fa-square text-gray"></i> Rata-Rata
                      </span> -->
                    </div>
                  </div>
                </div> <!-- card -->
              </div>



              <div class="col-lg-6">
                <div class="card">
                  <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                      <h3 class="card-title">Penjualan Tahun Ini</h3>
                      <!-- <a href="javascript:void(0);">View Report</a> -->
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex">
                      <p class="d-flex flex-column">
                        <span class="text-bold text-lg"><span id="totalsemuatahunini">0</span></span>
                        <span>Penjualan Tahun Ini</span>
                      </p>
                      <p class="ml-auto d-flex flex-column text-right">
                        <span class="text-success">
                           <span id="averagetahunini">$0</span>
                        </span>
                        <span class="text-muted">Rata-rata Perbulan</span>
                      </p>
                    </div>

                    <div class="position-relative mb-4">
                      <canvas id="visitors-chart" height="200"></canvas>
                    </div>

                    <div class="d-flex flex-row justify-content-end">
                      <span class="mr-2">
                        <i class="fas fa-square text-primary"></i> Penjualan
                      </span>

                      <span>
                        <i class="fas fa-square text-gray"></i> Rata-Rata
                      </span>
                    </div>
                  </div>
                </div>
              </div>


            </div>


        </div> <!-- ./card-body -->
      </div> <!-- /.card -->
    </div> <!-- /.col -->
  </div> <!-- /.row -->
  <!-- Main row -->



<?php $this->load->view("template/footer") ?>

<!-- ChartJS -->
<script src="<?php echo (base_url()) ?>assets/adminlte/plugins/chart.js/Chart.min.js"></script>


<script>
  

$(document).ready(function() {
  
  $.ajax({
      url: '<?php echo site_url("dashboardmanagement/getinfobox") ?>',
      type: 'GET',
      dataType: 'json',
    })
    .done(function(resultinfo) {
      // console.log(resultinfo);
      $('#jlhorder').html(resultinfo.jlhorder);
      $('#jlhnewkonsumen').html(resultinfo.jlhnewkonsumen);
      $('#jlhfreeconsultation').html(resultinfo.jlhfreeconsultation);
      $('#jlhoutofstock').html(resultinfo.jlhoutofstock);

    })
    .fail(function() {
      console.log("error");
    });
  
  
      
});

$(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true


  // =============================== Chart Penjualan Bulan INI ======================================
  $.ajax({
    url: '<?php echo site_url("dashboardmanagement/getchartbulanini") ?>',
    type: 'GET',
    dataType: 'json',
  })
  .done(function(resultbulanini) {
    // console.log(resultbulanini);

    $('#averagebulanini').html('$'+resultbulanini.averagebulanini);
    $('#totalsemua').html('$'+resultbulanini.totalsemua);
    var $penjualanChart = $('#penjualan-chart')
    var penjualanChart = new Chart($penjualanChart, {
      type: 'bar',
      data: {
        labels: resultbulanini.tanggalpenjualan,
        datasets: [
          {
            backgroundColor: '#007bff',
            borderColor: '#007bff',
            data: resultbulanini.totalpenjualan
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            // display: false,
            gridLines: {
              display: true,
              lineWidth: '4px',
              color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks: $.extend({
              beginAtZero: true,

              // Include a dollar sign in the ticks
              callback: function (value) {
                if (value >= 1000) {
                  value /= 1000
                  value += 'k'
                }

                return '$' + value
              }
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: false
            },
            ticks: ticksStyle
          }]
        }
      }
    })
  })
  .fail(function() {
    console.log("error get chart bulan ini");
  });



  // =============================== Chart Penjualan Tahun INI ======================================

  $.ajax({
    url: '<?php echo site_url('dashboardmanagement/getcharttahunini') ?>',
    type: 'GET',
    dataType: 'json',
  })
  .done(function(resulttahunini) {
    // console.log(resulttahunini);
    $('#totalsemuatahunini').html('$'+resulttahunini.totalsemua);
    $('#averagetahunini').html('$'+resulttahunini.averagetahunini)
    var $visitorsChart = $('#visitors-chart')
    var visitorsChart = new Chart($visitorsChart, {
      data: {
        labels: resulttahunini.bulanpenjualan,
        datasets: [{
          type: 'line',
          data: resulttahunini.totalpenjualan,
          backgroundColor: 'transparent',
          borderColor: '#007bff',
          pointBorderColor: '#007bff',
          pointBackgroundColor: '#007bff',
          fill: false
          // pointHoverBackgroundColor: '#007bff',
          // pointHoverBorderColor    : '#007bff'
        },
        {
          type: 'line',
          data: resulttahunini.totalaverage,
          backgroundColor: 'tansparent',
          borderColor: '#ced4da',
          pointBorderColor: '#ced4da',
          pointBackgroundColor: '#ced4da',
          fill: false
          // pointHoverBackgroundColor: '#ced4da',
          // pointHoverBorderColor    : '#ced4da'
        }]
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            // display: false,
            gridLines: {
              display: true,
              lineWidth: '4px',
              color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks: $.extend({
              beginAtZero: true,
              suggestedMax: 200
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: false
            },
            ticks: ticksStyle
          }]
        }
      }
    })
  })
  .fail(function() {
    console.log("error get chart tahun ini");
  });
  
})


</script>
</body>
</html>

