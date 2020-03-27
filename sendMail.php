<!DOCTYPE html>
<html>
    <head>
        <style>
            h1{
                margin-left: 40%;
            }
            input{
                margin-left: 30%;
                width: 250px;
                height: 40px;
            }
            h6{
                margin-left: 30%; 
                margin-top: -10px;
            }
        </style>
    </head>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        <h1><b>Fill up the form</b></h1>
        <input type="text" name="name" placeholder="Enter your name" required>
        <br>
        <br>
        <input type="number" name="year" placeholder="Graduation year" required>
        <br>
        <br>
        <input type="number" name="mobile" placeholder="Mobile number" required>
        <br>
        <br>
        <input type="email" name="email" placeholder="Enter your email" required>
        <br>
        <br>
        <input type="file" id="myFile" name="myFile" required>
        <h6>Upload your resume</h6>
        <br>
        <br>
        <input type="submit">
    </form>

<?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($POST['name']) && isset($_POST['email']) && isset($_POST['year']) && isset($_POST['mobile']))
            {
                $name = $_POST["name"];
                
                $email = $_POST["email"];
                $year = $_POST["year"];
                $mobile =$_POST["mobile"];
            }
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $year = $_POST["year"];
            $mobile =$_POST["mobile"];
          }
        $message="Name is ".$name."Year of graduation ".$year."Mobile number is ".$mobile."Email id ".$email;
        define ('SITE_ROOT', realpath(dirname(__FILE__)));
        if(isset($_FILES['myFile'])){
            $errors= array();
            $file_name = $_FILES['myFile']['name'];
            $file_size =$_FILES['myFile']['size'];
            $file_tmp =$_FILES['myFile']['tmp_name'];
            $file_type=$_FILES['myFile']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['myFile']['name'])));
            
            $extensions= array("docx","doc","pdf","PDF");
            
            if(in_array($file_ext,$extensions)=== false){
            $errors[]="extension not allowed, please choose a docx or doc or pdf file.";
            }
            
            if($file_size > 2097152){
            $errors[]='File size must be excately 2 MB';
            }
            
            if(empty($errors)==true){
            move_uploaded_file($file_tmp,SITE_ROOT.'/files/'.$file_name);
            echo "Success";
            }else{
            print_r($errors);
            }
        }
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
 
        require 'PHPMailer/PHPMailer/src/Exception.php';
        require 'PHPMailer/PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/PHPMailer/src/SMTP.php';
        
        $mail = new PHPMailer;
        $mail->isSMTP(); 
        $mail->SMTPDebug = 2; 
        $mail->Host = "smtp.gmail.com"; 
        $mail->Port = 587; // typically 587 
        $mail->SMTPSecure = 'tls'; 
        $mail->SMTPAuth = true;
        $mail->Username = "username";
        $mail->Password = "password";
        $mail->setFrom("from address", "Sayen Dutta");
        $mail->addAddress("to address", "Raju Dutta");
        $mail->addAttachment('./files/'.$file_name);
        $mail->Subject = 'Testing Mail sending feature';
        $mail->msgHTML($message); // remove if you do not want to send HTML email
        $mail->AltBody = 'HTML not supported';
        
        $mail->send();
?>
</html>