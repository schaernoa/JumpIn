<?php
    //Wenn ein Benutzer eingeloggt ist
    if($_SESSION['benutzer']){
        echo '
        <header>
            <img id="img_postlogo" src="./image/postlogo.png" alt="postlogo">
            <nav>
                <span class="span_headertitle">
                    <a id="a_headertitle" href="logout">Logout</a>
                </span>
            </nav>
        </header>';
    }
    else{
        echo '
        <header>
            <img id="img_postlogo" src="./image/postlogo.png" alt="postlogo">
        </header>';
    }
?>