<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
            <p>Enter the $_POST Values</p>
            <form action="newFlock.php"
                method="post"
                <p>Mobile Number<input type="text" name="mobile"/></p>
                <p>Shepherd Name<input type="text" name="sheepName"/></p>
                <p>Flock Name<input type="text" name="flockName"/></p>
                <p>Start Time<input type="text" name="start"/></p>
                <p>End Time<input type="text" name="end"/></p>
                <p>Max Distance<input type="text" name="maxDistance"/></p>                
                
                <p><input type="submit" name="test" value="addFlock"/></p>           
            </form>        
    
            <p>Enter the $_POST Values</p>
            <form action="newSheep.php"
                method="post"
                <p>Flock ID<input type="text" name="flockID"/></p>
                <p>Mobile Number<input type="text" name="mobile"/></p>
                <p>Sheep Name<input type="text" name="sheepName"/></p>
                
                <p><input type="submit" name="test" value="addSheep"/></p>           
            </form>    

        <?php
        // put your code here
        ?>
    </body>
</html>
