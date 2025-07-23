<?php
    
    //require_once './inc/helper.php';
    require_once 'Tf_mask.php';
    $mk = new Tf_mask();

    echo '<br>';
    echo $num = $mk->generate_mask();
    echo '<br>'; 
    if ($mk->pass($num))
    {
        echo '<br>'; 
        echo '=================Please Enter================';
    }
    echo '<br>';
?>
<html>
<body>
        
        Welcome Dear<?php echo $_POST["name"]; ?><br>
        Your email address is: <?php echo $_POST["email"]; ?>
</body>
</html>