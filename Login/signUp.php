<?php
    session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $name = dataFilter($_POST['name']);
    $mobile = dataFilter($_POST['mobile']);
    $user = dataFilter($_POST['uname']);
    $email = dataFilter($_POST['email']);
    $pass = dataFilter($_POST['pass']);
    

    $addr = dataFilter($_POST['addr']);

    $_SESSION['Email'] = $email;
    $_SESSION['Name'] = $name;
    $_SESSION['Password'] = $pass;
    $_SESSION['Username'] = $user;
    $_SESSION['Mobile'] = $mobile;
   
   
    $_SESSION['Addr'] = $addr;
    $_SESSION['Rating'] = 0;
}


require '../db.php';

$length = strlen($mobile);

if($length != 10)
{
    $_SESSION['message'] = "Invalid Mobile Number !!!";
    header("location: error.php");
    die();
}



    
    $sql = "SELECT * FROM buyer WHERE bemail='$email'";

    $result = mysqli_query($conn, "SELECT * FROM buyer WHERE bemail='$email'") or die($mysqli->error());

    if ($result->num_rows > 0 )
    {
        $_SESSION['message'] = "User with this email already exists!";
        //echo $_SESSION['message'];
        header("location: error.php");
    }
    else
    {
        if (isset($_POST) && isset($_POST['submit'])) {
            $bname=$_POST['bname'];
            $busername=$_POST['busername'];
            $bpassword=$_POST['bpassword'];
            $bmobile=$_POST['bmobile'];
            $bemail=$_POST['bemail'];
            $baddress=$_POST['baddress'];
           $sql = "INSERT INTO buyer (bname, busername, bpassword, bmobile, bemail, baddress)
                VALUES ('$name','$user','$pass','$hash','$mobile','$email','$addr')";
               
           
        
            $res = "SELECT * FROM buyer WHERE busername='$user'";
            $result = mysqli_query($conn,$res);
         
            $_SESSION['id'] = $User['bid'];

            $_SESSION['message'] =

                     "Confirmation link has been sent to $email, please verify
                     your account by clicking on the link in the message!";

            $to      = $email;
            $subject = "Account Verification ( ArtCircle.com )";
            $message_body = "
            Hello '.$user.',

            Thank you for signing up!

            Please click this link to activate your account:

            http://localhost/AgroCulture/Login/verify.php?email=".$email."&hash=".$hash;

            //$check = mail( $to, $subject, $message_body );

            header("location: profile.php");
      }
        
        else
        {
            //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            $_SESSION['message'] = "Registration not successfull!";
            header("location: error.php");
        }
    }


function dataFilter($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>
