<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . "../assets/sso/vendor/autoload.php";//memangil fungsi single sign on @aziz: 14/02/2018
class User_authentication extends CI_Controller
{
    function __construct(){
		parent::__construct();
    }
    
    public function index(){
		
		//load google login view
		$this->load->view('user_authentication/index');
	}
	public function sso_authentication(){
		
		$client = new Google_Client();
		/**
	login_sso:
		$client->setClientId('di isi clien id dari google');
		$client->setClientSecret("di isi ClientSecret");
		$client->setRedirectUri("alamat di mana script sso di panggil dan sesuai yang terdaftar");
		clintid dan scret client hanya berfungsi di http://localhost/sso_google_ci 
		jika akan di onlinekan atau ganti url silahkan daftar ulang lewat API Google console.developers.google.com
	@aziz: 23/02/2016
**/
		$client->setClientId('963518883182-rl61a299551mvui00g39mjemrbrd6elu.apps.googleusercontent.com');
		$client->setClientSecret("NpC55wbStiq1p_qP0WYm1cNW");
		$client->setRedirectUri("http://localhost/sso_google_ci/user_authentication/sso_authentication");
		$client->setScopes(array(
			"https://www.googleapis.com/auth/userinfo.email",
			"https://www.googleapis.com/auth/userinfo.profile",
			"https://www.googleapis.com/auth/plus.me"
		));
		if (!isset($_GET['code'])) {
			$auth_url = $client->createAuthUrl();
			header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
		  } else {
			$client->authenticate($_GET['code']);
			$_SESSION['access_token'] = $client->getAccessToken();
			try {
				// profile
				$plus = new Google_Service_Plus($client);
				$_SESSION['access_profile'] = $plus->people->get("me");
			} catch (\Exception $e) {
				echo $e->__toString();
		  
				$_SESSION['access_token'] = "";
				die;
			}
			$this->session->set_userdata('loggedIn');
			redirect("user_authentication/profile");	
		  }
	}
	public function profile(){
		//redirect to login page if user not logged in
		//if(!$this->session->userdata('loggedIn')){
			//redirect('user_authentication/index');
		//}
		
		//get user info from session
		if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
	
			$profile = $_SESSION['access_profile'];
			$data['image']=$profile['image']['url'];
			$data['name']=$profile['displayName'];
			$data['email']=$profile['emails']['0']['value'];
			$data['userData'] = $this->session->userdata('userData');
		}
		//load user profile view
		$this->load->view('user_authentication/profile',$data);
	}
	
	public function logout(){
		//delete login status & user info from session
		$this->session->unset_userdata('loggedIn');
		$this->session->unset_userdata('userData');
		$_SESSION['access_token'] = "";
		$_SESSION['access_profile'] = "";
		$this->session->sess_destroy();
		
		//redirect to login page
		redirect('user_authentication/');
    }
}
