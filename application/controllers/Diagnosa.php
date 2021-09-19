<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diagnosa extends CI_Controller {

	public function index(){
		$response = array(
			"title" => "Diagnosa Penyakit",
			"html" => $this->load->view('diagnosa', '', TRUE)
		);
		
		$this->output->set_status_header(200)
					->set_content_type('application/json')
					->set_output(json_encode($response));
	}

	public function riwayat(){
		if($this->session->userdata("session_id")){
			$response = array(
				"title" => "Riwayat Diagnosa",
				"html" => $this->load->view('riwayat-diagnosa', '', TRUE)
			);
		}else{
			$response = array(
				"title" => "Login",
				"html" => $this->load->view('login', '', TRUE)
			);
		}
		
		$this->output->set_status_header(200)
					->set_content_type('application/json')
					->set_output(json_encode($response));
	}

	public function save(){
		$kode_ikan = $this->input->post("kode_ikan");
		$gejala = explode(",",$this->input->post("gejala"));
		$penyakit = json_decode($this->input->post("penyakit"));

		$data_diagnosa = array(
			"kode_ikan" => $kode_ikan,
			"kode_user" => $this->session->userdata("session_id")
		);
		$this->db->insert("diagnosa", $data_diagnosa);
		$id = $this->db->insert_id();

		foreach ($gejala as $key) {
			$data_gejala = array(
				"kode_diagnosa" => $id,
				"kode_gejala" => $key,
			);
			$this->db->insert("detail_diagnosa_gejala", $data_gejala);
		}
		foreach ($penyakit as $key) {
			$data_penyakit = array(
				"kode_diagnosa" => $id,
				"kode_penyakit" => $key->kode_penyakit,
				"persentase" => $key->persentase,
			);
			$this->db->insert("detail_diagnosa_penyakit", $data_penyakit);
		}

		$response = array(
			"message" => "Hasil diagnosa berhasil disimpan",
		);

		$this->output->set_status_header(200)
					->set_content_type('application/json')
					->set_output(json_encode($response));
	}

	function data(){
		$draw=$this->input->get('draw');
		$length=$this->input->get('length');
		$start=$this->input->get('start');
		$search=$this->input->get('search')["value"];

		$response = array();
		$response['data'] = array();
		$response['draw'] = $draw;

		$count = $this->db->count_all_results('diagnosa'); // get semua
		$response['recordsTotal'] = $response['recordsFiltered'] = $count;

		if($search!=""){
			$this->db->like("ikan.kode_ikan",$search);
			$this->db->or_like("ikan.nama_ikan",$search);
			$this->db->from('diagnosa');
			$this->db->join('ikan', 'diagnosa.kode_ikan = ikan.kode_ikan', 'left');
			$this->db->join('akun', 'diagnosa.kode_akun = akun.kode_akun', 'left');
			if($this->session->userdata("session_type")==0){
				$this->db->where("diagnosa.kode_akun",$this->session->userdata("session_id"));
			}
			$this->db->Order_by('tanggal','DESC');
			
			$countFilter = $this->db->get(); // get filter
			$response['recordsFiltered']=$countFilter->num_rows();
		}
		if($search!=""){
			$this->db->like("ikan.kode_ikan",$search);
			$this->db->or_like("ikan.nama_ikan",$search);
		}
		
		$this->db->from('diagnosa');
		$this->db->join('ikan', 'diagnosa.kode_ikan = ikan.kode_ikan', 'left');
		$this->db->join('akun', 'diagnosa.kode_akun = akun.kode_akun', 'left');
		if($this->session->userdata("session_type")==0){
			$this->db->where("diagnosa.kode_akun",$this->session->userdata("session_id"));
		}
		$this->db->Order_by('tanggal','DESC');
		$this->db->limit($length,$start);
		$query = $this->db->get(); // get filter

		foreach ($query->result() as $row) {
			$gejala = $this->db->from('detail_diagnosa_gejala')->join('gejala', 'detail_diagnosa_gejala.kode_gejala = gejala.kode_gejala', 'left')->where("kode_diagnosa",$row->kode_diagnosa)->get();
			$data_gejala = [];
			foreach ($gejala->result() as $row_gejala) {
				$row_data = array(
					"kode_gejala" => $row_gejala->kode_gejala,
					"gejala" => $row_gejala->gejala,
				);
				array_push($data_gejala, $row_data);
			};
			$penyakit = $this->db->from('detail_diagnosa_penyakit')->join('penyakit', 'detail_diagnosa_penyakit.kode_penyakit = penyakit.kode_penyakit', 'left')->where("kode_diagnosa",$row->kode_diagnosa)->get();
			$data_penyakit = [];
			foreach ($penyakit->result() as $row_penyakit) {
				$row_data = array(
					"kode_penyakit" => $row_penyakit->kode_penyakit,
					"nama_penyakit" => $row_penyakit->nama_penyakit,
					"persentase" => $row_penyakit->persentase,
					"penanganan" => $row_penyakit->penanganan,
				);
				array_push($data_penyakit, $row_data);
			};
			$response['data'][] = array(
				"nama_ikan"=>$row->nama_ikan,
				"tanggal"=>$row->tanggal,
				"user"=>$row->nama_lengkap,
				"gejala" => $data_gejala,
				"penyakit" => $data_penyakit,
			);
		}
		$this->output->set_status_header(200)
					->set_content_type('application/json')
					->set_output(json_encode($response));
	}
}
