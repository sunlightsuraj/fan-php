<?php
/**
 * User: suraj
 * Date: 1/20/15
 * Time: 7:26 PM
 */

class LogIn extends Controller
{
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
                  $indexName[] = 'sess_stat';
                  $indexName[] = 'sess_userid';
                  $indexName[] = 'sess_fname';
                  $indexName[] = 'sess_lname';
                  $indexName[] = 'sess_email';

                  $indexValue[] = 1;
                  $indexValue[] = $userId;
                  $indexValue[] = $firstName;
                  $indexValue[] = $lastName;
                  $indexValue[] = $email;

                  Session::sessionCreate($indexName, $indexValue);

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
