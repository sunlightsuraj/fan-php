<?php
/**
 * User: suraj
 * Date: 1/21/15
 * Time: 12:26 PM
 */

class Register extends Controller
{
    function __construct() {
      parent::__construct();
      if($this->isLoggedIn) {
        header("location: ".site_url);
      }
      $this->user = $this->model('User');
    }

    public function index() {
      try {
        if($_POST) {
          if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['c_pass']) && !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['pass']) && !empty($_POST['c_pass'])) {
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
              if($_POST['pass'] === $_POST['c_pass']) {
                if(strlen($_POST['pass']) >= 8) {
                  $firstName = $this->lib->secureInput($_POST['firstname']);
                  $lastName = $this->lib->secureInput($_POST['lastname']);
                  $email = $this->lib->secureInput($_POST['email']);
                  $pass = $this->lib->pass_hashing($this->lib->secureInput($_POST['pass']));

                  //check if email already exist or not
                  $result = $this->user->checkEmail([$email]);
                  if ($result['status']) {
                    $result = $this->user->registerUser([$firstName,$lastName,$email,$pass]);
                    if($result['status']) {
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
                      throw new Exception($this->user->getError());
                    }
                  } else {
                    // email already exists
                    throw new Exception($this->user->getError());
                  }
                } else {
                  throw new Exception("Password must be at least 8 character long");
                }
              } else {
                throw new Exception("Confirmation password doesn't match");
              }
            } else {
              throw new Exception("Invalid email");

            }
          } else {
            throw new Exception("Invalid Information");
          }
        }
      } catch (Exception $e) {
        $this->error = $e->getMessage();
      }

      $this->view('common/head', ['title' => 'MVC - Register']);
      $this->view('register/register', ['error' => $this->error]);
      $this->view('common/foot');
    }
}
