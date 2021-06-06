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
    <style>
    table{
        border:1px solid
    }
    tr{
        padding:0;margin:0;
        
    }
    table td{
        margin:0;
        padding:2px;
        border-right:1px solid;
        border-top:1px solid;
    }
    table td:last-child{
        border-right:0
    }
    table th{
        background:#ccc;
    }
    </style>
</head>
<body>
    <h1>Heeeey</h1>
    <?php 
        echo "<h2>PDO db test</h2>"; 
        $recordStart = 20;
        $recordEnd = 30;
        $numberOfActors = $pdo->query('SELECT COUNT(*) FROM sakila.actor');
        $stmt = $pdo->query('SELECT first_name, last_name, address, address2,city, district,country, postal_code, phone
            FROM sakila.actor 
            join sakila.address on sakila.actor.actor_id = sakila.address.address_id 
            JOIN sakila.city on sakila.address.city_id = sakila.city.city_id
            JOIN sakila.country on sakila.city.country_id = sakila.country.country_id
            WHERE sakila.actor.actor_id BETWEEN $recordStart and $recordEnd
            LIMIT 10');
        $coltypes = array();
        echo "<h3>Total Number of Actors: ". $numberOfActors->fetchColumn()."</h3>";
        echo '<table cellspacing=0>';
        echo '<tr>';
        for ($i = 0; $i <  $stmt->columnCount(); $i++) {
            $col = $stmt->getColumnMeta($i);
            if($col['native_type']==="VAR_STRING"){
               echo "<th>".$col['name']."</th>" ; 
            }
            
            array_push($coltypes, $col['native_type']);
        }
        echo "</tr>";
        while ($row = $stmt->fetch()){
            $c = 0;
            echo "<tr>";    
                foreach($row as $item){
                    if($coltypes[$c] ==="VAR_STRING"){
                        $i=strtolower($item);
                        echo "<td>$i</td>";
                    }
                    $c++;
                }
            echo "</tr>";

        }
        echo '</table>';
       
        echo '<div class="pagination">';
            

        echo "</div>";
    
    
    ?>
    
</body>
</html>