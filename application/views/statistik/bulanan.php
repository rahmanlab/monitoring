<?php
$PESAN = $this->session->userdata('PESAN');
?>
<input type="hidden" value="" id="noagendaVALUE">
<section class="content">
  <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    <div class="col-md-8">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <form id="form_upload" action="<?php echo site_url('statistik/search_process/'); ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" >
              <div class="box-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="col-sm-12 control-label"> STATISTIK PADA BULAN  </label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <div class="col-sm-12">
                        <select name="bulan" id="bulan" class="form-control">
                          <option value="">--- Pilih Bulan ---</option>
                          <?php foreach ($rs_bulan as $mm => $month) { ?>
                          <option value="<?php echo $mm; ?>" <?php if ($search['bulan'] == $mm) {
                            echo " selected";
                          } ?> ><?php echo $month; ?></option>   
                          <?php } ?>
                        </select>
                      </div>
                    </div>                                  
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <div class="col-sm-12">
                        <select name="tahun" id="tahun" class="form-control">
                          <option value="">--- Pilih Tahun ---</option>
                          <?php foreach ($rs_tahun as $index => $tahun) { ?>
                          <option value="<?php echo $tahun; ?>" <?php if ($search['tahun'] == $tahun) {
                            echo " selected";
                          } ?>><?php echo $tahun; ?></option>   
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <div class="col-sm-12">
                        <button class="btn btn-primary" id="bcari"  name="button" value="cari" ><i class="fa fa-search fa-fw"></i> Cari</button>
                        <button class="btn btn-default" name="button" value="reset"><i class="fa  fa-refresh fa-fw" ></i> Reset</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Tiket</span>
              <span class="info-box-number"><?php echo $total_tiket;?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </div><!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-clock-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total OverSLA</span>
              <span class="info-box-number"><?php echo $tiket_oversla;?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </div><!-- /.col -->
        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-check-square-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Resolved</span>
              <span class="info-box-number"><?php echo $tiket_resolved;?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </div><!-- /.col -->
      </div><!-- /.row -->
      <div class="row">
        <div class="col-md-12">
          <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Grafik Tiket Bulan <?php echo $waktu_sekarang['bulan'];?></h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <div id="totat_tiket_barchart"></div>
              </div>
            </div><!-- /.box-body -->
          </div><!-- /.box -->

        </div><!-- /.col (RIGHT) -->
      </div><!-- /.row -->

      <div class="row">
        <div class="col-md-12">
          <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Grafik Tiket Bulan <?php echo $waktu_sekarang['bulan'];?></h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <div id="totat_sla_barchart"></div>
              </div>
            </div><!-- /.box-body -->
          </div><!-- /.box -->

        </div><!-- /.col (RIGHT) -->
      </div><!-- /.row -->




    </div><!-- /.col -->





    <div class="col-md-4">
      <!-- Info Boxes Style 2 -->
      <div class="info-box bg-yellow">
        <span class="info-box-icon"><i class="glyphicon glyphicon-calendar"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Jakarta, Indonesia</span>
          <span class="info-box-number"><?php echo $waktu_sekarang['hari'] . ', ' . $waktu_sekarang['tanggal'] . ' ' . $waktu_sekarang['bulan'] . ' ' . $waktu_sekarang['tahun']; ?></span>
          <div class="progress">
            <div class="progress-bar" style="width: 50%"></div>
          </div>
          <span class="progress-description">
            Statistik Tiket Masuk | Div. Pelaporan AP2T
          </span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->

      <!-- BAR CHART -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Grafik Tiket Tahun <?php echo $search['tahun'];?></h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="chart">
            <canvas id="barChart" style="height:230px"></canvas>
          </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
      <!-- PRODUCT LIST -->
      <!-- /.box -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Grafik Tiket Berdasarkan Jenis Transaksi Tahun <?php echo $search['tahun'];?></h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-8">
              <div class="chart-responsive">
                <canvas id="pieChart" height="150"></canvas>
              </div><!-- ./chart-responsive -->
            </div><!-- /.col -->
            <div class="col-md-4">
              <ul class="chart-legend clearfix">
                <li><i class="fa fa-circle-o text-red"></i><?php  echo $rs_jml_pertransaksi[0]['JENIS_TRANSAKSI']; ?></li>
                <li><i class="fa fa-circle-o text-green"></i><?php  echo $rs_jml_pertransaksi[1]['JENIS_TRANSAKSI']; ?></li>
                <li><i class="fa fa-circle-o text-yellow"></i><?php  echo $rs_jml_pertransaksi[2]['JENIS_TRANSAKSI']; ?></li>
                <li><i class="fa fa-circle-o text-aqua"></i><?php  echo $rs_jml_pertransaksi[3]['JENIS_TRANSAKSI']; ?></li>
                <li><i class="fa fa-circle-o text-light-blue"></i><?php  echo $rs_jml_pertransaksi[4]['JENIS_TRANSAKSI']; ?></li>
                <li><i class="fa fa-circle-o text-gray"></i><?php  echo $rs_jml_pertransaksi[5]['JENIS_TRANSAKSI']; ?></li>
              </ul>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.box-body -->
        <div class="box-footer no-padding">
          <ul class="nav nav-pills nav-stacked">
            <?php if(isset($rs_jml_pertransaksi[0]['TOTAL_PERTRANSAKSI'])){ 
              $total = 0;
              for ($i=0; $i <= 5 ; $i++) { 
                $total = $total + $rs_jml_pertransaksi[$i]['TOTAL_PERTRANSAKSI'];
              }
              foreach ($rs_jml_pertransaksi as $row) {
                $persen = ($row['TOTAL_PERTRANSAKSI'] / $total) * 100 ;

                ?>

                <li><a href="#"><?php echo $row['JENIS_TRANSAKSI']; ?> <span class="pull-right text-green"><i class="fa fa-angle-right"></i> <?php echo round($persen); ?>%</span>
                  <?php } ?>


                </a></li>
                <?php } else { ?>
                <li><a href="#">Data Kosong<span class="pull-right text-green"><i class="fa fa-angle-right"></i> </span></a></li>
                <?php  }?>
              </ul>
            </div><!-- /.footer -->
          </div><!-- /.box -->


        </div><!-- /.col -->
      </div><!-- /.row -->
    </section><!-- /.content -->
    



    <script type="text/javascript">
  // Bar Chart total tiket
  Highcharts.chart('totat_tiket_barchart', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Total Tiket'
    },
    xAxis: {
      categories: [
      <?php foreach ($rs_total_tiket as $nama_family) {
        echo "'".$nama_family['SERVICEFAMILY']."',";
      } ?>
      
      ]
    },
    yAxis: [{
      min: 0,
      title: {
        text: 'Employees'
      }
    }, {
      title: {
        text: 'Profit (millions)'
      },
      opposite: true
    }],
    legend: {
      shadow: false
    },
    tooltip: {
      shared: true
    },
    plotOptions: {
      column: {
        grouping: false,
        shadow: false,
        borderWidth: 0
      }
    },
    series: [
    // {
    //     name: 'Total Tiket',
    //     color: 'rgba(165,170,217,1)',
    //     data: [150, 73, 20],
    //     pointPadding: 0.3,

    // }, 
    {
      name: 'TOTAL TIKET',
      color: 'rgba(126,86,134,.9)',
      data: [
<?php foreach ($rs_total_tiket  as $total_tiket) {
        echo $total_tiket['TOTAL'].",";
      } ?>
      //140, 90, 40
      ],
      pointPadding: 0.1,

    }]
  });
</script>
<script type="text/javascript">
  // Bar Chart total SLA
  Highcharts.chart('totat_sla_barchart', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Tiket Over SLA'
    },
    xAxis: {
      categories: [

      <?php foreach ($rs_tiket_sla as $data) {
        echo "'".$data['SERVICEFAMILY']."',";
      } ?>
      
      ]
    },
    yAxis: [{
      min: 0,
      title: {
        text: 'Employees'
      }
    }, {
      title: {
        text: 'Profit (millions)'
      },
      opposite: true
    }],
    legend: {
      shadow: false
    },
    tooltip: {
      shared: true
    },
    plotOptions: {
      column: {
        grouping: false,
        shadow: false,
        borderWidth: 0
      }
    },
    series: [
    {
      name: 'Over SLA',
      color: 'rgba(165,170,217,1)',
      data: [
<?php foreach ($rs_tiket_sla  as $data) {
        echo $data['TOTAL_SLA'].",";
      } ?>
      ],
      pointPadding: 0.1,

    }, 
    // {
    //     name: 'Tiket Resolved',
    //     color: 'rgba(126,86,134,.9)',
    //     data: [140, 90, 40],
    //     pointPadding: 0.4,

    // }
    ]
  });
</script>





<!-- ChartJS 1.0.1 -->
<script src="<?php echo base_url('assets/plugins/chartjs/Chart.min.js');?>"></script>
<!-- page script -->
<script>
  $(function () {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */
         var areaChartData = {
          labels: [
          <?php foreach ($rs_tiket_bulanan as $dt_tiket) { 
            $dt = DateTime::createFromFormat('!m', $dt_tiket['BULAN']);
            echo '"' . $dt->format('M') . '",' ;
          }?>
          ],
          datasets: [
          {
            label: "Electronics",
            fillColor: "rgba(210, 214, 222, 1)",
            strokeColor: "rgba(210, 214, 222, 1)",
            pointColor: "rgba(210, 214, 222, 1)",
            pointStrokeColor: "#c1c7d1",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: [
            <?php foreach ($rs_tiket_bulanan as $dt_tiket) { 
              echo $dt_tiket['TIKET_PERBULAN'] . ',';
            }?>
            ]
          }
          ]
        };



        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
        var PieData = [
        <?php if(isset($rs_jml_pertransaksi[0]['TOTAL_PERTRANSAKSI'])){ ?>

          {
            value: <?php  echo $rs_jml_pertransaksi[0]['TOTAL_PERTRANSAKSI']; ?>,
            color: "#f56954",
            highlight: "#f56954",
            label: "<?php  echo $rs_jml_pertransaksi[0]['JENIS_TRANSAKSI']; ?>"
          },
          {
            value: <?php  echo $rs_jml_pertransaksi[1]['TOTAL_PERTRANSAKSI']; ?>,
            color: "#00a65a",
            highlight: "#00a65a",
            label: "<?php  echo $rs_jml_pertransaksi[1]['JENIS_TRANSAKSI']; ?>"
          },
          {
            value: <?php  echo $rs_jml_pertransaksi[2]['TOTAL_PERTRANSAKSI']; ?>,
            color: "#f39c12",
            highlight: "#f39c12",
            label: "<?php  echo $rs_jml_pertransaksi[2]['JENIS_TRANSAKSI']; ?>"
          },
          {
            value: <?php  echo $rs_jml_pertransaksi[3]['TOTAL_PERTRANSAKSI']; ?>,
            color: "#00c0ef",
            highlight: "#00c0ef",
            label: "<?php  echo $rs_jml_pertransaksi[3]['JENIS_TRANSAKSI']; ?>"
          },
          {
            value: <?php  echo $rs_jml_pertransaksi[4]['TOTAL_PERTRANSAKSI']; ?>,
            color: "#3c8dbc",
            highlight: "#3c8dbc",
            label: "<?php  echo $rs_jml_pertransaksi[4]['JENIS_TRANSAKSI']; ?>"
          },
          {
            value: <?php  echo $rs_jml_pertransaksi[5]['TOTAL_PERTRANSAKSI']; ?>,
            color: "#d2d6de",
            highlight: "#d2d6de",
            label: "<?php  echo $rs_jml_pertransaksi[5]['JENIS_TRANSAKSI']; ?>"
          }
          <?php }else{ ?> 

            {
              value: 1,
              color: "#d2d6de",
              highlight: "#d2d6de",
              label: "Data kosong."
            }

            <?php } ?>
            ];
            var pieOptions = {
          //Boolean - Whether we should show a stroke on each segment
          segmentShowStroke: true,
          //String - The colour of each segment stroke
          segmentStrokeColor: "#fff",
          //Number - The width of each segment stroke
          segmentStrokeWidth: 2,
          //Number - The percentage of the chart that we cut out of the middle
          percentageInnerCutout: 50, // This is 0 for Pie charts
          //Number - Amount of animation steps
          animationSteps: 100,
          //String - Animation easing effect
          animationEasing: "easeOutBounce",
          //Boolean - Whether we animate the rotation of the Doughnut
          animateRotate: true,
          //Boolean - Whether we animate scaling the Doughnut from the centre
          animateScale: false,
          //Boolean - whether to make the chart responsive to window resizing
          responsive: true,
          // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire 
          maintainAspectRatio: true,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions);

        //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $("#barChart").get(0).getContext("2d");
        var barChart = new Chart(barChartCanvas);
        var barChartData = areaChartData;
        barChartData.datasets[0].fillColor = "#00a65a";
        barChartData.datasets[0].strokeColor = "#00a65a";
        barChartData.datasets[0].pointColor = "#00a65a";
        var barChartOptions = {
          //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
          scaleBeginAtZero: true,
          //Boolean - Whether grid lines are shown across the chart
          scaleShowGridLines: true,
          //String - Colour of the grid lines
          scaleGridLineColor: "rgba(0,0,0,.05)",
          //Number - Width of the grid lines
          scaleGridLineWidth: 1,
          //Boolean - Whether to show horizontal lines (except X axis)
          scaleShowHorizontalLines: true,
          //Boolean - Whether to show vertical lines (except Y axis)
          scaleShowVerticalLines: true,
          //Boolean - If there is a stroke on each bar
          barShowStroke: true,
          //Number - Pixel width of the bar stroke
          barStrokeWidth: 2,
          //Number - Spacing between each of the X value sets
          barValueSpacing: 5,
          //Number - Spacing between data sets within X values
          barDatasetSpacing: 1,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
          //Boolean - whether to make the chart responsive
          responsive: true,
          maintainAspectRatio: true
        };

        barChartOptions.datasetFill = false;
        barChart.Bar(barChartData, barChartOptions);
      });
    </script>
