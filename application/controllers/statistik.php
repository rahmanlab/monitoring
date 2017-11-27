<?php

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
defined('BASEPATH') OR exit('No direct script access allowed');

class statistik extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('mdata');
        $this->load->model('mstatistik');
        $this->load->library('datetimemanipulation');
        // LOAD LIBRARY
        $sesi_login = $this->session->userdata('logged');
        if (!isset($sesi_login)) {
            redirect('auth/login');
        }
    }
    // <editor-fold defaultstate="collapsed" desc="Menu Dokumen - By Arif">

    public function index() {
        $data['title'] = "Statistik Data Support";
        $data['konten'] = "statistik/index";

        $data['rs_family'] = $this->mstatistik->get_total_family();
        $data['rs_resolved'] = $this->mstatistik->get_total_resolved();
        $data['rs_total_resolved'] = $this->mstatistik->get_total_resolved();
        $data['rs_warna'] = $this->mstatistik->get_warna();
        $data['total_tiket'] = $this->mstatistik->get_total_tiket();
        $data['tiket_aktif'] = $this->mstatistik->get_total_tiket_aktif();
        $data['tiket_resolved'] = $this->mstatistik->get_total_tiket_resolved();


        $data['rs_bulan'] = $this->datetimemanipulation->get_list_month();
        $data['rs_tahun'] = $this->mstatistik->get_list_tahun();
        $data['waktu_sekarang'] = $this->datetimemanipulation->get_date_yesterday();


       // print_r($data['rs_jml_pertransaksi']); exit();
        $this->load->view('home', $data);
    }



    // LOAD DATA TABLE
    public function dokumen_load_params() {
        $family = $this->input->post('family');
        // get params
        $family = empty($family) ? '' : "%".$family."%";
        // parameter
        $params = array($family);
        $res = $this->mstatistik->get_list_by_family($params);
        // get data
        if (empty($res)) {
            $output = array(
                "data" => [],
            );
            echo json_encode($output);
        } else {
            $session_data['rs_ophar'] = $res;
            $this->session->set_userdata($session_data);
            foreach ($res as $data) {
                $row = array();
                $row[] = number_format($data['INCIDENT'], 0, '', '');
                $row[] = $data['CASEOWNER'];
                $row[] = $data['SLACLASS'];
                $row[] = $data['SUMMARY'];
                $row[] = $data['SERVICETYPE'];
                $row[] = $data['CREATEDBY'];
                $row[] = $data['CREATEDON'];
                $row[] = $data['CLOSEDDATE'];
                $row[] = $data['ASSIGNTO'];
                $row[] = $data['ASSIGNEDON'];
                $dataarray[] = $row;
            }
            $output = array(
                "data" => $dataarray
            );
            echo json_encode($output);
        }
    }












    
    public function bulanan() {
        $data['title'] = "Statistik Data Support";
        $data['konten'] = "statistik/bulanan";


        // get search parameter
        $search = $this->session->userdata('data_search');
        if (!empty($search)) {
            $data['search'] = $search;
        } else {
            $data['search']['bulan'] =  date('m');
            $data['search']['tahun'] =  date('Y');
        }
        // search parameters
        //$data['bulan'] = empty($data['bulan']) ? date('Y') : $data['bulan'];
        $blth = $data['search']['tahun'].$data['search']['bulan'];


        $data['rs_total_tiket'] = $this->mstatistik->get_list_bulanan_total($blth);
        $data['rs_tiket_sla'] = $this->mstatistik->get_list_sla_bulanan($blth);
        // print_r($data['rs_tiket_sla']); exit();
        $data['total_tiket'] = $this->mstatistik->get_total_tiket_bulanan($blth);
        $data['tiket_oversla'] = $this->mstatistik->get_tiket_oversla_bulanan($blth);
        $data['tiket_resolved'] = $this->mstatistik->get_tiket_resolved_bulanan($blth);
        $data['rs_tiket_bulanan'] = $this->mstatistik->get_jml_tiket_bulanan($data['search']['tahun']);
        //print_r($data['total_tiket']);exit();

        $data['rs_bulan'] = $this->datetimemanipulation->get_list_month();
        $data['rs_tahun'] = $this->mstatistik->get_list_tahun();
        $data['waktu_sekarang'] = $this->datetimemanipulation->get_date_now();


       // print_r($data['rs_jml_pertransaksi']); exit();
        $this->load->view('home', $data);
    }

    // search process
    public function search_process() {
        // data
        if ($this->input->post('button') == "reset") {
            $this->session->unset_userdata('data_search');
        } else {
            $params = array(
                "bulan" => $this->input->post("bulan", TRUE),
                "tahun" => $this->input->post("tahun", TRUE),
            );
            $this->session->set_userdata("data_search", $params);
        }
        // redirect ke fungsi index
        redirect("statistik/bulanan");
    }



    // </editor-fold>
}
