<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>
        <link rel="stylesheet" href="bowling1.css"/>
        <title>Create a Team</title>
    </head>
    <body>
      <div class="createTeam">  
            <h1>Name Your Team</h1>
            <form method="GET" action="api/insertTeam.php">
                <div class="form-group">
                    <label for="teamID">Team ID</label>
                    <?php echo '<input type="text" name="teamID" class="form-control" value = "'.($_GET['id']+1).'" disabled>'; ?>
                </div>
                <div class="form-group">
                    <label>Team Name</label>
                   <?php echo  '<input type="text" class="form-control" placeholder="Team Name" name="teamName">'; ?>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                
            </form>
        </div>
    </body>
</html>
