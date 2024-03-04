<?php
    // To connect with the database connection file
    session_start();
    include "db_conn.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // Include PHPMailer autoload file
    require 'PHPmailer/src/Exception.php';
    require 'PHPmailer/src/PHPMailer.php';
    require 'PHPmailer/src/SMTP.php';

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    
    $firstname = $_POST['Firstname'];
    $middlename = $_POST['Middlename'];
    $lastname = $_POST['Lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $verification_code = bin2hex(random_bytes(16)); // Generate a verification code

    function validatePassword($password) {
        // Check if password contains at least one letter and one digit or one of the specified symbols
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*[\d@#$*])[A-Za-z\d@#$*]+$/', $password)) {
            return false;
        }
        return true;
    }
    
    //To validate inputs (should contain letters only)
    function validateLetters($input) {
        return preg_match('/^[A-Za-z]+$/', $input);
    }
    
    //A function to validate email format
    function validateEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    if(empty($username) || empty($email) || empty($password)) {
        header("Location: registrationform.php?error=Please fill in all fields");
        exit();
    } else if($password !== $confirm_password) {
        header("Location: registrationform.php?error=Passwords do not match");
        exit();
    } else {
        // Check if username or email already exists
        $sql = "SELECT * FROM users WHERE user_name='$username' OR Email='$email'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) {
            header("Location: registrationform.php?error=Username or Email already exists");
            exit();
        }
        if (!validateLetters($lastname)) {
            header("Location: registrationform.php?error=Last name should contain only letters");
            exit();
        }
        
        //To validate first name
        if (!validateLetters($firstname)) {
            header("Location: registrationform.php?error=First name should contain only letters");
            exit();
        }
        
        //To validate middle name
        if (!validateLetters($middlename)) {
            header("Location: registrationform.php?error=Middle name should contain only letters");
            exit();
        
        } else {
            // Insert the user into the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
            $sql = "INSERT INTO users (First_name, Middle_name, Lastname, user_name, Email, Password, verification_code) VALUES ('$firstname', '$middlename', '$lastname', '$username', '$email', '$hashed_password', '$verification_code')";

            if(mysqli_query($conn, $sql)){
                
                    // SMTP configuration
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';  // SMTP server address
                    $mail->SMTPAuth = true;
                    $mail->Username = 'kimandriemancera@gmail.com';  // SMTP username
                    $mail->Password = 'oaydmfuyxcujdbau';  // SMTP password
                    $mail->SMTPSecure = 'tls';          // Enable TLS encryption
                    $mail->Port = 587;                  // TCP port to connect to
            
                    // Email content
                    $mail->setFrom('kimandriemancera@gmail.com');
                    $mail->addAddress($email);
                    $mail->isHTML(true);
                    $mail->Subject = 'Email Verification';
                    $mail->Body = 'Please click the "verify" link to verify your email: <a href="http://localhost/ipt101/verified.php?email='.$email.'&code='.$verification_code.'">Verify</a>';
            
                    // Send email
                    try {$mail->send();
                
                    header("Location: sent_notice.php?message=Verification email sent. Please check your email to verify your account.");
                } catch (Exception $e) {
                    header("Location: registrationform.php?error=Failed to send verification email. Please try again later.");
                }
            } else {
                echo "ERROR: Hush! Sorry $sql. " . mysqli_error($conn);
            }
        }
    }

mysqli_close($conn);
?>
