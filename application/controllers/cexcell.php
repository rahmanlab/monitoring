<?php

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
defined('BASEPATH') OR exit('No direct script access allowed');
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
		$this->load->helper(array('path'));
		$this->load->file('assets/plugins/spout-master/src/Spout/Autoloader/autoload.php');
		$this->load->library('pagination');
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
		/* start of pagination --------------------- */
        // pagination
		$config['base_url'] = site_url("cexcell/index");
        //$params = array($data_status);
		$config['total_rows'] = $this->mexcell->get_total_tiket();
		$config['uri_segment'] = 3;
		$config['per_page'] = 10;
		$this->pagination->initialize($config);
		$pagination['data'] = $this->pagination->create_links();
        // pagination attribute
		$start = $this->uri->segment(3, 0) + 1;
		$end = $this->uri->segment(3, 0) + $config['per_page'];
		$end = (($end > $config['total_rows']) ? $config['total_rows'] : $end);
		$pagination['start'] = ($config['total_rows'] == 0) ? 0 : $start;
		$pagination['end'] = $end;
		$pagination['total'] = $config['total_rows'];
        // pagination assign value
		$data['pagination'] = $pagination;
		$data['no'] = $start;
		/* end of pagination ---------------------- */
        // get list oracle vs mysql -> $start : $perpage 
        // pagenumber : per_page   -> start : per_page
        // hal1 = 1 : 10 -> 1 : 10
        // hal2 = 2 : 10 -> 11 : 10
        // hal3 = 3 : 10 -> 21 : 10
        // hal4 = 4 : 10 -> 31 : 10    
        // jadi untuk oracle
		$pagenumber = (($start -1 )/10) + 1 ;
		$params = array(($pagenumber ), $config['per_page']);
		$data['uploadItsm'] = $this->mexcell->get_list_tiket_itsm($params);
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
			$message = $this->mexcell->insert2($params);             
			//print_r($params); exit();
			$reader->close();
			if($message == 'sukses'){
				$this->session->set_flashdata('pesan', 'Data berhasil ditambahkan.');
				redirect("cexcell");
			}else{
				$this->session->set_flashdata('gagal', $message['message']);
				redirect("cexcell");
			}

		} catch (Exception $e) {
			$this->session->set_flashdata('gagal', $e->getMessage());
			redirect("cexcell");
		}
	}
}