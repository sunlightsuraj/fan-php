<?php
/**
 * User: suraj
 * Date: 1/20/15
 * Time: 7:26 PM
 */

class LogIn extends Controller
{
	private $user;

	function __construct() {
		parent::__construct();
		if($this->isLoggedIn) {
			header("location: ".site_url);
		}
		$this->user = $this->model('User');
	}

	public function index($name = '') {
		try{
			if($_POST) {
				if(isset($_POST['login_email']) && isset($_POST['login_pass']) && !empty($_POST['login_email']) && !empty($_POST['login_pass'])) {
					if(filter_var($_POST['login_email'], FILTER_VALIDATE_EMAIL)) {
						if(strlen($_POST['login_pass']) >= 8) {
							$email = $this->lib->secureInput($_POST['login_email']);
							$pass = $this->lib->pass_hashing($_POST['login_pass']);

							$result = $this->user->logInUser([$email, $pass]);
							if($result['status']) {
								$userInfo = array_map('stripslashes', $result['result']);
								//user Information
								$userId = $userInfo['userid'];
								$firstName = $userInfo['firstname'];
								$lastName = $userInfo['lastname'];
								$email = $userInfo['email'];

								// creating user session
								$sessionData[] = ['name' => 'sess_stat', 'value' => 1];
								$sessionData[] = ['name' => 'sess_userid', 'value' => $userId];
								$sessionData[] = ['name' => 'sess_fname', 'value' => $firstName];
								$sessionData[] = ['name' => 'sess_lname', 'value' => $lastName];
								$sessionData[] = ['name' => 'sess_email', 'value' => $email];

								Session::sessionCreate($sessionData);

								header("location: ".site_url);
							} else {
								throw new Exception($this->user->getError());
							}
						} else {
							throw new Exception("Password must be at least 8 character long", 1);
						}
					} else {
						throw new Exception("Invalid Email");
					}
				} else {
					throw new Exception("Invalid Information", 1);
				}
			}
		} catch (Exception $e) {
			$this->error = $e->getMessage();
		}
		$this->view('common/head', ['title' => 'MVC LOGIN']);
		$this->view('login/login', ['error' => $this->error]);
		$this->view('common/foot');
	}
}
