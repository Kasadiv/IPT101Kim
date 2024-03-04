
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <br>
                <?php if(isset($_GET['error'])) { ?>
                    <div class="alert alert-danger text-center">
                        <?php echo $_GET['error']; ?>
                    </div>
                <?php } ?>
                <form class="shadow-lg p-3 mb-5 bg-white rounded" action="register.php" method="POST">
                    <h2 class="text-center">Register</h2>
                    <div class="mb-3">
                        <label for="Firstname" class="form-label">Firstname:</label>
                        <input type="text" name="Firstname" class="form-control" placeholder="Firstname" required>
                    </div>
                    <div class="mb-3">
                        <label for="Middlename" class="form-label">Middlename:</label>
                        <input type="text" name="Middlename" class="form-control" placeholder="Middlename" required>
                    </div>
                    <div class="mb-3">
                        <label for="Lastname" class="form-label">Lastname:</label>
                        <input type="text" name="Lastname" class="form-control" placeholder="Lastname" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password:</label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                    </div>
                    <button type="submit" name="register_btn" class="btn btn-primary">Register</button>
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="text-center">
                                <a href="loginform.php">Click to login</a>
                    </div>
            </div>
        </div>
                </div>
                </form>
            </div>
        </div>
        
        </div>
    </div>
</body>
</html>