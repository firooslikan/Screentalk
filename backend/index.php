<!DOCTYPE html>
<html>
<head>
    <title>Screentalk</title>
    <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
    <div class="container">
    <img src="screentalks_.png" alt="">
    	
        <form action="loginprocess.php" method="post">
          <div class="txt_field">
            <input type="text" id="username" name="username" required placeholder="Username" autocomplete="off"><br><br>
          </div>
          <div class="txt_field">
            <input type="password" id="password" name="password" required placeholder="Password"><br><br>
          </div>
            <button type="submit">Log in</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>
