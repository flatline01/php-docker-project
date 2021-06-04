<?php 
    include('../db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Heeeey</h1>
    <?php 
        echo "<h3>db test</h3>"; 
        

        $stmt = $pdo->query('SELECT * FROM sakila.actor join sakila.address on sakila.actor.actor_id = sakila.address.address_id');
        echo '<table>';
        while ($row = $stmt->fetch())
        {
            echo "<tr>";
                echo "<td>" . strtolower ($row['first_name']) . "</td>";
                echo "<td>" . strtolower ($row['last_name']) . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>" . $row['district'] . "</td>";
            echo "</tr>";

        }
        echo '</table>';
    
    
    
    ?>
    
</body>
</html>