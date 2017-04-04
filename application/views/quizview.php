<script>
    var jsonTest = {
    "firstName": "John",
            "lastName": "Smith",
            "age": 25,
            "address": {
            "streetAddress": "21 2nd Street",
                    "city": "New York",
                    "state": "NY",
                    "postalCode": "10021"
            },
            "phoneNumber": [
            {
            "type": "home",
                    "number": "212 555-1234"
            },
            {
            "type": "fax",
                    "number": "646 555-4567"
            }
            ],
            "gender": {
            "type": "male"
            }
    } 
</script>
<div class="quizview-container">
    <div class="row-center-xs">
        <div class="center">
            <div class="tab">
                <button class="tablinks" onclick="openTab(event, 'All')" id="tabopen">Alle</button>
                <button class="tablinks" onclick="openTab(event, 'New')">Nye</button>
                <button class="tablinks" onclick="openTab(event, 'Done')">Færdige</button>
            </div>
             <?php
                $conn = mysqli_connect('localhost', 'root', '', 'ucl');
                $query = 'SELECT * FROM ((quizzes
INNER JOIN courses ON quizzes.cID = courses.id)
INNER JOIN users ON quizzes.uID = users.id);';
                $data = mysqli_query($conn, $query);
                $savedDataQuiz = mysqli_fetch_all($data, MYSQLI_ASSOC);
                mysqli_close($conn);
                ?>
            <div id="All" class="tabcontent">               
                <table class="quizview-table" id="quizTable">
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
                    <?php
                    foreach ($savedDataQuiz as $i => $quizData) {
                        ?>
                        <tr>
                            <td>
                                <p id="title"><?php echo $quizData['title'] ?></p>
                            </td>
                            <td>
                                <p id="course"><?php echo $quizData['name'] ?></p>
                            </td>
                            <td>
                                <p id="publisher"><?php echo $quizData['username'] ?></p></p>
                            </td>
                            <td>
                                <p id="level"><?php echo $quizData['level'] ?></p>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </table>
            </div>
            <div id="New" class="tabcontent">
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
                    <?php
                    foreach ($savedDataQuiz as $i => $quizData) {
                        ?>
                        <tr>
                            <td>
                                <p id="title"><?php echo $quizData['title'] ?></p>
                            </td>
                            <td>
                                <p id="course"><?php echo $quizData['name'] ?></p>
                            </td>
                            <td>
                                <p id="publisher"><?php echo $quizData['username'] ?></p></p>
                            </td>
                            <td>
                                <p id="level"><?php echo $quizData['level'] ?></p>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </table>
            
            </div>
            <div id="Done" class="tabcontent">
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
                    <?php
                    foreach ($savedDataQuiz as $i => $quizData) {
                        ?>
                        <tr>
                            <td>
                                <p id="title"><?php echo $quizData['title'] ?></p>
                            </td>
                            <td>
                                <p id="course"><?php echo $quizData['name'] ?></p>
                            </td>
                            <td>
                                <p id="publisher"><?php echo $quizData['username'] ?></p></p>
                            </td>
                            <td>
                                <p id="level"><?php echo $quizData['level'] ?></p>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </table>
            
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
