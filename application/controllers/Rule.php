<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rule extends CI_Controller {

	public function index(){
		if($this->session->userdata("session_id") && $this->session->userdata("session_type")==1){
			$response = array(
				"title" => "Aturan Forward Chaining",
				"html" => $this->load->view('rule', '', TRUE)
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

	function data(){
		$draw=$this->input->get('draw');
		$length=$this->input->get('length');
		$start=$this->input->get('start');
		$search=$this->input->get('search')["value"];

		$response = array();
		$response['data'] = array();
		$response['draw'] = $draw;

		$count = $this->db->count_all_results('aturan'); // get semua
		$response['recordsTotal'] = $response['recordsFiltered']= $count;

		if($search!=""){
			$this->db->like("kode_penyakit",$search);
			// $this->db->or_like("nama_penyakit",$search);
			$this->db->from('aturan');
			$this->db->join('ikan', 'aturan.kode_ikan = ikan.kode_ikan', 'left');
			$this->db->Order_by('kode_rule','ASC');
			
			$countFilter = $this->db->get(); // get filter
			$response['recordsFiltered']=$countFilter->num_rows();
		}
		if($search!=""){
			$this->db->like("kode_penyakit",$search);
			// $this->db->or_like("nama_penyakit",$search);
		}
		
		$this->db->from('aturan');
		$this->db->join('ikan', 'aturan.kode_ikan = ikan.kode_ikan', 'left');
		$this->db->Order_by('kode_rule','ASC');
		$this->db->limit($length,$start);
		$query = $this->db->get(); // get filter

		foreach ($query->result() as $row) {
			$gejala = $this->db->where("kode_rule",$row->kode_rule)->get('detail_aturan');
			$data_gejala = [];
			foreach ($gejala->result() as $row_gejala) {
				array_push($data_gejala, $row_gejala->kode_gejala);
			};
			$response['data'][] = array(
				"kode_rule"=>$row->kode_rule,
				"kode_penyakit"=>$row->kode_penyakit,
				"kode_ikan"=>$row->kode_ikan,
				"nama_ikan"=>$row->nama_ikan,
				"gejala"=>$data_gejala,
			);
		}
		$this->output->set_status_header(200)
					->set_content_type('application/json')
					->set_output(json_encode($response));
	}

	function get(){
		$this->db->from('aturan');
		$this->db->join('ikan', 'aturan.kode_ikan = ikan.kode_ikan', 'left');
		$query = $this->db->get(); // get filter

		foreach ($query->result() as $row) {
			$gejala = $this->db->where("kode_rule",$row->kode_rule)->get('detail_aturan');
			$data_gejala = [];
			foreach ($gejala->result() as $row_gejala) {
				array_push($data_gejala, $row_gejala->kode_gejala);
			};
			$response['data'][] = array(
				"kode_rule"=>$row->kode_rule,
				"kode_penyakit"=>$row->kode_penyakit,
				"kode_ikan"=>$row->kode_ikan,
				"nama_ikan"=>$row->nama_ikan,
				"gejala"=>$data_gejala,
			);
		}
		$this->output->set_status_header(200)
					->set_content_type('application/json')
					->set_output(json_encode($response));
	}

	public function save(){
		$kode_lama = $this->input->post("kode_lama");
		$kode_rule = $this->input->post("kode_rule");
		$kode_ikan = $this->input->post("kode_ikan");
		$if = $this->input->post("if_gejala");
		$kode_gejala = explode(",",$if);
		$kode_penyakit = $this->input->post("then_penyakit");
		$form_type = $this->input->post("form_type");
		$statusCode = 200;
		if(!$kode_rule){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Kode rule wajib diisi",
			);
		}else if(count($kode_gejala) < 1){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Rules wajib diisi minimal 1 gejala",
			);

		}else if(!$kode_ikan){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Ikan wajib dipilih",
			);
		}else if(!$kode_penyakit){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Penyakit wajib dipilih",
			);

		}else{
			$where = array(
				"kode_rule" => $kode_rule,
			);
			$cek = $this->db->from("aturan")->where($where)->get();
			if($cek->num_rows() > 0 && ($form_type == "create" || ($form_type == "update" && $kode_lama!=$kode_rule ))){
				$statusCode = 406;
				$response = array(
					"error" => "Bad request",
					"message" => "Kode rule sudah digunakan",
				);
			}else{
				$data = array(
					"kode_rule" => $kode_rule,
					"kode_penyakit" => $kode_penyakit,
					"kode_ikan" => $kode_ikan,
				);
				
				if($form_type == "update"){
					$this->db->where("kode_rule", $kode_lama)->update("aturan", $data);
					$this->db->where("kode_rule", $kode_lama)->delete("detail_aturan");
					for ($i=0; $i < count($kode_gejala); $i++) { 
						$data = array(
							"kode_rule" => $kode_rule,
							"kode_gejala" => $kode_gejala[$i],
						);
						$this->db->insert("detail_aturan", $data);
					}
					$statusCode = 200;
					$response = array(
						"message" => "Rule berhasil diperbarui",
					);
				}else{
					$this->db->insert("aturan", $data);
					for ($i=0; $i < count($kode_gejala); $i++) { 
						$data = array(
							"kode_rule" => $kode_rule,
							"kode_gejala" => $kode_gejala[$i],
						);
						$this->db->insert("detail_aturan", $data);
					}
					$statusCode = 200;
					$response = array(
						"message" => "Rule berhasil dibuat",
					);
				}
			}
		}

		$this->output->set_status_header($statusCode)
					->set_content_type('application/json')
					->set_output(json_encode($response));
		
	}

	public function delete($kode){
		$delete = $this->db->where('kode_rule', $kode)->delete("aturan");
		$statusCode = 200;
		if(!$delete){
			$statusCode = 403;
			$response = array(
				"error" => "Forbidden",
				"message" => "Data rule tidak dapat dihapus, karena digunakan sebagai referensi data lain.",
			);
		}else{
			$statusCode = 200;
			$response = array(
				"message" => "Data rule berhasil dihapus",
			);
		}
		
		$this->output->set_status_header($statusCode)
					->set_content_type('application/json')
					->set_output(json_encode($response));
	}
}
