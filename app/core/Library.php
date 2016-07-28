<?php

/**
 * Class Library
 * This is a custom library
 * contains method that are global or used by all/most of the other models
 */
class Library
{
	private static $instance = null;

	private $error;

	private static function getObject () {
		if (static::$instance == null)
			static::$instance = new Library();

		return static::$instance;
	}

	/**
	 * function to redirect to location
	 *
	 * @param $location
	 */
	public static function returnHeader ($location) {
		print "<script type=\"text/javascript\">
                window.location='$location'</script>";
	}

	/**
	 * method to secure input, preventing sql injection
	 * mysql connection must be done before calling this function
	 *
	 * @param $input
	 *
	 * @return string
	 */
	public static function secureInput ($input) {
		return htmlentities(stripslashes(trim($input)));
	}

	/**
	 * function that returns hashed password
	 *
	 * @param $password
	 *
	 * @return bool|string
	 */
	public static function pass_hashing ($password) {
		if (isset($password) && $password != '') {
			//function to hash password
			//encrypt the password
			$password = sha1($password);
			$salt = md5("logging");
			$pepper = "teteetetetecdtr";

			$passencrypt = $salt . $password . $pepper;
			$password = md5($passencrypt);

			return $password;
		} else {
			return false;
		}
	}

	/**
	 * function to upload image
	 *
	 * @param $ImageNamePrefix
	 * @param $ImageFile
	 * @param $ImagePath
	 *
	 * @return bool|string
	 */
	public static function imageupload ($ImageNamePrefix, $ImageFile, $ImagePath) {
		############ Edit settings ##############
		//$ThumbSquareSize 		= 200; //Thumbnail will be 200x200
		$BigImageMaxSize = 500; //Image Maximum height or width
		//$ThumbPrefix			= "thumb_"; //Normal thumb Prefix
		//$DestinationDirectory = 'uploads/';
		$DestinationDirectory = $ImagePath;
		$Quality = 90; //jpeg quality
		##########################################

		//check if this is an ajax request
		/*if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			$this->error = "HTTP_X_request required";
			return false;
		}*/

		try {
			// check $ImageFile not empty
			if (!isset($ImageFile) || !is_uploaded_file($ImageFile['tmp_name'])) {
				//die('Something wrong with uploaded file, something missing!'); // output error when above checks fail.
				throw new Exception("Something wrong with uploaded file, something missing");
				//return false;
			}
			// Random number will be added after image name
			$RandomNumber = rand(0, 9999999999);

			$ImageName = str_replace(' ', '-', strtolower($ImageFile['name'])); //get image name
			//$ImageSize 		= $ImageFile['size']; // get original image size
			$TempSrc = $ImageFile['tmp_name']; // Temp name of image file stored in PHP tmp folder
			$ImageType = $ImageFile['type']; //get file type, returns "image/png", image/jpeg, text/plain etc.

			//Let's check allowed $ImageType, we use PHP SWITCH statement here
			switch (strtolower($ImageType)) {
				case 'image/png':
					//Create a new image from file
					$CreatedImage = imagecreatefrompng($ImageFile['tmp_name']);
					break;
				case 'image/gif':
					$CreatedImage = imagecreatefromgif($ImageFile['tmp_name']);
					break;
				case 'image/JPG':
				case 'image/jpeg':
				case 'image/pjpeg':
					$CreatedImage = imagecreatefromjpeg($ImageFile['tmp_name']);
					break;
				default:
					//die('Unsupported File!'); //output error and exit
					throw new Exception("Unsupported File");
				//return false;
			}

			//PHP getimagesize() function returns height/width from image file stored in PHP tmp folder.
			//Get first two values from image, width and height.
			//list assign svalues to $CurWidth,$CurHeight
			list($CurWidth, $CurHeight) = getimagesize($TempSrc);

			//Get file extension from Image name, this will be added after random name
			$ImageExt = substr($ImageName, strrpos($ImageName, '.'));
			$ImageExt = str_replace('.', '', $ImageExt);

			//remove extension from filename
			//$ImageName 		= preg_replace("/\\.[^.\\s]{3,4}$/", "", $ImageName);

			//Construct a new name with random number and extension.
			//$NewImageName = $ImageName.'-'.$RandomNumber.'.'.$ImageExt;
			$NewImageName = $ImageNamePrefix . '-' . $RandomNumber . '.' . $ImageExt;

			//set the Destination Image
			//$thumb_DestRandImageName 	= $DestinationDirectory.$ThumbPrefix.$NewImageName; //Thumbnail name with destination directory
			$DestRandImageName = $DestinationDirectory . $NewImageName; // Image with destination directory

			//Resize image to Specified Size by calling resizeImage function.
			if (Library::resizeImage($CurWidth, $CurHeight, $BigImageMaxSize, $DestRandImageName, $CreatedImage, $Quality, $ImageType)) {
				//all done return image path
				return $DestRandImageName;
			} else {
				//die('Resize Error'); //output error
				throw new Exception('Resize Error');
				//return false;
			}
		} catch (Exception $e) {
			Library::getObject()->setError($e->getMessage());
		}
		return false;
	}

	public static function resizeImage ($CurWidth, $CurHeight, $MaxSize, $DestFolder, $SrcImage, $Quality, $ImageType) {
		try {
			// This function will proportionally resize image
			//Check Image size is not 0
			if ($CurWidth <= 0 || $CurHeight <= 0) {
				throw new Exception("Invalid Size of Image");
				//return false;
			}

			//Construct a proportional size of new image
			$ImageScale = min($MaxSize / $CurWidth, $MaxSize / $CurHeight);
			$NewWidth = ceil($ImageScale * $CurWidth);
			$NewHeight = ceil($ImageScale * $CurHeight);
			$NewCanves = imagecreatetruecolor($NewWidth, $NewHeight);

			// Resize Image
			if (imagecopyresampled($NewCanves, $SrcImage, 0, 0, 0, 0, $NewWidth, $NewHeight, $CurWidth, $CurHeight)) {
				switch (strtolower($ImageType)) {
					case 'image/png':
						imagepng($NewCanves, $DestFolder);
						break;
					case 'image/gif':
						imagegif($NewCanves, $DestFolder);
						break;
					case 'image/jpeg':
					case 'image/pjpeg':
						imagejpeg($NewCanves, $DestFolder, $Quality);
						break;
					default:
						throw new Exception("Invalid Image");
					//return false;
				}
				//Destroy image, frees memory
				if (is_resource($NewCanves)) {
					imagedestroy($NewCanves);
				}
				return true;
			} else {
				throw new Exception("image resize error");
			}
		} catch (Exception $e) {
			Library::getObject()->setError($e->getMessage());
		}
		return false;
	}

	private function setError ($error) {
		$this->error = $error;
	}

	public function getError () {
		return $this->error;
	}
}