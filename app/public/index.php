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
    .pagination{
        text-align:right;
    }
    .pagination ul{
        display:inline-block;
        padding:0;margin:0;
    }
    .pagination ul li{
        padding:0;margin:0;display:inline-block;
        list-style-type:none;
    }
    .pagination a{
        display:inline-block;
        margin-left:10px;
        border-radius:10px;
        padding:5px 10px;
        background:#456789;
        color:#fff;
    }
    .pagination .active{
        background:#987654;
    }
    </style>
</head>
<body>
    <h1>Sakila Actor DB</h1>
    <?php 
        echo "<h2>PHP PDO db test</h2>"; 
        echo "<p>This is a practice page based on one of the default mysql DBs.</p>";
        $getnumberOfActors = $pdo->query('SELECT COUNT(*) FROM sakila.actor');
        $numberOfActors = $getnumberOfActors->fetchColumn() ;

        $sortBy = "actor_id";
        $numOfRecords = 10;
        $recordStart = (empty($_GET['startAt'])) ? 0 : $_GET['startAt'];;
        $recordEnd = $numOfRecords + $recordStart;
        $next = $recordStart + $numOfRecords;
        if($next > $numberOfActors){
            $next = 0;
        }
        $prev = $recordStart - $numOfRecords;
        if($prev < 0){
            $prev = $numberOfActors - $numOfRecords;
        }
        $colNames = [
            'actor_id'      =>"ID",
            'first_name'    =>"First Name", 
            'last_name'     =>'Last Name', 
            'address'       =>'Address', 
            'address2'      =>'Address 2',
            'city'          =>'City', 
            'district'      =>'State',
            'country'       =>'Country', 
            'postal_code'   =>'Postal Code', 
            'phone'         =>'Phone',
        ];
        $limited = 10;
        
        //$stmt = $pdo->query('SELECT first_name, last_name, address, address2,city, district,country, postal_code, phone
        //    FROM sakila.actor 
        //    join sakila.address on sakila.actor.actor_id = sakila.address.address_id 
        //    JOIN sakila.city on sakila.address.city_id = sakila.city.city_id
        //    JOIN sakila.country on sakila.city.country_id = sakila.country.country_id
        //    WHERE sakila.actor.actor_id BETWEEN $recordStart and $recordEnd
        //    LIMIT 10');
        //$coltypes = array();
        $actorsPreparedStatement = 'SELECT actor_id,first_name, last_name, address, address2,city, district,country, postal_code, phone
            FROM sakila.actor 
            join sakila.address on sakila.actor.actor_id = sakila.address.address_id 
            JOIN sakila.city on sakila.address.city_id = sakila.city.city_id
            JOIN sakila.country on sakila.city.country_id = sakila.country.country_id
            WHERE sakila.actor.actor_id BETWEEN :recordStart and :recordEnd
            LIMIT :limited';
        $sth = $pdo->prepare($actorsPreparedStatement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(
            ':recordStart'      => $recordStart, 
            ':recordEnd'        => $recordEnd, 
            ':limited'          => $limited
            )
        );
        $actors = $sth->fetchAll();
        //var_dump($actors);
            

        echo "<h3>Total Number of Actors: ". $numberOfActors.". Fetching $limited at a time, starting at $recordStart.</h3>";
        echo '<table cellspacing=0>';
        echo '<tr>';
            foreach($colNames as $x => $val) {
                echo "<th>".$val."</th>" ;
            }
        echo "</tr>";
        foreach($actors as $row){
            echo "<tr>";
            foreach($row as $info=>$val){
                $i=strtolower($val);
                echo "<td>".$i."</td>";
            }
            echo "</tr>";
        }
        echo '</table>';
       
        echo '<div class="pagination">';
            echo '<a href="?startAt='.$prev.'" class="prev button">previous '.$limited.'</a>';
            echo '<ul class="pages">';

            for($i=0;$i<=($numberOfActors / $limited);$i++){
                if($i == 0){
                    echo '<li><a href="?startAt='.$i .'">'.$i.'</li>';
                }
                else{
                   echo '<li><a href="?startAt='.$i .'0">'.$i.'</li>'; 
                }
                
            }
            echo '</ul>';
            echo '<a href="?startAt='.$next.'" class="next button">next '.$limited.'</a>';

        echo "</div>";
    
    
    ?>
    
</body>
</html>