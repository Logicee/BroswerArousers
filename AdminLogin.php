<!DOCTYPE html>
 <html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Log</title>
              <link rel="stylesheet" href="bowling1.css"/>
        <script></script></head>
    <body>
 <h1>Please enter a username and password</h1>
 <img src="bowling.jpg" alt="Bowling Ball" width="500" height="400" class="pic">
 <form action="adminVerify.php" method="POST">
     <input name="email" type="text" required>
     <input name="pass" type="text" required>
     <button type="submit" name="Login" >Login now</button>
     <button type="submit" name="Create">Create Account</button>
 
 </form>
    </body>
 </html>