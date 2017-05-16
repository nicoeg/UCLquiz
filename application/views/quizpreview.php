<section class="topButtons">
    <div class="row">
        <div class="col-xs-6">
            <div class="box-row">
                <button class="addQuizButton"><a>Tilføj Quiz</a></button>
            </div>
        </div>
        <div class="col-xs col-xs-offset-2">
            <div class="box-row">
                <a id="viewModeText">View Mode</a>
                <button class="viewModeButton" id="viewModeButton1" onclick="openTab(event, 'Mode1')"><i class="material-icons">view_module</i></button>
                <button class="viewModeButton" id="viewModeButton2" onclick="openTab(event, 'Mode2')"><i class="material-icons">view_list</i></button>
            </div>
        </div>
    </div>
</section>

<section class="sideMenu">
    <div class="category">
        <ul>
            <li><a href="#">Nyeste quizzer</a></li>
            <li><a href="#">Emner</a>
                <ul id="underCategory">
                    <li><a href="#">Knogler</a>
                    <li><a href="#">Muskler</a>
                    <li><a href="#">Handicap</a>
                    <li><a href="#">Små børn</a>
                </ul>
            </li>
            <li><a href="#">Gennemførte quizzer</a></li>
            <li><a href="#">Leaderboards</a></li>
        </ul>                
    </div>
</section>

<section class="quizContent">
    <div class="row">
        <div class="col-xs-4">
            <div class="singleQuiz">                
                <img src="<?php echo base_url(); ?>/images/hands.jpg">
                <input type=button class="button button--primary" value="Level 10">
                <input type=button class="button" value="Muskler">
                <article>
                    <h1>Korrekt håndtering af ældre</h1> 
                </article>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="singleQuiz">                
                <img src="<?php echo base_url(); ?>/images/hands.jpg">
                <input type=button class="button button--primary" value="Level 10">
                <input type=button class="button" value="Muskler">
                <article>
                    <h1>Korrekt håndtering af ældre</h1> 
                </article>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="singleQuiz">                
                <img src="<?php echo base_url(); ?>/images/hands.jpg">
                <input type=button class="button button--primary" value="Level 10">
                <input type=button class="button" value="Muskler">
                <article>
                    <h1>Korrekt håndtering af ældre</h1> 
                </article>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="singleQuiz">                
                <img src="<?php echo base_url(); ?>/images/hands.jpg">
                <input type=button class="button button--primary" value="Level 10">
                <input type=button class="button" value="Muskler">
                <article>
                    <h1>Korrekt håndtering af ældre</h1> 
                </article>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="singleQuiz">                
                <img src="<?php echo base_url(); ?>/images/hands.jpg">
                <input type=button class="button button--primary" value="Level 10">
                <input type=button class="button" value="Muskler">
                <article>
                    <h1>Korrekt håndtering af ældre</h1> 
                </article>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="singleQuiz">                
                <img src="<?php echo base_url(); ?>/images/hands.jpg">
                <input type=button class="button button--primary" value="Level 10">
                <input type=button class="button" value="Muskler">
                <article>
                    <h1>Korrekt håndtering af ældre</h1> 
                </article>
            </div>
        </div>
    </div> 
</section>

<script type="text/javascript">
    function openTab(evt, tabName) {

    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
    }

    tablinks = document.getElementsByClassName("viewModeButton");
    for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
    }
    document.getElementById("tabopen").click();
</script>
