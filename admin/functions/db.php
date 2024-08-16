<?php
//error reporting. Disable these three lines before deployment.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

/*this file is the main connecor and handles data cleaning and issues of login 

*/
//database connection variables
$host= 'localhost';
$user='root';
$usrpassword='';
$database='company';


  /* DATABASE CONNECTIONS AS DEFINED IN VARIOUS PAGES*/
        //VARIABLES
       global $connection, $mysqli, $conn;

        //INITIALIZING VARIABLES FOR IMPERATIVE AND OOP

        //for OOP uses
        $mysqli=new mysqli($host,$user,$usrpassword,$database);
        //for imperative
        $conn=mysqli_connect($host,$user,$usrpassword,$database);
        //$connection was the original connector in OOP, same as $conn
       $connection = mysqli_connect($host,$user,$usrpassword,$database); 


      if(!$connection){
        //if connection fails, we abort.
          die("Cannot Establish A Secure Connection To The Host Server At The Moment!");
      }

      try{
        //for PDO
          $db = new PDO('mysql:dbhost='.$host.';dbname='.$database.';charset=utf8',$user,$usrpassword);

      }
      catch(Exception $e){

          die('Cannot Establish A Secure Connection To The Host Server At The Moment!');
      }

      /*DATABASE CONNECTION COMPLETE*/


      /*********************************************************
                  other basic methods
      **********************************************************/

        //this function is designed to counter sql injection and format the inputs
      function uncrack($data){
        $data=trim($data);
        $data= htmlspecialchars($data);
        $data=stripcslashes($data);

        //replace quotes and forward slashes for SQL
        $data=str_replace('"', '\\"', $data);
        $data=str_replace("'", "\\'", $data);

        return $data;
      };

       //format usernames
    function is_username($data){
      $data=uncrack($data);
      $data=strtolower($data);
      $data=ucwords($data);
      return $data;
    }

     //format emails
    function is_email($data){
      $data=uncrack($data);
      $data=strtolower($data);
      return $data;
    }

    //not so important but it is critical too for temporary autogenerated passwords.
    function random_password() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyz.ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890@%&';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

   
    function is_logged_in_permanent(){
      if (isset($_COOKIE["name"]) && isset($_COOKIE["tsc"]) && isset($_COOKIE["type"])) {
        //set global variables for logged users and return true
        global $uname, $tsc, $type, $funame;

        $uname=$_COOKIE["name"];
        $tsc=$_COOKIE["tsc"];
        $type=$_COOKIE["type"];
        $funame=substr($uname, 0,strpos($uname," "));//first name

        return true;
      }
      else
      { 
        return false;
      }
    }

     function is_logged_in_temporary(){

      if (isset($_SESSION['email'])) {
        //set global variables for logged users and return true
        global $username;

        $email=$_SESSION["email"];
        $username=substr($email, 0,strpos($email,"@"));//user name

        return true;
      }
      else
      { 
        return false;
      }
    }
?> 