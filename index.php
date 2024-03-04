<?php
//Start session to manage user session data
session_start();

//To connect with the database connection file
include "db_conn.php";

//Check if form fields are set and not empty
if (isset($_POST['username']) && isset($_POST['password'])) {

    //Function to filter the input data
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    // Validate and filter the username and password inputs
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    //To check if the username is empty
    if (empty($username)) {
        header("Location: loginform.php?error=User Name is required");
        exit();
    }
    //To check if the password is empty 
    else if (empty($password)) {
        header("Location: loginform.php?error=password is required");
        exit();
    } 
    //Proceed with authentication
    else {
        //To check if username and password match in database
        $sql = "SELECT * FROM users WHERE (user_name=? OR Email=?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt === false) {
            die("Error: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "ss", $username, $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        //To check if there is a matching user record
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            // To check if the email is verified
            if ($row['verified'] == 0) {
                // Redirect user to a verification page or display a message
                header("Location: loginform.php?error=Please verify your email first. Check your email for the verification link");
                exit();
            }
            //To check if username and password match
            if ($row['username']  === $username && $row['password'] === $password) {
                echo "Logged in!";
                // Set session variables for user
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $username;
                // Redirect user to home page
                header("Location: home.php");
                exit();
            } else {
                //To send the user if the credentials are incorrect
                header("Location: loginform.php?error=Incorrect User name or password");
                exit();
            }
        }
        //To send the user if the credentials are incorrect 
        else {
            header("Location: loginform.php?error=Incorrect User name or password");
            exit();
        }
    }
}
//To send the user to login form if the data is not set 
else {
    header("Location: loginform.php");
    exit();
}
?>