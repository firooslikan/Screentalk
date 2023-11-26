<!DOCTYPE html>
<html>
<head>
    <title>Screentalk</title>
    <link rel="stylesheet" type="text/css" href="register.css">
</head>
<body>
    <div class="container">
    <img src="screentalks_.png" alt="">
        <form action="registerprocess.php" method="post">
        <div class="txt_field">
            <input type="text" id="username" name="username" required placeholder="Username" autocomplete="off"><br><br>
        </div>
        <div class="txt_field">
            <input type="text" id="display_name" name="display_name" required placeholder="Display Name" autocomplete="off"><br><br>
        </div>
        <div class="txt_field">
            <input type="text" id="email" name="email" required placeholder="Email Address" autocomplete="off"><br><br>
        </div>
        <div class="txt_field">
            <input type="password" id="password" name="password" required placeholder="Password" autocomplete="off"><br><br>
        </div>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="index.php">Login</a></p>
    </div>
</body>
</html>