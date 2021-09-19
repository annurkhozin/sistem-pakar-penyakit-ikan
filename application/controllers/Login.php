<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index(){
		$this->session->unset_userdata("session_id");
		$this->session->unset_userdata("session_nama");
		$response = array(
			"title" => "Login",
			"html" => $this->load->view('login', '', TRUE)
		);

		$this->output->set_status_header(200)
					->set_content_type('application/json')
					->set_output(json_encode($response));
	}

	public function register(){
		$response = array(
			"title" => "Register",
			"html" => $this->load->view('register', '', TRUE)
		);

		$this->output->set_status_header(200)
					->set_content_type('application/json')
					->set_output(json_encode($response));
	}

	public function profile(){
		if($this->session->userdata("session_id")){
			$response = array(
				"title" => "Profile",
				"html" => $this->load->view('profile', '', TRUE)
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

	public function cekLogin(){
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		$statusCode = 200;
		if(!$username){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Username wajib diisi",
			);
		}else if(!$password){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Password wajib diisi",
			);

		}else{
			$where = array(
				"username" => $username,
				"password" => md5($password),
			);
			$cek = $this->db->from("akun")->where($where)->get();
			if($cek->num_rows() > 0){
				$data = $cek->row_array();
				$this->session->set_userdata("session_id", $data['kode_akun']);
				$this->session->set_userdata("session_type", $data['tipe_akun']);
				$this->session->set_userdata("session_nama", $data['nama_lengkap']);
				$statusCode = 200;
				$response = array(
					"message" => "Berhasil Login",
				);
			}else{
				$statusCode = 406;
				$response = array(
					"error" => "Not Acceptable",
					"message" => "Username atau password tidak sesuai",
				);
			}
		}
		$this->output->set_status_header($statusCode)
					->set_content_type('application/json')
					->set_output(json_encode($response));
		
	}

	public function registerbaru(){
		$nama_lengkap = $this->input->post("nama_lengkap");
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		$ulang_password = $this->input->post("ulang_password");
		$statusCode = 200;
		if(!$nama_lengkap){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Nama lengkap Anda wajib diisi",
			);
		}else if(!$username){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Username wajib diisi",
			);
		}else if(!$password){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Password wajib diisi",
			);
		}else if($password != $ulang_password){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Konfirmasi Password tidak sama",
			);
		}else{
			$where = array(
				"username" => $username
			);
			$cek = $this->db->from("akun")->where($where)->get()->num_rows();
			if($cek > 0 ){
				$statusCode = 400;
				$response = array(
					"error" => "Bad request",
					"message" => "Username sudah digunakan, silahkan gunakan username yang lain",
				);
			}else{
				$data = array(
					"nama_lengkap" => $nama_lengkap,
					"username" => $username,
					"password" => md5($password),
					"tipe_akun" => 0
				);
				$this->db->insert("akun",$data);
				$statusCode = 200;
				$response = array(
					"message" => "Berhasil Mendaftar",
				);
			}
		}
		
		$this->output->set_status_header($statusCode)
					->set_content_type('application/json')
					->set_output(json_encode($response));
	}

	function profiledata(){
		$query = $this->db->where("kode_akun",$this->session->userdata("session_id"))->get('akun')->row_array();
		
		$this->output->set_status_header(200)
					->set_content_type('application/json')
					->set_output(json_encode($query));
	}

	public function profileupdate(){
		$nama_lengkap = $this->input->post("nama_lengkap");
		$username_lama = $this->input->post("username_lama");
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		$ulang_password = $this->input->post("ulang_password");
		$statusCode = 200;
		if(!$nama_lengkap){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Nama lengkap Anda wajib diisi",
			);
		}else if(!$username){
			$statusCode = 400;
			$response = array(
				"error" => "Bad request",
				"message" => "Username wajib diisi",
			);
	
		}else{
			
			$where = array(
				"username" => $username
			);
			$cek = $this->db->from("akun")->where($where)->get()->num_rows();
			if($cek > 0 && $username != $username_lama){
				$statusCode = 400;
				$response = array(
					"error" => "Bad request",
					"message" => "Username sudah digunakan, silahkan gunakan username yang lain",
				);
			}else{
				if($password){
					if($password != $ulang_password){
						$statusCode = 400;
						$response = array(
							"error" => "Bad request",
							"message" => "Konfirmasi Password tidak sama",
						);
						return $this->output->set_status_header($statusCode)
							->set_content_type('application/json')
							->set_output(json_encode($response));
					}
				}
				$this->session->set_userdata("session_nama", $nama_lengkap);
				$data = array(
					"nama_lengkap" => $nama_lengkap,
					"username" => $username,
				);
				if($password){
					$data["password"] = md5($password);
				}
				$this->db->where("username",$username_lama)->update("akun",$data);
				$statusCode = 200;
				$response = array(
					"message" => "Profil berhasil diperbarui",
				);
			}
		}
		
		$this->output->set_status_header($statusCode)
					->set_content_type('application/json')
					->set_output(json_encode($response));
	}

}
