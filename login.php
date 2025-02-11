<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "kasir");

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $row['role']; // Store role in session
        $_SESSION['logged_in'] = true;
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Login Page</title>
    <style>
        body {
            background-color: #1a1a1a;
            color: #ffffff;
            font-family: poppins, sans-serif;
        }

        .login-form {
            background-color: #2d2d2d;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 2px 2px 5px rgba(255, 0, 0, 0.29);
            max-width: 400px;
            margin: 100px auto;
        }

        h2 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group label {
            color: #ffffff;
        }

        .form-group input {
            background-color: #3d3d3d;
            border: 1px solid #ff0000;
            color: #ffffff;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #ff3333;
            box-shadow: 0 0 5px rgba(255, 0, 0, 0.5);
        }

        .btn-login {
            background: #ff0000;
            color: white;
            padding: 12px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-login:hover {
            background: #cc0000;
        }

        .error {
            color: #ff3333;
            background-color: rgba(255, 0, 0, 0.1);
            padding: 10px;
            border-radius: 4px;
            text-align: center;
        }

        .login-form {
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 94%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .btn-login {
            background:rgb(231, 123, 123);
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="login-form">
        <h2>Login</h2>
        <?php if (isset($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" name="login" class="btn-login">Login</button>
        </form>
    </div>
    <!-- <img src="assets/picmix.com_2613470.gif" alt="" class="img-fluid" style="width: 29%; height: 30%; display: block; margin-left: auto; margin-right: auto;"> -->
</body>

</html>