<?php

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
defined('BASEPATH') OR exit('No direct script access allowed');
//$lokasiSpout= site_url('assets/spout-master/src/Spout/Autoloader/autoload.php');

require_once('C:/xampp/553/htdocs/monitoring/assets/plugins/spout-master/src/Spout/Autoloader/autoload.php') ;
//lets Use the Spout Namespaces
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class cexcell extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('mexcell');
        // LOAD LIBRARY
        $sesi_login = $this->session->userdata('logged');
        if (!isset($sesi_login)) {
            redirect('auth/login');
        }
    }
    

    public function index() {
        $data['title'] = "Upload Data ITSM";
        $data['konten'] = "vUploadExcell";
		//$data['uploadItsm'] = $this->mexcell->get_list_data_upload_itsm();
		$data['uploadItsm'] = $this->mexcell->get_list_tiket_itsm();
       //print_r($data['uploadItsm']); exit();
        $this->load->view('home', $data);
    }

	//import database
	public function importDataExcell(){
		try 
		{
			$inputFileName = $_FILES['file']['tmp_name'];
			//print_r($inputFileName); exit();
			//Lokasi file excel       
			$file_path = $inputFileName;                     
			$reader = ReaderFactory::create(Type::XLSX); //set Type file xlsx
			$reader->open($inputFileName); //open the file          

			//echo "<pre>";           
			$i=0;
			
		   foreach ($reader->getSheetIterator() as $sheet) {
				              
				foreach ($sheet->getRowIterator() as $row) {
					
					if ($i >= 1){
						
						$CREATEDON = new DateTime("1899-12-30 + ". round($row[16] * 86400) . " seconds");
						$RESOLVEDON = new DateTime("1899-12-30 + ". round($row[18] * 86400) . " seconds");
						$MODIFIEDON = new DateTime("1899-12-30 + ". round($row[20] * 86400) . " seconds");
						$CLOSEDDATE = new DateTime("1899-12-30 + ". round($row[22] * 86400) . " seconds");
						$SLALEVEL1 = new DateTime("1899-12-30 + ". round($row[24] * 86400) . " seconds");
						$SLALEVEL2 = new DateTime("1899-12-30 + ". round($row[25] * 86400) . " seconds");
						$SLALEVEL3 = new DateTime("1899-12-30 + ". round($row[26] * 86400) . " seconds");
						$ASSIGNEDON = new DateTime("1899-12-30 + ". round($row[31] * 86400) . " seconds");

						$params[] = array(
							'INCIDENT' => $row[0],
							'CASEOWNER' => $row[1],
							'CASEOWNEREMAIL' => $row[2],
							'COMPLAINANT' => $row[3],
							'COMPLAINANTEMAIL' => $row[4],
							'SUMMARY' => $row[5],
							'SOURCE' => $row[6],
							'CALLTYPE' => $row[7],
							'STATUS' => $row[8],
							'DESCRIPTION' => $row[9],
							'SERVICEFAMILY' => $row[10],
							'SERVICEGROUP' => $row[11],
							'SERVICETYPE' => $row[12],
							'CAUSE' => $row[13],
							'RESOLUTION' => $row[14],
							'CREATEDBY' => $row[15],
							'CREATEDON' => $CREATEDON->format("d/m/Y H:i:s"),
							'RESOLVEDBY' => $row[17],
							'RESOLVEDON' => $RESOLVEDON->format("d/m/Y H:i:s"),
							'MODIFIEDBY' => $row[19],
							'MODIFIEDON' => $MODIFIEDON->format("d/m/Y H:i:s"),
							'CLOSEDBY' => $row[21],
							'CLOSEDDATE' => $CLOSEDDATE->format("d/m/Y H:i:s"),
							'SLACLASS' => $row[23],
							'SLALEVEL1' => $SLALEVEL1->format("d/m/Y H:i:s"),
							'SLALEVEL2' => $SLALEVEL2->format("d/m/Y H:i:s"),
							'SLALEVEL3' => $SLALEVEL3->format("d/m/Y H:i:s"),
							'PRIORITY' => $row[27],
							'PRIORITYNAME' => $row[28],
							'ASSIGNTO' => $row[29],
							'FIRSTCALLRESOLUTION' => $row[30],
							'ASSIGNEDON' => $ASSIGNEDON->format("d/m/Y H:i:s"),
							//'TGLUPLOAD' => $row[32],
							'UPLOADBY' => $this->session->userdata('id_user'),
						);
						
					}
					$i++;
					
				}
			
			}
			$this->mexcell->insert2($params);             
			//print_r($params); exit();
			$reader->close();
			redirect("cexcell");

		} catch (Exception $e) {
			echo "fghj";
			echo $e->getMessage();
			exit();   
		}
	}
}