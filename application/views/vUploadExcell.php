
<input type="hidden" value="" id="noagendaVALUE">
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <form id="form_upload" class="form-horizontal" method="POST" enctype="multipart/form-data" action="<?php echo base_url('cexcell/importDataExcell')?>">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
								<div class="form-group">
                                    <label class="col-sm-3 control-label"><strong>File Import</strong></label>
                                    <div class="col-sm-7">
                                       <input type="file" name="file" value="" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="btn-group">
                            <button class="btn btn-primary"><span class="fa fa-print"><strong> Upload Data To ITSM </strong></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr style="background-color:#9C0; color:white;">
                                    <th width="5%">INCIDENT</th>
                                    <th width="10%">CASEOWNER</th>
                                    <th width="10%">CASEOWNEREMAIL</th>
                                    <th width="5%">COMPLAINANT</th>
                                    <th width="10%">COMPLAINANTEMAIL</th>
                                    <th width="15%">SUMMARY</th>
                                    <th width="5%">SOURCE</th>				
                                    <th width="5%">CALLTYPE</th>				
                                    <th width="5%">STATUS</th>
                                    <th width="5%">CREATEDBY</th>
                                    <th width="5%">SERVICEFAMILY</th>
                                    <th width="10%">SERVICEGROUP</th>
                                    <th width="10%">SERVICETYPE</th>
                                </tr>
                            </thead>
							<?php
							foreach($uploadItsm as $itsm){
							//foreach($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_LOBS)){	
							?>
							<tbody>
							    <td><?php echo number_format($itsm['INCIDENT'], 0, '', '');?></td>
								<td><?php echo $itsm['CASEOWNER'];?></td>
								<td><?php echo $itsm['CASEOWNEREMAIL'];?></td>
								<td><?php echo $itsm['COMPLAINANT'];?></td>
								<td><?php echo $itsm['COMPLAINANTEMAIL'];?></td>
								<td><?php echo $itsm['SUMMARY'];?></td>
								<td><?php echo $itsm['SOURCE'];?></td>
								<td><?php echo $itsm['CALLTYPE'];?></td>
								<td><?php echo $itsm['STATUS'];?></td>
								<td><?php echo $itsm['CREATEDBY'];?></td>
								<td><?php echo $itsm['SERVICEFAMILY'];?></td>
								<td><?php echo $itsm['SERVICEGROUP'];?></td>
								<td><?php echo $itsm['SERVICETYPE'];?></td>
							</tbody>
							<?php };?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

</section>
<script type="text/javascript">

    /*
    // set first

    function loaddata() {
        var noagenda = $('#noagenda').val();
        var noba = $('#noba').val();
        var no_tiket = $('#no_tiket').val();
        var jenis_transaksi = $('#jenis_transaksi').val();
        var tgl_catat = $('#tgl_catat').val();
        var perihal = $('#perihal').val();
        var idpel = $('#idpel').val();
        var id_user = $('#id_user').val();
        var table;
        table = $('#table').DataTable({
            "ajax": {
                "url": "<?php echo base_url('home/dokumen_load_params') ?>",
                "type": "POST",
                "data": {"noagenda": noagenda, "noba": noba, "jenis_transaksi": jenis_transaksi, "id_user": id_user, "idpel": idpel, "no_tiket": no_tiket, "tgl_catat": tgl_catat, "perihal": perihal},
            },
            "paging": false,
            // "pageLength": 3,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false,
        });
        // $('#bcari').attr('disabled', 'disabled');
        table.destroy();
    } */

</script>