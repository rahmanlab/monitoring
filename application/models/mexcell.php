<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
  
class mexcell extends CI_Model {

   function __construct()
    {
        parent::__construct();
        // set koneksi
        $this->pblmig_db = $this->load->database('pblmig', true);
        if (!$this->pblmig_db) {
            $m = oci_error();
            trigger_error(htmlentities($m['message']), E_USER_ERROR);
        }
    }  

    function save_data_dokumen($save) {
        // set koneksi
        $this->pblmig_db = $this->load->database('pblmig', true);
        if (!$this->pblmig_db) {
            $m = oci_error();
            trigger_error(htmlentities($m['message']), E_USER_ERROR);
        }
        $results = '';
        $msg_out = 'TEST';

        $insert = 'INSERT INTO UPLOAD_LOG(ID_UPLOAD,NOAGENDA,NAMA_FILE,MDD,MDB) 
                   VALUES(:ID_UPLOAD, :NOAGENDA, :NAMA_FILE, CURRENT_TIMESTAMP, :MDB)';
        $send = oci_parse($this->pblmig_db->conn_id, $insert);
        //Send parameters variable  value  lenght
        oci_bind_by_name($send, ':ID_UPLOAD', $save['id_upload']) or die('Error binding string1');
        oci_bind_by_name($send, ':NOAGENDA', $save['noagenda']) or die('Error binding string2');
        oci_bind_by_name($send, ':NAMA_FILE', $save['nama_file']) or die('Error binding string3');
        oci_bind_by_name($send, ':MDB', $this->session->userdata('id_user')) or die('Error binding string4');

        if (oci_execute($send)) {
            $results = $msg_out;
        } else {
            $e = oci_error($send);
            $results = $e['message'];
        }
        oci_free_statement($send);
        oci_close($this->pblmig_db->conn_id);

        return $results;
    }

    // insert
    public function insert_old($params) {
        // set koneksi
        $this->pblmig_db = $this->load->database('pblmig', true);
        if (!$this->pblmig_db) {
            $m = oci_error();
            trigger_error(htmlentities($m['message']), E_USER_ERROR);
        }
        return $this->pblmig_db->insert('TIKET_ITSM_UPLOAD', $params);
    }

    // update
    public function update($params, $where) {
        // set koneksi
        $this->pblmig_db = $this->load->database('pblmig', true);
        if (!$this->pblmig_db) {
            $m = oci_error();
            trigger_error(htmlentities($m['message']), E_USER_ERROR);
        }
        return $this->pblmig_db->update('UPLOAD_LOG', $params, $where);
    }
    
    
    // detail data
    public function get_file_by_id($params) {
        $sql = "SELECT *
                FROM UPLOAD_LOG 
                WHERE ID_UPLOAD = ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // list data
    public function get_list_data_upload_itsm() {
        $sql = "select * from faisallubis.TIKET_ITSM_UPLOAD WHERE ROWNUM < 20";
        /* $stid = oci_parse ($sql);
        oci_execute($stid);
        $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_LOBS);
        return $row; */
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->result();
            return $result;
        } else {
            return array();
        }
    }


    // insert clob
    public function insert($params) {
        //print_r($params);exit();
        // Before running, create the table:
        //     CREATE TABLE MYTABLE (mykey NUMBER, myclob CLOB);

        $conn = $this->pblmig_db->conn_id;

        $sql = "INSERT INTO faisallubis.TIKET_ITSM_UPLOAD (INCIDENT, CASEOWNER, CASEOWNEREMAIL, COMPLAINANT, COMPLAINANTEMAIL, SUMMARY, SOURCE, CALLTYPE, STATUS, DESCRIPTION, SERVICEFAMILY, SERVICEGROUP, SERVICETYPE, CAUSE, RESOLUTION, CREATEDBY, CREATEDON, RESOLVEDBY, RESOLVEDON, MODIFIEDBY, MODIFIEDON, CLOSEDBY, CLOSEDON, SLACLASS, SLALEVEL1, SLALEVEL2, SLALEVEL3, PRIORITY, PRIORITYNAME, ASSIGNTO, FIRSTCALLRESOLUTION, ASSIGNEDON, TGLUPLOAD, UPLOADBY)
                VALUES (:INCIDENT, :CASEOWNER, :CASEOWNEREMAIL, COMPLAINANT, :COMPLAINANTEMAIL, :SUMMARY, :SOURCE, :CALLTYPE, :STATUS, :DESCRIPTION, :SERVICEFAMILY, :SERVICEGROUP, :SERVICETYPE, :CAUSE, :RESOLUTION, :CREATEDBY, :CREATEDON, :RESOLVEDBY, :RESOLVEDON, :MODIFIEDBY, :MODIFIEDON, :CLOSEDBY, :CLOSEDON, :SLACLASS, :SLALEVEL1, :SLALEVEL2, :SLALEVEL3, :PRIORITY, :PRIORITYNAME, :ASSIGNTO, :FIRSTCALLRESOLUTION, :ASSIGNEDON, SYSDATE, :UPLOADBY)";
                //RETURNING myclob INTO :myclob";

        $stid = oci_parse($conn, $sql);
        //$clob = oci_new_descriptor($conn, OCI_D_LOB);
        oci_bind_by_name($stid, ":INCIDENT", $params['INCIDENT'], 5);
        oci_bind_by_name($stid, ":CASEOWNER", $params['CASEOWNER'], 5);
        oci_bind_by_name($stid, ":CASEOWNEREMAIL", $params['CASEOWNEREMAIL'], 5);
        oci_bind_by_name($stid, ":COMPLAINANT", $params['COMPLAINANT'], 5);
        oci_bind_by_name($stid, ":COMPLAINANTEMAIL", $params['COMPLAINANTEMAIL'], 5);
        oci_bind_by_name($stid, ":SUMMARY", $params['SUMMARY'], 5);
        oci_bind_by_name($stid, ":SOURCE", $params['SOURCE'], 5);
        oci_bind_by_name($stid, ":CALLTYPE", $params['CALLTYPE'], 5);
        oci_bind_by_name($stid, ":STATUS", $params['STATUS'], 5);
        oci_bind_by_name($stid, ":DESCRIPTION", $params['DESCRIPTION'], -1, OCI_B_CLOB);
        oci_bind_by_name($stid, ":SERVICEFAMILY", $params['SERVICEFAMILY'], 5);
        oci_bind_by_name($stid, ":SERVICEGROUP", $params['SERVICEGROUP'], 5);
        oci_bind_by_name($stid, ":SERVICETYPE", $params['SERVICETYPE'], 5);
        oci_bind_by_name($stid, ":CAUSE", $params['CAUSE'], -1, OCI_B_CLOB);
        oci_bind_by_name($stid, ":RESOLUTION", $params['RESOLUTION'],-1, OCI_B_CLOB);
        oci_bind_by_name($stid, ":CREATEDBY", $params['CREATEDBY'], 5);
        oci_bind_by_name($stid, ":CREATEDON", $params['CREATEDON'], 5);
        oci_bind_by_name($stid, ":RESOLVEDBY", $params['RESOLVEDBY'], 5);
        oci_bind_by_name($stid, ":RESOLVEDON", $params['RESOLVEDON'], 5);
        oci_bind_by_name($stid, ":MODIFIEDBY", $params['MODIFIEDBY'], 5);
        oci_bind_by_name($stid, ":MODIFIEDON", $params['MODIFIEDON'], 5);
        oci_bind_by_name($stid, ":CLOSEDBY", $params['CLOSEDBY'], 5);
        oci_bind_by_name($stid, ":CLOSEDON", $params['CLOSEDON'], 5);
        oci_bind_by_name($stid, ":SLACLASS", $params['SLACLASS'], 5);
        oci_bind_by_name($stid, ":SLALEVEL1", $params['SLALEVEL1'], 5);
        oci_bind_by_name($stid, ":SLALEVEL2", $params['SLALEVEL2'], 5);
        oci_bind_by_name($stid, ":SLALEVEL3", $params['SLALEVEL3'], 5);
        oci_bind_by_name($stid, ":PRIORITY", $params['PRIORITY'], 5);
        oci_bind_by_name($stid, ":PRIORITYNAME", $params['PRIORITYNAME'], 5);
        oci_bind_by_name($stid, ":ASSIGNTO", $params['ASSIGNTO'], 5);
        oci_bind_by_name($stid, ":FIRSTCALLRESOLUTION", $params['FIRSTCALLRESOLUTION'], 5);
        oci_bind_by_name($stid, ":ASSIGNEDON", $params['ASSIGNEDON'], 5);
        oci_bind_by_name($stid, ":UPLOADBY", $params['UPLOADBY'], 5);
        // ... execute ....
        oci_execute($stid, OCI_NO_AUTO_COMMIT); // use OCI_DEFAULT for PHP <= 5.3.1
        if (oci_execute($stid, OCI_NO_AUTO_COMMIT)) {
            $results = "Berhasil";
        } else {
            $e = oci_error($stid);
            $results = "Gagal";
            //$results = $e['message'];
        }
        //$clob->save("A very long string");

        oci_commit($conn);
        oci_free_statement($send);
        oci_close($this->pblmig_db->conn_id);

        return $results;




        // $results = '';
        // $msg_out = 'TEST';

        // $insert = 'INSERT INTO UPLOAD_LOG(LEMBAR_RCM_FILE,RPTAG_RCM_FILE,MDD,MDB) 
        //            VALUES(:LEMBAR_RCM_FILE, :RPTAG_RCM_FILE, CURRENT_TIMESTAMP, :MDB)';
        // $send = oci_parse($this->pblmig_db->conn_id, $insert);
        // //Send parameters variable  value  lenght
        // oci_bind_by_name($send, ':LEMBAR_RCM_FILE', $save['LEMBAR_RCM_FILE']) or die('Error binding string1');
        // oci_bind_by_name($send, ':RPTAG_RCM_FILE', $save['RPTAG_RCM_FILE']) or die('Error binding string2');
        // oci_bind_by_name($send, ':MDB', $this->session->userdata('id_user')) or die('Error binding string3');

        // if (oci_execute($send)) {
        //     $results = $msg_out;
        // } else {
        //     $e = oci_error($send);
        //     $results = $e['message'];
        // }
        // oci_free_statement($send);
        // oci_close($this->pblmig_db->conn_id);

        // return $results;

    }
     public function insert2($params) {
        // Before running, create the table:
//     CREATE TABLE MYTABLE (mykey NUMBER, myclob CLOB);

        //print_r($params); exit();

        $conn = $this->pblmig_db->conn_id;
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        foreach ($params as $dt) {

            // conversi
            $CREATEDON = ($dt['CREATEDON'] == '30/12/1899 00:00:00') ? 'NULL' : "to_date('". $dt['CREATEDON'] ."', 'DD/MM/YYYY HH24:MI:SS')";
            $RESOLVEDON = ($dt['RESOLVEDON'] == '30/12/1899 00:00:00') ? 'NULL' : "to_date('". $dt['RESOLVEDON'] ."', 'DD/MM/YYYY HH24:MI:SS')";
            $MODIFIEDON = ($dt['MODIFIEDON'] == '30/12/1899 00:00:00') ? 'NULL' : "to_date('". $dt['MODIFIEDON'] ."', 'DD/MM/YYYY HH24:MI:SS')";
            $CLOSEDDATE = ($dt['CLOSEDDATE'] == '30/12/1899 00:00:00') ? 'NULL' : "to_date('". $dt['CLOSEDDATE'] ."', 'DD/MM/YYYY HH24:MI:SS')";
            $SLALEVEL1 = ($dt['SLALEVEL1'] == '30/12/1899 00:00:00') ? 'NULL' : "to_date('". $dt['SLALEVEL1'] ."', 'DD/MM/YYYY HH24:MI:SS')";
            $SLALEVEL2 = ($dt['SLALEVEL2'] == '30/12/1899 00:00:00') ? 'NULL' : "to_date('". $dt['SLALEVEL2'] ."', 'DD/MM/YYYY HH24:MI:SS')";
            $SLALEVEL3 = ($dt['SLALEVEL3'] == '30/12/1899 00:00:00') ? 'NULL' : "to_date('". $dt['SLALEVEL3'] ."', 'DD/MM/YYYY HH24:MI:SS')";
            $ASSIGNEDON = ($dt['ASSIGNEDON'] == '30/12/1899 00:00:00') ? 'NULL' : "to_date('". $dt['ASSIGNEDON'] ."', 'DD/MM/YYYY HH24:MI:SS')";
            
            $sql = "INSERT INTO faisallubis.TIKET_ITSM_UPLOAD (INCIDENT, CASEOWNER, CASEOWNEREMAIL, COMPLAINANT, COMPLAINANTEMAIL, SUMMARY, SOURCE, CALLTYPE, STATUS, DESCRIPTION, SERVICEFAMILY, SERVICEGROUP, SERVICETYPE, CAUSE, RESOLUTION, CREATEDBY, CREATEDON, RESOLVEDBY, RESOLVEDON, MODIFIEDBY, MODIFIEDON, CLOSEDBY, CLOSEDDATE, SLALEVEL1, SLALEVEL2, SLALEVEL3, PRIORITY, PRIORITYNAME, ASSIGNTO, FIRSTCALLRESOLUTION, ASSIGNEDON,  TGLUPLOAD, UPLOADBY)
                    VALUES (:INCIDENT, :CASEOWNER, :CASEOWNEREMAIL, :COMPLAINANT, :COMPLAINANTEMAIL, :SUMMARY, :SOURCE, :CALLTYPE, :STATUS, EMPTY_CLOB(), :SERVICEFAMILY, :SERVICEGROUP, :SERVICETYPE, EMPTY_CLOB(), EMPTY_CLOB(), :CREATEDBY, $CREATEDON, :RESOLVEDBY, $RESOLVEDON, :MODIFIEDBY, $MODIFIEDON, :CLOSEDBY, $CLOSEDDATE, $SLALEVEL1, $SLALEVEL2, $SLALEVEL3, :PRIORITY, :PRIORITYNAME, :ASSIGNTO, :FIRSTCALLRESOLUTION, $ASSIGNEDON , SYSDATE, :UPLOADBY)
                    RETURNING DESCRIPTION, CAUSE, RESOLUTION  INTO :DESCRIPTION, :CAUSE, :RESOLUTION";

            $stid = oci_parse($conn, $sql);
            $clob_DESCRIPTION = oci_new_descriptor($conn, OCI_D_LOB);
            $clob_CAUSE = oci_new_descriptor($conn, OCI_D_LOB);
            $clob_RESOLUTION = oci_new_descriptor($conn, OCI_D_LOB);
            oci_bind_by_name($stid, ":INCIDENT", $dt['INCIDENT']);
            oci_bind_by_name($stid, ":CASEOWNER", $dt['CASEOWNER']);
            oci_bind_by_name($stid, ":CASEOWNEREMAIL", $dt['CASEOWNEREMAIL']);
            oci_bind_by_name($stid, ":COMPLAINANT", $dt['COMPLAINANT']);
            oci_bind_by_name($stid, ":COMPLAINANTEMAIL", $dt['COMPLAINANTEMAIL']);
            oci_bind_by_name($stid, ":SUMMARY", $dt['SUMMARY']);
            oci_bind_by_name($stid, ":SOURCE", $dt['SOURCE']);
            oci_bind_by_name($stid, ":CALLTYPE", $dt['CALLTYPE']);
            oci_bind_by_name($stid, ":STATUS", $dt['STATUS']);
            oci_bind_by_name($stid, ":DESCRIPTION",  $clob_DESCRIPTION, -1, OCI_B_CLOB);
            oci_bind_by_name($stid, ":SERVICEFAMILY", $dt['SERVICEFAMILY']);
            oci_bind_by_name($stid, ":SERVICEGROUP", $dt['SERVICEGROUP']);
            oci_bind_by_name($stid, ":SERVICETYPE", $dt['SERVICETYPE']);
            oci_bind_by_name($stid, ":CAUSE",  $clob_CAUSE, -1, OCI_B_CLOB);
            oci_bind_by_name($stid, ":RESOLUTION",  $clob_RESOLUTION, -1, OCI_B_CLOB);
            oci_bind_by_name($stid, ":CREATEDBY", $dt['CREATEDBY']);
            // oci_bind_by_name($stid, ":CREATEDON", $dt['CREATEDON']);
            oci_bind_by_name($stid, ":RESOLVEDBY", $dt['RESOLVEDBY']);
            // oci_bind_by_name($stid, ":RESOLVEDON", $dt['RESOLVEDON']);
            oci_bind_by_name($stid, ":MODIFIEDBY", $dt['MODIFIEDBY']);
            // oci_bind_by_name($stid, ":MODIFIEDON", $dt['MODIFIEDON']);
            oci_bind_by_name($stid, ":CLOSEDBY", $dt['CLOSEDBY']);
            // oci_bind_by_name($stid, ":CLOSEDDATE", $dt['CLOSEDDATE']);
            // oci_bind_by_name($stid, ":SLACLASS", $dt['SLACLASS']);
            // oci_bind_by_name($stid, ":SLALEVEL1", $dt['SLALEVEL1']);
            // oci_bind_by_name($stid, ":SLALEVEL2", $dt['SLALEVEL2']);
            // oci_bind_by_name($stid, ":SLALEVEL3", $dt['SLALEVEL3']);
            oci_bind_by_name($stid, ":PRIORITY", $dt['PRIORITY']);
            oci_bind_by_name($stid, ":PRIORITYNAME", $dt['PRIORITYNAME']);
            oci_bind_by_name($stid, ":ASSIGNTO", $dt['ASSIGNTO']);
            oci_bind_by_name($stid, ":FIRSTCALLRESOLUTION", $dt['FIRSTCALLRESOLUTION']);
            //oci_bind_by_name($stid, ":ASSIGNEDON", $ASSIGNEDON);
            oci_bind_by_name($stid, ":UPLOADBY", $dt['UPLOADBY']);

            $r = oci_execute($stid, OCI_NO_AUTO_COMMIT); // use OCI_DEFAULT for PHP <= 5.3.1
            $clob_RESOLUTION->save($dt['RESOLUTION']);
            $clob_DESCRIPTION->save($dt['DESCRIPTION']);
            $clob_CAUSE->save($dt['CAUSE']);

            if (!$r) {
                $e = oci_error($stid);  // For oci_execute errors pass the statement handle
                print htmlentities($e['message']);
                print "\n<pre>\n";
                print htmlentities($e['sqltext']);
                printf("\n%".($e['offset']+1)."s", "^");
                print  "\n</pre>\n";
            }

            oci_commit($conn);
            //exit();
        }



     }


    
    // list data itsm with blob
    public function get_list_tiket_itsm() {
       
        // Prepare the statement
        $conn = $this->pblmig_db->conn_id;
        $stid = oci_parse($conn, 'SELECT * FROM faisallubis.TIKET_ITSM_UPLOAD WHERE ROWNUM < 20');
        if (!$stid) {
            $e = oci_error($conn);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Perform the logic of the query
        $r = oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Fetch the results of the query
        //$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS+OCI_RETURN_LOBS);
        while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS+OCI_RETURN_LOBS)) {
            
            $result[] = $row;
            
        }

        oci_free_statement($stid);
        oci_close($conn);
        return $result;

    }
    

// </editor-fold>

}
 