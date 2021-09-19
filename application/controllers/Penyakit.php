<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penyakit extends CI_Controller {

	public function index(){
		if($this->session->userdata("session_id") && $this->session->userdata("session_type")==1){
			$response = array(
				"title" => "Data Penyakit",
				"html" => $this->load->view('penyakit', '', TRUE)
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
	function get(){
		$query = $this->db->get('penyakit');
		foreach ($query->result() as $row) {
			$response[] = array(
				"kode_penyakit"=>$row->kode_penyakit,
				"nama_penyakit"=>$row->nama_penyakit,
				"kode_ikan"=>$row->kode_ikan,
				"penanganan"=>$row->penanganan,
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

		$count = $this->db->count_all_results('penyakit'); // get semua
		$response['recordsTotal'] = $response['recordsFiltered']= $count;

		if($search!=""){
			$this->db->like("kode_penyakit",$search);
			$this->db->or_like("nama_penyakit",$search);
			$this->db->from('penyakit');
			$this->db->join('ikan', 'penyakit.kode_ikan = ikan.kode_ikan', 'left');
			$this->db->Order_by('kode_penyakit','ASC');
			
			$countFilter = $this->db->get(); // get filter
			$response['recordsFiltered']=$countFilter->num_rows();
		}
		if($search!=""){
			$this->db->like("kode_penyakit",$search);
			$this->db->or_like("nama_penyakit",$search);
		}
		
		$this->db->from('penyakit');
		$this->db->join('ikan', 'penyakit.kode_ikan = ikan.kode_ikan', 'left');
		$this->db->Order_by('kode_penyakit','ASC');
		$this->db->limit($length,$start);
		$query = $this->db->get(); // get filter

		foreach ($query->result() as $row) {
			$response['data'][] = array(
				"kode_penyakit"=>$row->kode_penyakit,
				"nama_penyakit"=>$row->nama_penyakit,
				"penanganan"=>$row->penanganan,
				"kode_ikan"=>$row->kode_ikan,
				"nama_ikan"=>$row->nama_ikan,
			);
		}
		$this->output->set_status_header(200)
					->set_content_type('application/json')
					->set_output(json_encode($response));
	}

	public function save(){
		$kode = $this->input->post("kode_penyakit");
		$nama = $this->input->post("nama_penyakit");
		$penanganan = $this->input->post("penanganan");
		$kode_ikan = $this->input->post("kode_ikan");
		$kode_lama = $this->input->post("kode_lama");
		$form_type = $this->input->post("form_type");
		$statusCode = 200;
		if(!$kode){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Kode penyakit wajib diisi",
			);
		}else if(!$nama){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Nama penyakit wajib diisi",
			);

		}else if(!$penanganan){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Penanganan penyakit wajib diisi",
			);
		}else if(!$kode_ikan){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Ikan wajib dipilih",
			);

		}else{
			$where = array(
				"kode_penyakit" => $kode,
			);
			$cek = $this->db->from("penyakit")->where($where)->get();
			if($cek->num_rows() > 0 && ($form_type == "create" || ($form_type == "update" && $kode_lama!=$kode ))){
				$statusCode = 406;
				$response = array(
					"error" => "Bad request",
					"message" => "Kode penyakit sudah digunakan",
				);
			}else{
				$data = array(
					"kode_penyakit" => $kode,
					"nama_penyakit" => $nama,
					"penanganan" => $penanganan,
					"kode_ikan" => $kode_ikan,
				);

				if($form_type == "update"){
					$this->db->where("kode_penyakit", $kode)->update("penyakit", $data);
					$statusCode = 200;
					$response = array(
						"message" => "Data penyakit berhasil diperbarui",
					);
				}else{
					$this->db->insert("penyakit", $data);
					$statusCode = 200;
					$response = array(
						"message" => "Data penyakit berhasil ditambahkan",
					);
				}
			}
		}

		$this->output->set_status_header($statusCode)
					->set_content_type('application/json')
					->set_output(json_encode($response));
		
	}

	
	function import(){
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])) {
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$item_id = array();
			foreach($object->getWorksheetIterator() as $sheet) {
				$highestRow = $sheet->getHighestRow();
				$highestColumn = $sheet->getHighestColumn();
				for($row=2; $row<=$highestRow; $row++) {
					$kode_penyakit = str_replace(")","_",str_replace("(","_",$sheet->getCellByColumnAndRow(0, $row)->getValue()));
					$nama_penyakit = $sheet->getCellByColumnAndRow(1, $row)->getValue();
					$penanganan = $sheet->getCellByColumnAndRow(2, $row)->getValue();
					$kode_ikan = $sheet->getCellByColumnAndRow(3, $row)->getValue();
					if($kode_penyakit){
						$data = array(
							"kode_penyakit" => $kode_penyakit,
							"nama_penyakit" => $nama_penyakit,
							"penanganan" => $penanganan,
							"kode_ikan" => $kode_ikan,
						);
	
						$where = array(
							"kode_penyakit" => $kode_penyakit,
						);
						$cek = $this->db->from("penyakit")->where($where)->get();
						if($cek->num_rows() > 0){
							$this->db->where("kode_penyakit", $kode_penyakit)->update("penyakit", $data);
						}else{
							$this->db->insert("penyakit", $data);
						}
					}
				}
			}
			$statusCode = 200;
			$response = array(
				"message" => "Data penyakit berhasil diunggah",
			);
		}
	}

	public function delete($kode){
		$delete = $this->db->where('kode_penyakit', $kode)->delete("penyakit");
		$statusCode = 200;
		if(!$delete){
			$statusCode = 403;
			$response = array(
				"error" => "Forbidden",
				"message" => "Data penyakit tidak dapat dihapus, karena digunakan sebagai referensi data lain.",
			);
		}else{
			$statusCode = 200;
			$response = array(
				"message" => "Data Penyakit berhasil dihapus",
			);
		}
		
		$this->output->set_status_header($statusCode)
					->set_content_type('application/json')
					->set_output(json_encode($response));
	}
}
