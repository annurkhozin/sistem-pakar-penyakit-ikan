<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ikan extends CI_Controller {

	public function index(){
		if($this->session->userdata("session_id") && $this->session->userdata("session_type")==1){
			$response = array(
				"title" => "Data Ikan",
				"html" => $this->load->view('ikan', '', TRUE)
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
		$query = $this->db->get('ikan');
		foreach ($query->result() as $row) {
			$response[] = array(
				"kode_ikan"=>$row->kode_ikan,
				"nama_ikan"=>$row->nama_ikan,
				"photo"=>$row->photo,
				"deskripsi"=>$row->deskripsi,
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

		$count = $this->db->count_all_results('ikan'); // get semua
		$response['recordsTotal'] = $response['recordsFiltered'] = $count;

		if($search!=""){
			$this->db->like("kode_ikan",$search);
			$this->db->or_like("nama_ikan",$search);
			$this->db->from('ikan');
			$this->db->Order_by('nama_ikan','ASC');
			
			$countFilter = $this->db->get(); // get filter
			$response['recordsFiltered']=$countFilter->num_rows();
		}
		if($search!=""){
			$this->db->like("kode_ikan",$search);
			$this->db->or_like("nama_ikan",$search);
		}
		
		$this->db->from('ikan');
		$this->db->Order_by('kode_ikan','ASC');
		$this->db->limit($length,$start);
		$query = $this->db->get(); // get filter

		foreach ($query->result() as $row) {
			$response['data'][] = array(
				"kode_ikan"=>$row->kode_ikan,
				"nama_ikan"=>$row->nama_ikan,
				"deskripsi"=>$row->deskripsi,
			);
		}
		$this->output->set_status_header(200)
					->set_content_type('application/json')
					->set_output(json_encode($response));
	}

	public function save(){
		$kode = $this->input->post("kode_ikan");
		$nama = $this->input->post("nama_ikan");
		$photo = $this->input->post("photo");
		$deskripsi = $this->input->post("deskripsi");
		$kode_lama = $this->input->post("kode_lama");
		$form_type = $this->input->post("form_type");
		$statusCode = 200;
		if(!$kode){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Kode ikan wajib diisi",
			);
		}else if(!$nama){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Nama ikan wajib diisi",
			);

		}else{
			$where = array(
				"kode_ikan" => $kode,
			);
			$cek = $this->db->from("ikan")->where($where)->get();
			if($cek->num_rows() > 0 && ($form_type == "create" || ($form_type == "update" && $kode_lama!=$kode ))){
				$statusCode = 406;
				$response = array(
					"error" => "Bad request",
					"message" => "Kode ikan sudah digunakan",
				);
			}else{
				$data = array(
					"kode_ikan" => $kode,
					"nama_ikan" => $nama,
					"deskripsi" => $deskripsi,
				);

				if($photo){
					$data["photo"] = $photo;
				}

				if($form_type == "update"){
					$this->db->where("kode_ikan", $kode)->update("ikan", $data);
					$statusCode = 200;
					$response = array(
						"message" => "Data ikan berhasil diperbarui",
					);
				}else{
					$this->db->insert("ikan", $data);
					$statusCode = 200;
					$response = array(
						"message" => "Data ikan berhasil ditambahkan",
					);
				}
			}
		}

		$this->output->set_status_header($statusCode)
					->set_content_type('application/json')
					->set_output(json_encode($response));
		
	}

	public function photo(){
			$fileName = time().'-'.$_FILES["file"]['name'];
			$config['upload_path']          = './assets/image/';
			$config['allowed_types']        = "gif|jpg|png|jpeg|JPEG|JPG|PNG|GIF";
			$config['max_size']             = 10000;
			$config['file_name']            = $fileName;
			$config['max_width']            = 1024;
			$config['max_height']           = 768;

			$this->load->library('upload', $config);

			if ( !$this->upload->do_upload('file')){
				$error = array('error' => $this->upload->display_errors());
				$statusCode = 200;
				$response = array(
					"error" => $error,
					"message" => "Gagal mengunggah photo",
				);
			}else{
				$statusCode = 200;
				$response = array(
					"message" => "Photo berhasil diunggah",
					"fileName" => $config['file_name']
				);
			}
			$this->output->set_status_header(200)
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
					$kode_ikan = str_replace(")","_",str_replace("(","_",$sheet->getCellByColumnAndRow(0, $row)->getValue()));
					$nama_ikan = str_replace(")","_",str_replace("(","_",$sheet->getCellByColumnAndRow(1, $row)->getValue()));
					$deskripsi = str_replace(")","_",str_replace("(","_",$sheet->getCellByColumnAndRow(2, $row)->getValue()));
					if($kode_ikan){
						$data = array(
							"kode_ikan" => $kode_ikan,
							"nama_ikan" => $nama_ikan,
							"deskripsi" => $deskripsi,
						);
	
						$where = array(
							"kode_ikan" => $kode_ikan,
						);
						$cek = $this->db->from("ikan")->where($where)->get();
						if($cek->num_rows() > 0){
							$this->db->where("kode_ikan", $kode_ikan)->update("ikan", $data);
						}else{
							$this->db->insert("ikan", $data);
						}
					}
				}
			}
			$statusCode = 200;
			$response = array(
				"message" => "Data ikan berhasil diunggah",
			);
		}
	}

	public function delete($kode){
		$delete = $this->db->where('kode_ikan', $kode)->delete("ikan");
		$statusCode = 200;
		if(!$delete){
			$statusCode = 403;
			$response = array(
				"error" => "Forbidden",
				"message" => "Data ikan tidak dapat dihapus, karena digunakan sebagai referensi data lain.",
			);
		}else{
			$statusCode = 200;
			$response = array(
				"message" => "Data ikan berhasil dihapus",
			);
		}
		
		$this->output->set_status_header($statusCode)
					->set_content_type('application/json')
					->set_output(json_encode($response));
	}
}
