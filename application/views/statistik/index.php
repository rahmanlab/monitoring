<?php
$PESAN = $this->session->userdata('PESAN');
?>
<script>

function modal_family(family) {
    document.getElementById("judul_header").innerHTML = "DETAIL TIKET AKTIF "+family;

    $("#tb_incident").html('<div></div>');
    var url = "<?php echo base_url('statistik/ajax_get_incident') ?>";
        //var bidang_id = $(this).prop("lang");
        $.ajax({
          type: "POST",
          url: url,
          dataType: "html",
          data: {
            family : family
          },
          beforeSend: function () {
                // non removable loading
                $('#loading_modal').modal({
                  backdrop: 'static', keyboard: false
                });
              },
              success: function (data) {
                $('#loading_modal').modal('hide');
                  var dataDetail = JSON.parse(data);
                  diagramDetail(dataDetail);
                  // console.log(dataDetail.OUT_DATA_SERVICEGROUP);
                // $("#tb_incident").html(data);
                $("#tabel_detail tbody").empty();
                $('#modal_family').modal('show');
              }
            });

      }

   function modal_tabel(family, group) {
    // $("#tb_incident").html('<div></div>');
    var url = "<?php echo base_url('statistik/ajax_get_incident') ?>";
        //var bidang_id = $(this).prop("lang");
        $.ajax({
          type: "POST",
          url: url,
          dataType: "html",
          data: {
            family : family,
            group : group
          },
          beforeSend: function () {
                // non removable loading
                $('#loading_modal').modal({
                  backdrop: 'static', keyboard: false
                });
              },
              success: function (data) {
                $('#loading_modal').modal('hide');
                  var tabelDetail = JSON.parse(data);
                  var jancuk = tabelDetail['rs_tiket'].OUT_DATA_SERVICETYPE 
                  $("#tabel_detail tbody").empty();
                    if(jancuk == ""){
                      var strRow ='<tr><td><div class="alert alert-danger"> Data Tidak Tersedia...! </div></td></tr>';
                      $("#tabel_detail tbody").append(strRow);
                    }else{
                        $("#head h3").append(group);
                        $.each(jancuk, function(index, itemData) {
                        var strRow =
                          '<tr>' +
                            '<td style="color:black">' + itemData.SERVICETYPE + '</td>' +
                            '<td style="color:black"><span class="badge bg-yellow">' + itemData.RECORD + '</span></td>' +
                           '</tr>';
                        $("#tabel_detail tbody").append(strRow);

                      });
                    }
              }
            });

      } 
  function modal_grafik(family) {
    document.getElementById("judul_header").innerHTML = "DETAIL TIKET "+family;

    $("#tb_incident").html('<div></div>');
    var url = "<?php echo base_url('statistik/ajax_get_incident_total') ?>";
        //var bidang_id = $(this).prop("lang");
        $.ajax({
          type: "POST",
          url: url,
          dataType: "html",
          data: {
            family : family
          },
          beforeSend: function () {
                // non removable loading
                $('#loading_modal').modal({
                  backdrop: 'static', keyboard: false
                });
              },
              success: function (data) {
                $('#loading_modal').modal('hide');
                $("#tb_incident").html(data);
                $('#modal_family').modal('show');
              }
            });

      } 

      $(".changeIcon").on("click",function() {
       $(".changeIcon").each(function() {
         var id_collapse = $(".changeIcon").attr("data-id");
         $("#" + id_collapse).on("shown.bs.collapse", function() {
          $("#fa_" + id_collapse).addClass("fa-minus").removeClass("fa-plus");
        });
         $("#" + id_collapse).on("hidden.bs.collapse", function() {
          $("#fa_" + id_collapse).addClass("fa-plus").removeClass("fa-minus");
        });
       });
     });

      function changeIcon(id_collapse) {
       // alert('Id = ' + id_collapse);
       $("#" + id_collapse).on('shown.bs.collapse', function() {
        $("#fa_" + id_collapse).addClass('fa-minus').removeClass('fa-plus');
      });
       $("#" + id_collapse).on('hidden.bs.collapse', function() {
        $("#fa_" + id_collapse).addClass('fa-plus').removeClass('fa-minus');
      });
     }

      // function changeIconGrid2(id_collapse2) {
      //  // alert('Id = ' + id_collapse);
      //   $("#" + id_collapse2).on('shown.bs.collapse', function() {
      //     $("." + id_collapse2).addClass('fa-minus').removeClass('fa-plus');
      //   });
      //   $("#" + id_collapse2).on('hidden.bs.collapse', function() {
      //     $("." + id_collapse2).addClass('fa-plus').removeClass('fa-minus');
      //   });
      // }

    </script>

    <style type="text/css">
    .w-auto{

      margin-bottom: 2px;
    }
    .w-auto tbody > tr > td{
      color: #000;
    }
    .w-auto > thead > tr > th, .w-auto > tbody > tr > th, .w-auto > tfoot > tr > th, .w-auto > thead > tr > td, .w-auto > tbody > tr > td, .w-auto > tfoot > tr > td {
      padding: 0px;
      line-height: 1.42857;
      vertical-align: top;
      border-top: 1px solid #DDD;
      text-align: left;  
    }
    .detil > tbody > tr > td{
      font-size: 10px;
    }

    .detil > thead > tr > th{
      font-size: 10px;
      padding-left: 5px;
      padding-right: 5px;
      background-color: #3C8DBC;
    }
    .pohon1{
      margin-left: 30px;
    }
    .scroll-y {
      max-height: auto;
      overflow-y: auto;
    }

  </style>

  <input type="hidden" value="" id="noagendaVALUE">
  <section class="content">

    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <div class="col-md-8">


        <!-- Info boxes -->


        <div class="row">
          <div class="col-md-12">

          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <!-- BAR CHART -->

            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">Grafik Tiket ITSM</h3>
                <div class="box-tools pull-right">
                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div><!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="chart-responsive">
                      <div id="family_chart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                      <!-- <canvas id="pieChart" height="150"></canvas> -->
                    </div><!-- ./chart-responsive -->
                  </div><!-- /.col -->
                </div><!-- /.row -->
              </div><!-- /.box-body -->

              <!-- /.box-header -->
              <div class="box-body">
                <div class="box-group" id="accordion"></div>
              </div>
              <!-- /.box-body -->
            </div><!-- /.box -->
          </div><!-- /.col (RIGHT) -->
        </div><!-- /.row -->
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
              <span class="info-box-icon bg-red"><i class="fa fa-file-text-o"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Tiket Aktif </span>
                <span class="info-box-number"><?php echo $tiket_aktif;?></span>
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
          </div><!-- /.col -->
          <!-- fix for small devices only -->
          <div class="clearfix visible-sm-block"></div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="fa fa-check-square-o"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Tiket Resolved</span>
                <span class="info-box-number"><?php echo $tiket_resolved;?></span>
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
          </div><!-- /.col -->
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
              Statistik Tiket Masuk H-1| Div. Pelaporan AP2T
            </span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Grafik Total Tiket dan Tiket Resolved H-1 Berdasarkan Family</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="chart">
              <div id="container"></div>
            </div>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Grafik Lainnya</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="chart">
              <div id="container-test">
                <p class="pull-right">
                  <a href="<?php echo base_url('statistik/harian');?>" class="btn btn-success btn-sm ad-click-event">
                    LIHAT STATISTIK PERHARI
                  </a>
                  <a href="<?php echo base_url('statistik/bulanan');?>" class="btn btn-success btn-sm ad-click-event">
                    LIHAT STATISTIK PERBULAN
                  </a>
                </p>
              </div>
            </div>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
  <div class="modal fade modal-primary" id="modal_family">
    <div class="modal-dialog modal-lg" style="width: 95%">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="judul_header">Detail</h4>
          </div>
          <div class="modal-body" style="background-color: #FFF !important">
            <div class="box-body scroll-y">
              <div class="row">
                  <div class="col-md-7">
                    <div class="chart-responsive">
                      <div id="detail_chart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                      <!-- <canvas id="pieChart" height="150"></canvas> -->
                    </div><!-- ./chart-responsive -->
                  </div><!-- /.col -->
                  <div class="col-md-5">
                    <div class="box-header" id="head">
                      <h3></h3>
                    </div>
                      <table class="table table-bordered" id="tabel_detail">
                        <tbody></tbody>
                      </table> 

                    </div>
                    <!-- <table class="table table-responsive w-auto">
                      <thead>
                        <tr style="border-bottom-style: none; border-top-style: none; background-color: #3C8DBC;">
                          <th style="padding: 3px 10px"> #SERVICEGROUP : Pelayanan Pelanggan</th>
                          <th></th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                    </table> -->

                    <!-- <div class="collapse in" id="colls05051" aria-expanded="true" style="">
                       <div class="card card-body">
                          <table class="table table-responsive w-auto" id="tabel_detail"> -->
                            <!-- <tbody>
                              <tr class="success">
                                <td class="bg-light-blue" scope="row" width="40px">
                                  <a class="btn btn-primary btn-xs collapsed" data-toggle="collapse" href="#colls05051child1" role="button" aria-expanded="false" aria-controls="colls05051child1">
                                    <i class="colls05051child1 fa fa-plus"></i>
                                  </a>
                                </td>

                                <td class="bg-light-blue" width="110px">SERVICETYPE : </td>
                                <td width="250px" style="padding-left:10px">10. Pelunasan Beban Kantor (24)</td>
                                <td width="50px"><span class="badge bg-red">1</span></td>
                                <td></td>
                              </tr>
                            </tbody> -->
                          </table> 
                                        
                      <!--   <div class="collapse" id="colls05051child1">
                            <div class="card card-body">
                                <div class="table-responsive" style="overflow-x:true; width:100%"> -->
                                  <!-- <table class="table table-bordered table-hover table-striped w-auto detil">
                                      <thead>
                                          <tr>
                                              <th>INCIDENT</th>
                                              <th style="padding: 0 50px">CASEOWNER</th>
                                              <th>CASEOWNEREMAIL</th>
                                              <th>COMPLAINANT</th>
                                              <th>COMPLAINANTEMAIL</th>
                                              <th style="padding: 0 100px">SUMMARY</th>
                                              <th>SOURCE</th>             
                                              <th>CALLTYPE</th>               
                                              <th>STATUS</th>
                                              <th>CREATEDBY</th>
                                              <th>SERVICEFAMILY</th>
                                              <th>SERVICEGROUP</th>
                                              <th>SERVICETYPE</th>
                                              <th> CAUSE </th>
                                              <th> RESOLUTION </th>
                                              <th> CREATEDBY </th>
                                              <th> CREATEDON </th>
                                              <th> RESOLVEDBY </th>
                                              <th> RESOLVEDON </th>
                                              <th> MODIFIEDBY </th>
                                              <th> MODIFIEDON </th>
                                              <th> CLOSEDBY </th>
                                              <th> CLOSEDDATE </th>
                                              <th> SLACLASS </th>
                                              <th> SLALEVEL1 </th>
                                              <th> SLALEVEL2 </th>
                                              <th> SLALEVEL3 </th>
                                              <th> PRIORITY </th>
                                              <th> PRIORITYNAME </th>
                                              <th> ASSIGNTO </th>
                                              <th> FIRSTCALLRESOLUTION </th>
                                              <th> ASSIGNEDON </th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <td>636245</td>
                                              <td>LIDYA ESTER</td>
                                              <td>LIDYA.ESTER@PLN.CO.ID</td>
                                              <td>Maya Melinda</td>
                                              <td>maya.melinda@pln.co.id</td>
                                              <td>AP2T - 31 Permohonan Flagging Manual</td>
                                              <td>Phone</td>             
                                              <td>Service Request</td>               
                                              <td>Active</td>
                                              <td>puja.apria</td>
                                              <td>05. AP2T</td>
                                              <td>05. Penagihan Pendapatan</td>
                                              <td>10. Pelunasan Beban Kantor (24)</td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                          </tr>
                                      </tbody>
                                  </table> -->
                    <!--             </div>                        
                            </div>
                        </div> 
                     </div>
                   </div> -->


                  </div>
                </div><!-- /.row -->
              <!-- <div id="tb_incident"> -->
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="loading_modal">
      <div class="modal-dialog modal-sm" role="document">
        <img src="<?php echo base_url('assets/dist/img/ajax-loader.gif');?>" alt="" />
      </div>
    </div>
    






    <script>
  // highcharts
  // Radialize the colors
  Highcharts.setOptions({
   colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
    return {
     radialGradient: {
      cx: 0.5,
      cy: 0.3,
      r: 0.7
    },
    stops: [
    [0, color],
            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
          };
        })
 });
    // Build the chart
    Highcharts.chart('family_chart', {
      credits: {
        enabled: false
      },
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
      },
      title: {
        text: "MONITORING TIKET AKTIF PERTANGGAL  <?php echo $waktu_kemarin['tanggal'] . ' ' . strtoupper($waktu_kemarin['bulan']) . ' ' . $waktu_kemarin['tahun']; ?>"
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          dataLabels: {
            enabled: true,
            format: '<b>{point.name}</b>: {y}',
            style: {
              color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
            },
            connectorColor: 'silver'
          }
        }
      },
      series: [{
        name: 'Persentase',
        data: [
        <?php foreach ($rs_family as $i => $family) { ?>

          { 
            name: '<?php echo $family['SERVICEFAMILY']; ?>', 
            y: <?php echo $family['TOTAL']; ?> ,

            color: {
                    //linearGradient: { x1: 0, x2: 0, y1: 0, y2: 1 },
                    radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                    stops: [
                    [0, 'YELLOW'],
                    [1, "<?php  echo $rs_warna[$i]; ?>"]
                    ]
                  },
          //  color : "<?php  echo $rs_warna[$i]; ?>" ,
          events: {
            click: function() {
             modal_family(this.name);
           }
         }

       },

       <?php }?>
       ]


     }

     ]
   });


// UNTUK MODAL DETAIL 
function diagramDetail(dataDetail) {
  var group = dataDetail['rs_tiket'].OUT_DATA_SERVICEGROUP;
  group.sort(function(a, b){return b.RECORD - a.RECORD});
  var warna = dataDetail['rs_warna'];;
  var data_warna = [];
  var data_array = [];

  var i = 0;
  group.forEach(function(value){
      data_array.push({name: value.SERVICEGROUP, 
                          y: parseInt(value.RECORD),
                          color: {
                    radialGradient: { cx: 0.5, cy: 0.5, r: 0.5 },
                    stops: [
                    [0, 'YELLOW'],
                    [1, warna[i++]]
                    ]
                  }, 
                      events: {
                                click: function() {
                                 modal_tabel(value.SERVICEFAMILY, this.name);
                                }
                              }
                      });
      
  })  

    Highcharts.chart('detail_chart', {
      credits: {
        enabled: false
      },
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
      },
      title: {
        text: "DETAIL TIKET AKTIF PERTANGGAL  <?php echo $waktu_kemarin['tanggal'] . ' ' . strtoupper($waktu_kemarin['bulan']) . ' ' . $waktu_kemarin['tahun']; ?>"
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          dataLabels: {
            enabled: true,
            format: '<b>{point.name}</b>: {y}',
            style: {
              color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
            },
            connectorColor: 'silver'
          }
        }
      },
      series: [{
        name: 'Persentase',
        data: data_array
     }
     ]
   });
}
 </script>




 <script type="text/javascript">
  // bar chart
  Highcharts.chart('container', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Grafik Tiket Per H-1'
    },
    xAxis: {
      categories: [
      <?php foreach ($rs_total_resolved['SERVICEFAMILY']  as $nama_family) {
        echo "'".substr($nama_family, 4)."',";
      } ?>
      //'AP2T',
      // 'P2APST',
      // 'BBO'
      ]
    },
    yAxis: [{
      min: 0,
      title: {
        text: 'Tiket'
      }
    }, {
      title: {
        text: ''
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
        name: 'Total Tiket',
        color: 'rgb(176,224,230)',
        data: [ 
        <?php foreach ($rs_total_resolved['TOTAL']  as $total_tiket) {
          echo $total_tiket.",";
        } ?>
                // 150, 
                // 73, 
                // 20
        ],
        pointPadding: 0.0,
        point: {
             events: {
                click: function() {
                    modal_grafik(this.category);
                    // alert ('Category: '+ this.category +', value: '+ this.y);
                }
            }
        },

      }, 
      {
        name: 'Tiket Resolved',
        color: 'rgb(30,144,255)',
        data: [
        <?php foreach ($rs_total_resolved['TOTAL_RS']  as $total_rs) {
          echo $total_rs.",";
        } ?>
        //140, 90, 40
        ],
        pointPadding: 0.1,

      }
    ]
  });
</script>
<script>
  // $(function () {
  //   $('#family_detail').DataTable()
  // })
</script>

<script type="text/javascript">

  function cari(d) {

    var familyGroup = d.getAttribute("data-id");
    var table;
    table = $('#tb_'+familyGroup).DataTable({
      "ajax": {
        "url": "<?php echo base_url('statistik/dokumen_load_params') ?>",
        "type": "POST",
        "data": {"family": familyGroup},
      },
      "paging": true,
            // "pageLength": 3,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false,
          });
        // $('#bcari').attr('disabled', 'disabled');
        table.destroy();
      }


    </script>

    <!-- ChartJS 1.0.1 -->
    <script src="<?php echo base_url('assets/plugins/chartjs/Chart.min.js');?>"></script>
    <!-- page script -->
