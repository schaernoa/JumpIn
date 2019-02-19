<?php
//Wenn der Benutzer eine Session hat
if($_SESSION['benutzer_app']){
    echo '
    <div id="div_navigation" class="div_navigation_overlay">
        <div class="div_navigation_overlay_content">
            '.getWriteinPossebilities('header').'
            <a href="wochenplan">Wochenplan </a>
            <a href="steckbrief_choice">Steckbrief</a>
            '.getFeedback('header').'
            <a href="notfall">Notfall</a>
        </div>
    </div>
    <header>
        <nav>
            <div id="div_header_logout">
                <a href="validate_logout">
                    <img class="img_header_login" src="./image/logout.png" alt="logout">
                </a>
            </div>
            <a href="home">
                <img class="img_header_two" src="./image/postlogo.png" alt="postlogo">
            </a>
            <div class="div_nav_open">
                <span id="navigation_button" onclick="openNav()"></span>
            </div>
        </nav>
    </header>';
}
else{
    echo '
    <div id="div_navigation" class="div_navigation_overlay">
        <div class="div_navigation_overlay_content">
            <a href="home">Home</a>
            <a href="login">Login</a>
        </div>
    </div>
    <header>
        <nav>
            <div id="div_header_login">
                <a href="login">
                    <img class="img_header_login" src="./image/login.png" alt="login">
                </a>
            </div>
            <a href="home">
                <img class="img_header_two" src="./image/postlogo.png" alt="postlogo">
            </a>
            <div class="div_nav_open">
                <span id="navigation_button" onclick="openNav()"></span>
            </div>
        </nav>
    </header>';
}

?>
<script>
    document.getElementById('navigation_button').addEventListener('click', function () {
        if (this.classList.contains('clicked')) {
            this.classList.remove('clicked');
            closeNav();
        }
        else {
            this.classList.add('clicked');
            openNav();
        }
    });
    function openNav() {
        document.getElementById("div_navigation").style.width = "100%";
        document.getElementsByTagName("body")[0].style = 'overflow-y: hidden;'
    }
    function closeNav() {
        document.getElementById("div_navigation").style.width = "0%";
        document.getElementsByTagName("body")[0].style = 'overflow-y: visible;'
    } 
</script>