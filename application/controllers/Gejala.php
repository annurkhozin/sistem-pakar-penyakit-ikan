<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gejala extends CI_Controller {

	public function index(){
		if($this->session->userdata("session_id") && $this->session->userdata("session_type")==1){
			$response = array(
				"title" => "Gejala gejala",
				"html" => $this->load->view('gejala', '', TRUE)
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
		$query = $this->db->get('gejala');
		foreach ($query->result() as $row) {
			$response[] = array(
				"kode_gejala"=>$row->kode_gejala,
				"gejala"=>$row->gejala,
				"kode_ikan"=>$row->kode_ikan
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

		$count = $this->db->count_all_results('gejala'); // get semua
		$response['recordsTotal'] = $response['recordsFiltered']= $count;

		if($search!=""){
			$this->db->like("kode_gejala",$search);
			$this->db->or_like("gejala",$search);
			$this->db->from('gejala');
			$this->db->join('ikan', 'gejala.kode_ikan = ikan.kode_ikan', 'left');
			$this->db->Order_by('kode_gejala','ASC');
			
			$countFilter = $this->db->get(); // get filter
			$response['recordsFiltered']=$countFilter->num_rows();
		}
		if($search!=""){
			$this->db->like("kode_gejala",$search);
			$this->db->or_like("gejala",$search);
		}
		
		$this->db->from('gejala');
		$this->db->join('ikan', 'gejala.kode_ikan = ikan.kode_ikan', 'left');
		$this->db->Order_by('kode_gejala','ASC');
		$this->db->limit($length,$start);
		$query = $this->db->get(); // get filter

		foreach ($query->result() as $row) {
			$response['data'][] = array(
				"kode_gejala"=>$row->kode_gejala,
				"gejala"=>$row->gejala,
				"kode_ikan"=>$row->kode_ikan,
				"nama_ikan"=>$row->nama_ikan
			);
		}
		$this->output->set_status_header(200)
					->set_content_type('application/json')
					->set_output(json_encode($response));
	}

	public function save(){
		$kode = $this->input->post("kode_gejala");
		$nama = $this->input->post("gejala");
		$kode_ikan = $this->input->post("kode_ikan");
		$kode_lama = $this->input->post("kode_lama");
		$form_type = $this->input->post("form_type");
		$statusCode = 200;
		if(!$kode){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Kode gejala wajib diisi",
			);
		}else if(!$nama){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Gejala wajib diisi",
			);
		}else if(!$kode_ikan){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Ikan wajib dipilih",
			);

		}else{
			$where = array(
				"kode_gejala" => $kode,
			);
			$cek = $this->db->from("gejala")->where($where)->get();
			if($cek->num_rows() > 0 && ($form_type == "create" || ($form_type == "update" && $kode_lama!=$kode ))){
				$statusCode = 406;
				$response = array(
					"error" => "Bad request",
					"message" => "Kode gejala sudah digunakan",
				);
			}else{
				$data = array(
					"kode_gejala" => $kode,
					"gejala" => $nama,
					"kode_ikan" => $kode_ikan,
				);

				if($form_type == "update"){
					$this->db->where("kode_gejala", $kode)->update("gejala", $data);
					$statusCode = 200;
					$response = array(
						"message" => "Data gejala berhasil diperbarui",
					);
				}else{
					$this->db->insert("gejala", $data);
					$statusCode = 200;
					$response = array(
						"message" => "Data gejala berhasil ditambahkan",
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
					$kode_gejala = str_replace(")","_",str_replace("(","_",$sheet->getCellByColumnAndRow(0, $row)->getValue()));
					$gejala = $sheet->getCellByColumnAndRow(1, $row)->getValue();
					$kode_ikan = str_replace(")","_",str_replace("(","_",$sheet->getCellByColumnAndRow(2, $row)->getValue()));
					if($kode_gejala){
						$data = array(
							"kode_gejala" => $kode_gejala,
							"gejala" => $gejala,
							"kode_ikan" => $kode_ikan,
						);
	
						$where = array(
							"kode_gejala" => $kode_gejala,
						);
						$cek = $this->db->from("gejala")->where($where)->get();
						if($cek->num_rows() > 0){
							$this->db->where("kode_gejala", $kode_gejala)->update("gejala", $data);
						}else{
							$this->db->insert("gejala", $data);
						}
					}
				}
			}
			$statusCode = 200;
			$response = array(
				"message" => "Data gejala berhasil diunggah",
			);
		}
	}

	public function delete($kode){
		$delete = $this->db->where('kode_gejala', $kode)->delete("gejala");
		$statusCode = 200;
		if(!$delete){
			$statusCode = 403;
			$response = array(
				"error" => "Forbidden",
				"message" => "Data gejala tidak dapat dihapus, karena digunakan sebagai referensi data lain.",
			);
		}else{
			$statusCode = 200;
			$response = array(
				"message" => "Data gejala berhasil dihapus",
			);
		}
		
		$this->output->set_status_header($statusCode)
					->set_content_type('application/json')
					->set_output(json_encode($response));
	}
}
