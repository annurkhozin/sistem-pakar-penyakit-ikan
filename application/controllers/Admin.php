<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function index(){
		if($this->session->userdata("session_id") && $this->session->userdata("session_type")==1){
			$response = array(
				"title" => "Admin sistem",
				"html" => $this->load->view('admin', '', TRUE)
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

		$count = $this->db->count_all_results('akun'); // get semua
		$response['recordsTotal'] = $response['recordsFiltered']= $count;

		if($search!=""){
			$this->db->like("username",$search);
			$this->db->or_like("nama_lengkap",$search);
			$this->db->from('akun');
			$this->db->Order_by('nama_lengkap','ASC');
			
			$countFilter = $this->db->get(); // get filter
			$response['recordsFiltered']=$countFilter->num_rows();
		}
		if($search!=""){
			$this->db->like("username",$search);
			$this->db->or_like("nama_lengkap",$search);
		}
		
		$this->db->from('akun');
		$this->db->Order_by('username','ASC');
		$this->db->limit($length,$start);
		$query = $this->db->get(); // get filter

		foreach ($query->result() as $row) {
			$response['data'][] = array(
				"kode_akun"=>$row->kode_akun,
				"username"=>$row->username,
				"tipe_akun"=>$row->tipe_akun,
				"nama_lengkap"=>$row->nama_lengkap,
			);
		}
		$this->output->set_status_header(200)
					->set_content_type('application/json')
					->set_output(json_encode($response));
	}

	public function save(){
		$kode = $this->input->post("kode_akun");
		$tipe_akun = $this->input->post("tipe_akun");
		$username = $this->input->post("username");
		$username_lama = $this->input->post("username_lama");
		$password = $this->input->post("password");
		$nama = $this->input->post("nama_lengkap");
		$form_type = $this->input->post("form_type");
		$statusCode = 200;
		if(!$username){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Username wajib diisi",
			);
		}else if(!$nama){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Nama Pengguna wajib diisi",
			);

		}else if($form_type == "create" && !$password){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Password wajib diisi",
			);

		}else{
			$where = array(
				"username" => $username,
			);
			$cek = $this->db->from("akun")->where($where)->get();
			if($cek->num_rows() > 0 && ($form_type == "create" || ($form_type == "update" && $username_lama!=$username ))){
				$statusCode = 406;
				$response = array(
					"error" => "Bad request",
					"message" => "Username sudah digunakan",
				);
			}else{
				$data = array(
					"username" => $username,
					"tipe_akun" => $tipe_akun,
					"nama_lengkap" => $nama,
				);

				if($password){
					$data["password"] = md5($password);
				}

				if($form_type == "update"){
					if($kode == $this->session->userdata("session_id")){
						$this->session->set_userdata("session_nama",$nama);
					}
					$this->db->where("kode_akun", $kode)->update("akun", $data);
					$statusCode = 200;
					$response = array(
						"message" => "Data admin berhasil diperbarui",
					);
				}else{
					$this->db->insert("akun", $data);
					$statusCode = 200;
					$response = array(
						"message" => "Data admin berhasil ditambahkan",
					);
				}
			}
		}

		$this->output->set_status_header($statusCode)
					->set_content_type('application/json')
					->set_output(json_encode($response));
		
	}

	public function delete($kode){
		$delete = $this->db->where('kode_akun', $kode)->delete("akun");
		$statusCode = 200;
		if(!$delete){
			$statusCode = 403;
			$response = array(
				"error" => "Forbidden",
				"message" => "Data admin tidak dapat dihapus, karena digunakan sebagai referensi data lain.",
			);
		}else{
			$statusCode = 200;
			$response = array(
				"message" => "Data admin berhasil dihapus",
			);
		}
		
		$this->output->set_status_header($statusCode)
					->set_content_type('application/json')
					->set_output(json_encode($response));
	}
}
