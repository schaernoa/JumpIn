<h2>Notfallzettel</h2>
<table>
<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    $emergencies = getAllEmergencyCategories();
    //Für alle Inhalte in der Notfallkarte
    while($row = mysqli_fetch_assoc($emergencies)){
        //Eine Tabellenzeile mit zwei Spalten ausgeben
        echo '
            <tr>
                <th>'.$row['name'].'</th>
                <th>'.$row['info'].'</th>
            </tr>
        ';
    }
?>
</table>
<form method="get" action="home">
    <input class="button_zurück" type="submit" name="submit_btn" value="Zurück">
<form>