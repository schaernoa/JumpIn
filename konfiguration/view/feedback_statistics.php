<div class="div_main">
    <?php
        //Stack ausgeben
        echo '<p id="p_stack">'.$_SESSION['stack'].'</p>';
    ?>
    <div class="div_form">
        <p class="p_form_title">
            Feedback Statistiken
        </p>
        <?php
            //Farben für die verschiedenen Antwortoptionen pro Frage
            $colors = array("286DA8", "CD5360", "B37D4E", "438496", "A895E2", "780CE8", "E8880C", "9B7E84", "67C06B", "362866", "664222", "0D375B", "802731", "A35971", "EC9B24", "009B32", "4A6068", "4E383D", "8E3306", "867A4A");
            $categories = getAllFeedbackCategories();
            //Für jede Feedbackkategorie
            while($row1 = mysqli_fetch_assoc($categories)){
                //Die Frage ausgeben
                echo '
                    <div class="div_feedback_statistik_frage">
                        '.$row1['frage'].'
                    </div>
                    <div class="div_feedback_statistik_container">
                ';
                //Alle Antworten dieser frage holen
                $answers = getUserFeedbackCountByFeedbackCategoryID($row1['id_feedbackkategorie']);
                //Die gezählten Antworten
                $answercount = $answers['counted'];
                //Alle Optionen der Frage holen
                $options = getAllOptionsByFeedbackID($row1['id_feedbackkategorie']);
                $colorscount = 0;
                //Für jede Option der frage
                while($row2 = mysqli_fetch_assoc($options)){
                    //Wenn es weniger farben gebraucht hat als es hat
                    if($colorscount <= count($colors)){
                        //Brauche die nächste Farbe
                        $color = $colors[$colorscount];
                    }
                    else{
                        //grau ist ur go to
                        $color = "gray";
                    }
                    //Die Antwort ausgeben
                    echo '
                        <div class="div_feedback_statistik_line_container">
                            <div class="div_feedback_statistik_optionen" style="color: #'.$color.';">
                                '.$row2['antwort'].'
                            </div>
                    ';
                    $answercountoption = 0;
                    //Die Antworten der Frage auf die eine Option holen
                    $userfeedback = getUserFeedbackByOptionIDAndFeedbackCategoryID($row2['id_optionen'], $row1['id_feedbackkategorie']);
                    //Für jede dieser Antworten
                    while($row3 = mysqli_fetch_assoc($userfeedback)){
                        //zähle sie
                        $answercountoption++;
                    }
                    //Wenn es nicht 0 Antworten auf diese Frage gibt
                    if($answercount != 0){
                        //Berechne die Prozentzahl von Personen die diese Option und nicht eine andere genommen haben
                        $percentage = round(100*($answercountoption / $answercount), 1);
                        //Einen Farbigen Balken mit der Prozentualen Belegung dieser Antwortoption ausgeben
                        echo '
                                <div class="div_feedback_statistik_antwort" style="width: calc(((100% - 400px)/100)*'.$percentage.'); background-color: #'.$color.';"></div>
                                <p class="p_feedback_statistik_antwort">'.$percentage.'%</p>
                            </div>
                        ';
                    }
                    else{
                        //0% ausgeben
                        $percentage = 0;
                        echo '
                                <p class="p_feedback_statistik_antwort">'.$percentage.'%</p>
                            </div>
                        ';
                    }
                    $colorscount++;
                }
                echo '
                    </div>
                    <p class="p_feedback_statistik_bemerkungen">
                        Bemerkungen
                    </p>
                ';
                //hole alle bemerkungen für diese Feedbackkategorie
                $userbemerkung = getUserFeedbackByFeedbackCategoryIDAndBemerkung($row1['id_feedbackkategorie']);
                //Für jede Bemerkung
                while($row4 = mysqli_fetch_assoc($userbemerkung)){
                    //Wenn sie nicht leer ist
                    if($row4['bemerkung'] != NULL){
                        //gib sie unter den Antwortoptionenbelegungen aus 
                        echo '
                            <div class="div_feedback_statistik_bemerkungen">
                                '.$row4['bemerkung'].'
                            </div>
                        ';
                    }   
                }
                echo '
                    <br>
                    <br>
                ';
            }
        ?>
        <p class="p_form_title">
            Feedback pro Benutzer
        </p>
        <?php
            require_once('error.php');
        ?>
        <p class="p_content">
            Schauen Sie sich das Feedback eines Benutzers genauer an! Suchen können Sie mit dem Benutzernamen.
        </p>
        <?php
            $user = getAllUser();
            $usernames = [];
            //Für jeden Benutzer
            while($row = mysqli_fetch_assoc($user)){
                //Wenn der benutzername nicht Admin ist
                if(strtolower($row['benutzername']) != 'admin'){
                    //Füge den benutzer einem Benutzerarray hinzu
                    array_push($usernames, $row['benutzername']);
                }
            }
        ?>
        <form autocomplete="off" method="post" action="validate_feedback_statistics">
            <div class="div_input_user_search">
                <input id="input_user_search" type="text" name="username" placeholder="Benutzername">
            </div>
            <input class="button_search" name="submit_btn" type="submit" value="Anzeigen">
        </form>
        <form action="validate_feedback_statistics" method="post">
            <input class="button_zurück" type="submit" name="submit_btn" value="Zurück">
        </form>
    </div>
</div>

<script>
    //Javascript um eine Dynamische Liste unter der Benutzereingabe zu erstellen
    var usernames = <?php echo json_encode($usernames)?>;
    autocomplete(document.getElementById("input_user_search"), usernames);

    function autocomplete(inp, arr) {
        var currentFocus;
        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            closeAllLists();
            if (!val) { return false;}
            currentFocus = -1;
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            this.parentNode.appendChild(a);
            for (i = 0; i < arr.length; i++) {
                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    b = document.createElement("DIV");
                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(val.length);
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    b.addEventListener("click", function(e) {
                        inp.value = this.getElementsByTagName("input")[0].value;
                        closeAllLists();
                    });
                    a.appendChild(b);
                }
            }
        });
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                currentFocus++;
                addActive(x);
            } else if (e.keyCode == 38) {
                currentFocus--;
                addActive(x);
            } else if (e.keyCode == 13) {
                e.preventDefault();
                if (currentFocus > -1) {
                if (x) x[currentFocus].click();
                }
            }
        });
        function addActive(x) {
            if (!x) return false;
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            x[currentFocus].classList.add("autocomplete-active");
        }
        function removeActive(x) {
            for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
            }
        }
        function closeAllLists(elmnt) {
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }
        document.addEventListener("click", function (e) {
            closeAllLists(e.target);
        });
    }
</script>