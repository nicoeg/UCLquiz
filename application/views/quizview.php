<div class="quizview-container">
    <div class="row-center-xs">
        <div class="center">
            <div class="tab">
                <button class="tablinks" onclick="openTab(event, 'All')" id="tabopen">Alle</button>
                <button class="tablinks" onclick="openTab(event, 'New')">Nye</button>
                <button class="tablinks" onclick="openTab(event, 'Done')">Færdige</button>
            </div>
            <div id="All" class="tabcontent">
                <table class="quizview-table">
                    <tr>
                        <th>
                            <p>Quiz</p>
                        </th>
                        <th>
                            <p>Fag</p>
                        </th>
                        <th>
                            <p>Udgivet af</p>
                        </th>
                        <th>
                            Niveau
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <p>Data</p>
                        </td>
                        <td>
                            <p>Data</p>
                        </td>
                        <td>
                            <p>Data</p>
                        </td>
                        <td>
                            <p>Data</p>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="New" class="tabcontent">
                Nye
            </div>
            <div id="Done" class="tabcontent">
                Færdig
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    function openTab(evt, tabName) {
    
    var i, tabcontent, tablinks;
    
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
    
}
document.getElementById("tabopen").click();
</script>