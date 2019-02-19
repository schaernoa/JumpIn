<?php
    //Error Session leeren
    $_SESSION['error'] = NULL;
    //Wenn der benutzer eingeloggt ist
    if($_SESSION['benutzer_app']){
        //Hole alle Aktivitätsarten die momentan etwas einzuschreiben haben
        getWriteinPossebilities('home');
        echo '
            <a class="a_section" href="wochenplan">
                <section class="section sectionWochenplan">
                    <p class="p_section_default">Wochenplan</p>
                </section>
            </a>
        ';
        echo '
            <a class="a_section" href="steckbrief_choice">
                <section class="section sectionSteckbrief">
                    <p class="p_section_default">Steckbrief</p>
                </section>
            </a>
        ';
        //Hole das Feedback wenn es aufgeschalten wurde
        getFeedback('home');
        echo '
            <a class="a_section" href="notfall">
                <section class="section sectionNotfall">
                    <p class="p_section_default">Notfall</p>
                </section>
            </a>
        ';
    }
    else{
        //Die erlaubten Files festlegen
        $_SESSION['validfiles'] = array("home", "login", "validate_login");
        //Slideshow mit Titel und Text ausgeben
        echo '
            <div class="slideshow_container">
                <div class="slideshow transition">
                    <img class="img_slideshow" src="./image/wanderung.jpg" style="width:100%">
                </div>
                <div class="slideshow transition">
                    <img class="img_slideshow" src="./image/slideshow4.jpg" style="width:100%">
                </div>
                <div class="slideshow transition">
                    <img class="img_slideshow" src="./image/slideshow5.jpg" style="width:100%">
                </div>
                <div class="slideshow transition">
                    <img class="img_slideshow" src="./image/slideshow7.jpg" style="width:100%">
                </div>
                <div class="slideshow transition">
                    <img class="img_slideshow" src="./image/slideshow8.jpg" style="width:100%">
                </div>
                <div class="slideshow transition">
                    <img class="img_slideshow" src="./image/slideshow1.jpg" style="width:100%">
                </div>
                <div class="slideshow transition">
                    <img class="img_slideshow" src="./image/slideshow2.jpg" style="width:100%">
                </div>
            </div>
            <h2>Jump-in App</h2>
            <p class="p_untertitel">
                Das Jump-in App lässt dich ganz einfach für Aktivitäten einschreiben, zeigt dir deinen Wochenplan und lässt dich Steckbriefe ansehen und deinen eigenen kreieren!
            </p>
            <script>
                var slideIndex = 0;
                showSlides();

                function showSlides() {
                    var i;
                    var slides = document.getElementsByClassName("slideshow");
                    for (i = 0; i < slides.length; i++) {
                        slides[i].style.display = "none";  
                    }
                    slideIndex++;
                    if (slideIndex > slides.length) {
                        slideIndex = 1
                    }    
                    slides[slideIndex-1].style.display = "block";  
                    setTimeout(showSlides, 5000);
                }
            </script>
        ';
    }
?>
