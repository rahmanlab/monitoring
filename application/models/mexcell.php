<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
  
class mexcell extends CI_Model {
   
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
    public function insert($params) {
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
    

// </editor-fold>

}
 