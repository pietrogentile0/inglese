<?php
    if(isset($_GET["fun"])){
        //confiugure connection
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $db_name = "english_study_case";

        $conn = new mysqli($hostname, $username, $password, $db_name);
        
        if($conn->connect_error){
            die("Connectioon failed: " . $conn->connect_error);
        }
        
        if($_GET["fun"] == 'table' and isset($_GET["group"])){               
            $group = $_GET["group"];
            $queryExtract = "";
            if($group == 1){
                $querySetPresentgroup = "UPDATE people SET present = 1 WHERE group_num = 1";
                $querySetAbsentgroup = "UPDATE people SET present = 0 WHERE group_num = 2";
                $conn->query($querySetPresentgroup);
                $conn->query($querySetAbsentgroup);

                $queryExtract = "SELECT name, surname, id from people WHERE group_num = 1";
            }
            elseif($group == 2){
                $querySetPresentgroup = "UPDATE people SET present = 1 WHERE group_num = 2";
                $querySetAbsentgroup = "UPDATE people SET present = 0 WHERE group_num = 1";
                $conn->query($querySetPresentgroup);
                $conn->query($querySetAbsentgroup);

                $queryExtract = "SELECT name, surname, id from people WHERE group_num = 2";
            }
            elseif($group == 3){    
                $querySetAllPresent = "UPDATE people SET present = 1";   //mette tutti presenti
                $conn->query($querySetAllPresent);

                $queryExtract = "SELECT name, surname, id from people";
            }

            $result = $conn->query($queryExtract);
            if($result !== false && $result->num_rows > 0){
                echo("<form>");
                    echo("<h4>Select absents or people you want to exclude</h4>");
                    echo("<table class='listScreen'>");
                        echo("<tr>");
                            echo("<th style='width: 30px;'>Id</th>");
                            echo("<th style='width: 40px;'>Abs</th>");
                            echo("<th style='width: 40px;'>Exc</th>");
                            echo("<th style='text-align: left; padding-left: 15px;'>Students</th>");
                        echo("</tr>");
                    while($row = $result->fetch_assoc()){
                        echo("<tr id=".$row['id'].">");
                            echo("<td>".$row["id"]."</td>");
                            echo("<td><input type='checkbox' name='absents[]' value= ".$row["id"]."></td>");
                            echo("<td><input type='checkbox' name='exclude[]' value= ".$row["id"]."></td>");
                            echo("<td style='text-align: left; padding-left: 15px;'>".$row["name"]."</th>");
                            echo("<td style='text-align: left; padding-left: 15px;'>".$row["surname"]."</th>");
                        echo("</tr>");
                    }
                    echo("</table>");
                    //echo("<input type='button' id='absentButton' value='Update list'><br/>"); //onclick va
                echo("</form>");
            }
        }
        else if($_GET["fun"] == 'absents'){
            $absents = json_decode($_GET['absents']);

            foreach($absents as $absents){
                $querySetAbsent = "UPDATE people SET present = 0 WHERE id = ".$absents."";
                $conn->query($querySetAbsent);
            }
        }    
    }
?>
<?php
    // $hostname = "localhost";
    // $username = "root";
    // $password = "";
    // $db_name = "english_study_case";

    // $conn = new mysqli($hostname, $username, $password, $db_name);
    
    // if($conn->connect_error){
    //     die("Connectioon failed: " . $conn->connect_error);
    // }
    
    // $queryExtract = "SELECT * from people";

    // $result = $conn->query($queryExtract);
    // if($result !== false && $result->num_rows > 0){
    //     echo("<table>");
    //         echo("<tr>Risultati </tr>");
    //         while($row = $result->fetch_assoc()){
    //             echo("<tr>");
    //             echo($row["nome"]);
    //             echo("</tr><br />");
    //         }
    //     echo("</table>");
    // }
    
    // $database = array();
    // echo($result->fetch_assoc());
    // while($row = $result->fetch_assoc()){
    //     echo("a");
    //     $database[] = $row["nome"];
    // }
    // $jsonDB = json_encode($database);
    
    // $MODE = $_GET["mode"];
    // $GRUPPO = $_GET["group"];
    
    // if($MODE === '1'){ //copia tutto
    //     echo("fatto");
    //     $queryCopy = "INSERT INTO temp SELECT * FROM people";
    //     $conn->query($queryCopy);
    // }else if($MODE === '2'){   //copia solo il gruppo che viene scelto (a scuola)
    //     $queryCopy = "INSERT INTO english_study_case.temp SELECT * FROM english_study_case.people WHERE gruppo = '" . $GRUPPO . "' ";
    // }

    /*$querySelect = "SELECT id FROM people WHERE name = '" . $key . "' ";
    //$queryUpdate = "UPDATE people SET name = 'giorgio' WHERE name = 'pietro'";

    // if ($conn->query($queryUpdate) === TRUE) {
    //     echo "Record updated successfully";
    //   } else {
    //     echo "Error updating record: " . $conn->error;
    //   }

    $result = $conn->query($querySelect);

    if($result !== false && $result->num_rows > 0){
        echo("<table>");
            echo("<tr>Risultati </tr>");
            while($row = $result->fetch_assoc()){
                echo("<tr>");
                echo($row["id"]);
                echo("</tr>");
            }
        echo("</table>");
    }*/
?>