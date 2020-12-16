<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bowling Tournament</title>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <style>
            body{
                background-image: url("bgIMG.jpg");
                background-repeat: no-repeat;
                background-size: cover;
                box-sizing: border-box;
            }
            button{
                background-color: black;
                color: white;
                display: block;
                height: 40px;
                line-height: 40px;
                text-decoration: none;
                width: 65%;
                text-align: center;
                font-size: 30px;
                padding-bottom: 45px;
            }
            .logo{
                float: right;
            }
            video{
                position: absolute;
                bottom: 80px;
                width: 700px;
                margin-left: 560px;
            }
            a{
                font-family: monospace;
                color: whitesmoke;
                font-size: 12px;
                position: absolute;
                bottom: 0;
            }
            h1{
                color: white;
                font-size: 50px;
                font-family: sans-serif;
                text-align: center;
            }
            h1{
                margin-bottom: 100px;
            }
        </style>
    </head>
    <body>
        <div class="logo">
            <img src="BrowserArouser_LOGO.png" alt="Awesome Bowling logo" width="100" height="100">
        </div>
        <h1>The Bowling Tournament</h1>
        <div class="container">
            <div class="row">
                <div class="col">
                <form action="guestIndex.php">
                    <button type="submit">Guest</button>
                </form>
            </div>
            <div class="col">
                <form action="scheduledGames.php">
                    <button type="submit">ScoreKeeper</button>  
                </form>
            </div>
            <div class="col">
                <form action="adminIndex.php">
                    <button type="submit">Admin</button>
                </form>
            </div>
        </div>
    </div>
    <video controls>
        <source src="Video.mp4" type="video/mp4">
    </video>
    <a href="ReferencePage.html">Click here to see all the references.</a>
</body>
</html>
