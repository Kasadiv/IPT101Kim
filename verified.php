<?php
// To connect with the database connection file
include "db_conn.php";

// Retrieve the email and verification code from the URL
$email = $_GET['email'];
$verification_code = $_GET['code'];

// Check if the verification code exists in the database
$sql = "SELECT * FROM users WHERE Email='$email' AND verification_code='$verification_code'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Update the 'verified' column to 1
    $sql_update = "UPDATE users SET verified = 1 WHERE Email='$email' AND verification_code='$verification_code'";
    if (mysqli_query($conn, $sql_update)) {
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Verified</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
            rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
            crossorigin="anonymous">
        </head>
        <body>
            <div class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 m-5">
                            <h2 style="color:black">Email has been successfully verified</h2>

                            <form action="index_login.php" method="post">
                                <button type="submit" class="btn btn-primary">LOG IN</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" 
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" 
            crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" 
            integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" 
            crossorigin="anonymous"></script>
            
        </body>
        </html>
        
        
        
        ';
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    echo "Invalid verification code.";
}

// Closing the database connection
mysqli_close($conn);
?>