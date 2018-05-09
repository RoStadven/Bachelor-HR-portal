<?php
function overviewAll()
{
    global $db;

    if (!$db) {
        die("Feil i databasetilkobling:" . $db->connect_error);
    }
    //$userId = $_SESSION;
    $qry = "SELECT DISTINCT Newemployee.firstname, Newemployee.lastname, Newemployee.idNewemployee FROM Newemployee INNER JOIN Users_has_Newemployee ON Newemployee.idNewemployee = Users_has_Newemployee.Newemployee_idNewemployee";
    $res = mysqli_query($db, $qry);
    if (!$res) {
        echo '<script type="text/javascript">alert("Query failed");</script>';
    }


    while ($row = mysqli_fetch_assoc($res)) {
        $id_new = $row['idNewemployee'];
        $f_name = $row['firstname'];
        $l_name = $row['lastname'];


        $article = ' <article class="h-card vcard person-card article-contact" role="article"><h3 title="Oversikt over sjekklister"  class="toggler-header article-contact-heading"> ';
        $article .= $f_name . " " . $l_name . " ";
        $article .= '</h3><div class="toggler-content"><form action="" method="post"><table><tr><th>Oppgave</th><th>Sjekkboks</th></tr>';
        $qry2 = "SELECT Newemployee_idNewemployee, Checklist_idChecklist, checked FROM Newemployee_has_Checklist INNER JOIN Checklist ON idChecklist WHERE Checklist_idChecklist = idChecklist AND Newemployee_idNewemployee='$id_new'";
        $res2 = mysqli_query($db, $qry2);

        if (!$res2) {
            echo '<script type="text/javascript">alert("Tom resultat");</script>';
            die();
        }
        while ($row2 = mysqli_fetch_assoc($res2)) {
            $check_id = $row2['Checklist_idChecklist'];
            $checked = $row2['checked'];
            $emp_id = $row2['Newemployee_idNewemployee'];

            $qry3 = "SELECT checkpointsNO, idChecklist from Checklist WHERE idChecklist ='$check_id'";
            $res3 = mysqli_query($db, $qry3);
            $res4 = mysqli_fetch_assoc($res3);

            $article .= '
                                             <tr>
                                             <td>';
            $article .= " " . $res4['checkpointsNO'] . " ";
            $id_check = $res4['idChecklist'];
            $article .= '</td>';
            $article .= '<td height="30px" >';
            if ($checked == 0) {
                $article .= '<input type="checkbox" class="checkbox" name="';
                $article .= $emp_id;
                $article .= '" value="';
                $article .= $checked;
                $article .= '" id="';
                $article .= $check_id;
                $article .= '" onclick="return false;" onkeydown="e = e || window.event; if(e.keyCode !== 9) return false;"/>';

            } else {
                $article .= '<input type="checkbox" class="checkbox" name="empty" checked   onclick="return false;" onkeydown="e = e || window.event; if(e.keyCode !== 9) return false;"';

                $article .= $checked;

                $article .= '">';

            }

            $article .= '</td>
                                            </tr>';

        }
        //$article.='<button type="submit">Submit</button>';
        $article .= '</table></form></div></article>';
        echo $article;

    }
}
function overviewAllENG()
{
    global $db;

    if (!$db) {
        die("Feil i databasetilkobling:" . $db->connect_error);
    }
    //$userId = $_SESSION;
    $qry = "SELECT DISTINCT Newemployee.firstname, Newemployee.lastname, Newemployee.idNewemployee FROM Newemployee INNER JOIN Users_has_Newemployee ON Newemployee.idNewemployee = Users_has_Newemployee.Newemployee_idNewemployee";
    $res = mysqli_query($db, $qry);
    if (!$res) {
        echo '<script type="text/javascript">alert("Query failed");</script>';
    }


    while ($row = mysqli_fetch_assoc($res)) {
        $id_new = $row['idNewemployee'];
        $f_name = $row['firstname'];
        $l_name = $row['lastname'];


        $article = ' <article class="h-card vcard person-card article-contact" role="article"><h3 title="Overview over checklists"  class="toggler-header article-contact-heading"> ';
        $article .= $f_name . " " . $l_name . " ";
        $article .= '</h3><div class="toggler-content"><form action="" method="post"><table><tr><th>Tasks</th><th>Checkbox</th></tr>';
        $qry2 = "SELECT Newemployee_idNewemployee, Checklist_idChecklist, checked FROM Newemployee_has_Checklist INNER JOIN Checklist ON idChecklist WHERE Checklist_idChecklist = idChecklist AND Newemployee_idNewemployee='$id_new'";
        $res2 = mysqli_query($db, $qry2);

        if (!$res2) {
            echo '<script type="text/javascript">alert("Empty result");</script>';
            die();
        }
        while ($row2 = mysqli_fetch_assoc($res2)) {
            $check_id = $row2['Checklist_idChecklist'];
            $checked = $row2['checked'];
            $emp_id = $row2['Newemployee_idNewemployee'];

            $qry3 = "SELECT checkpointsEN, idChecklist from Checklist WHERE idChecklist ='$check_id'";
            $res3 = mysqli_query($db, $qry3);
            $res4 = mysqli_fetch_assoc($res3);

            $article .= '
                                             <tr>
                                             <td>';
            $article .= " " . $res4['checkpointsEN'] . " ";

            $article .= '</td>';
            $article .= '<td height="30px" >';
            if ($checked == 0) {
                $article .= '<input type="checkbox" class="checkbox" name="';
                $article .= $emp_id;
                $article .= '" value="';
                $article .= $checked;
                $article .= '" id="';
                $article .= $check_id;
                $article .= '" onclick="return false;" onkeydown="e = e || window.event; if(e.keyCode !== 9) return false;"/>';

            } else {
                $article .= '<input type="checkbox" class="checkbox" name="empty" checked   onclick="return false;" onkeydown="e = e || window.event; if(e.keyCode !== 9) return false;"';

                $article .= $checked;

                $article .= '">';

            }

            $article .= '</td>
                                            </tr>';

        }
        //$article.='<button type="submit">Submit</button>';
        $article .= '</table></form></div></article>';
        echo $article;

    }
}

function employeeSelect()
{
    global  $db;
    $query = mysqli_query($db, "SELECT idNewemployee, firstname, lastname FROM Newemployee") or die(mysqli_error());
    echo "<select name=\"empname\" class=\"field comment-alerts\">";
    echo '<option value=""></option>';

    while ($row = $query->fetch_assoc()){

        unset($f_name, $l_name);
        $employee_id = $row['idNewemployee'];
        $f_name = $row['firstname'];
        $l_name = $row['lastname'];

        echo  '<option value="'.$employee_id.'">'.$f_name.' '.$l_name.'</option>';
    }
    echo  "</select>";
}

function mentorSelect()
{
    global $db;
    $query = mysqli_query($db, "SELECT idUsers, firstname, lastname FROM Users where usertype= 'mentor'") or die(mysqli_error());
    echo "<select name=\"mentorSelect\" class=\"field comment-alerts\">";
    echo '<option value=""></option>';

    while ($row = $query->fetch_assoc()) {

        unset($f_name, $l_name);
        $user_id = $row['idUsers'];
        $f_name = $row['firstname'];
        $l_name = $row['lastname'];

        echo '<option value="'.$user_id.'">'.$f_name.' '.$l_name.'</option>';

    }
}

function leaderSelect()
{
    global $db;
    $query = mysqli_query($db, "SELECT idUsers, firstname, lastname FROM Users where usertype= 'leader'") or die(mysqli_error());
    echo "<select name=\"leaderSelect\" class=\"field comment-alerts\">";
    echo '<option value=""></option>';

    while ($row = $query->fetch_assoc()) {

        unset($f_name, $l_name);
        $user_id = $row['idUsers'];
        $f_name = $row['firstname'];
        $l_name = $row['lastname'];

        echo '<option value="'.$user_id.'">'.$f_name.' '.$l_name.'</option>';

    }
}

function hrSelect()
{
    global $db;
    $query = mysqli_query($db, "SELECT idUsers, firstname, lastname FROM Users where usertype= 'HR'") or die(mysqli_error());
    echo "<select name=\"hrSelect\" class=\"field comment-alerts\">";
    echo '<option value=""></option>';

    while ($row = $query->fetch_assoc()) {

        unset($f_name, $l_name);
        $user_id = $row['idUsers'];
        $f_name = $row['firstname'];
        $l_name = $row['lastname'];

        echo '<option value="'.$user_id.'">'.$f_name.' '.$l_name.'</option>';

    }
}

function addMentor()
{
    global $db, $username, $errors;
    $employee = e($_POST['empname']);
    $mentor = e($_POST['mentorSelect']);
    $sql = "SELECT idNewemployee, firstname, lastname FROM Newemployee WHERE idNewemployee = '$employee'";
    $result = $db->query($sql);
    $user = mysqli_fetch_assoc($result);
    if (!$user) {
        echo '<script type="text/javascript">alert("Not a user");</script>';
        echo $sql;
        array_push($errors, "Not a user");
    } else {
        $sql2 = "SELECT idNewemployee FROM Newemployee WHERE idNewemployee = '$employee'";
        $sql3 = "SELECT idUsers FROM Users WHERE idUsers = '$mentor'";
        $resultId = $db->query($sql2);

        if (!$resultId) {
            echo '<script type="text/javascript">alert("Wrong id");</script>';

        } else {
            while ($row = mysqli_fetch_assoc($resultId)) {
                $resultId2 = $db->query($sql3);
                $idNewemployee = $row['idNewemployee'];
                $sql4 = "Select Newemployee_idNewemployee FROM Users_has_Newemployee WHERE Newemployee_idNewemployee = '$idNewemployee' ";
                $testresult = $db->query($sql4);
                if (!$resultId2) {
                    echo '<script type="text/javascript">alert("User and id dont match");</script>';
                } else {
                    while ($row = mysqli_fetch_assoc($resultId2)) {
                        $idUsers = $row['idUsers'];

                        $query = "INSERT INTO Users_has_Newemployee (Users_idUsers, Newemployee_idNewemployee)
                                VALUES ('$idUsers', '$idNewemployee') ";
                        $res = mysqli_query($db, $query);
                        if (!$res) {

                        } elseif ($db->affected_rows == 0) {
                            echo '<script type="text/javascript">alert("Something failed");</script>';
                        } else {
                            echo '<script type="text/javascript">alert("Mentor assigned");</script>';
                        }
                    }
                }
            }
        }
    }
}

function addLeader()
{
    global $db, $username, $errors;
    $employee = e($_POST['empname']);
    $leader = e($_POST['leaderSelect']);
    $sql = "SELECT idNewemployee, firstname, lastname FROM Newemployee WHERE idNewemployee = '$employee'";
    $result = $db->query($sql);
    $user = mysqli_fetch_assoc($result);
    if (!$user) {
        echo '<script type="text/javascript">alert("Not a user");</script>';
        echo $sql;
        array_push($errors, "Not a user");
    } else {
        $sql2 = "SELECT idNewemployee FROM Newemployee WHERE idNewemployee = '$employee'";
        $sql3 = "SELECT idUsers FROM Users WHERE idUsers = '$leader'";
        $resultId = $db->query($sql2);

        if (!$resultId) {
            echo '<script type="text/javascript">alert("Wrong id");</script>';

        } else {
            while ($row = mysqli_fetch_assoc($resultId)) {
                $resultId2 = $db->query($sql3);
                $idNewemployee = $row['idNewemployee'];
                $sql4 = "Select Newemployee_idNewemployee FROM Users_has_Newemployee WHERE Newemployee_idNewemployee = '$idNewemployee' ";
                $testresult = $db->query($sql4);
                if (!$resultId2) {
                    echo '<script type="text/javascript">alert("User and id dont match");</script>';
                } else {
                    while ($row = mysqli_fetch_assoc($resultId2)) {
                        $idUsers = $row['idUsers'];

                        $query = "INSERT INTO Users_has_Newemployee (Users_idUsers, Newemployee_idNewemployee)
                                VALUES ('$idUsers', '$idNewemployee') ";
                        $res = mysqli_query($db, $query);
                        if (!$res) {

                        } elseif ($db->affected_rows == 0) {
                            echo '<script type="text/javascript">alert("Something failed");</script>';
                        } else {
                            echo '<script type="text/javascript">alert("Leader assigned");</script>';
                        }
                    }
                }
            }
        }
    }
}

function updateMentor()
{
    global $db, $errors;
    $employee = e($_POST['empname']);
    $mentor = e($_POST['mentorSelect']);
    $user_check = "SELECT firstname, lastname FROM Users WHERE idUsers = $mentor ";
    $result = $db->query($user_check);
    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        echo '<script type="text/javascript">alert("Not a user");</script>';
        echo $user_check;
        array_push($errors, "Not a user");
    } else {
        $id = "SELECT idNewemployee FROM Newemployee WHERE idNewemployee = '$employee'";
        $id2 = "SELECT idUsers FROM Users WHERE idUsers = '$mentor' ";
        $resultid = $db->query($id);

        if (!$resultid) {
            echo '<script type="text/javascript">alert("Wrong id");</script>';
        } else {
            while ($row = mysqli_fetch_assoc($resultid)) {
                $resultid2 = $db->query($id2);
                $id4 = $row['idNewemployee'];

                if (!$resultid2) {
                    echo '<script type="text/javascript">alert("User and id dont match");</script>';
                } else {
                    while ($row = mysqli_fetch_assoc($resultid2)) {
                        $id3 = $row['idUsers'];
                        $querya = "SELECT Users_idUsers FROM Users_has_Newemployee WHERE Newemployee_idNewemployee = '$id4'";
                        $resulta = $db->query($querya);
                        if (!$resulta) {
                            echo "something";
                        } else {
                            while ($row2 = mysqli_fetch_assoc($resulta)) {
                                $haha = $row2['Users_idUsers'];
                                if ($haha == $id3) {
                                    echo '<script type="text/javascript">alert("same mentor error");</script>';
                                }
                                else {
                                    $query = "UPDATE Users_has_Newemployee SET Users_idUsers= '$id3' WHERE Newemployee_idNewemployee='$id4'";
                                    $result = $db->query($query);

                                    if ($result === TRUE) {

                                        echo '<script type="text/javascript">alert("Mentor edit worked");</script>';

                                    } else {
                                        echo '<script type="text/javascript">alert("Something wrong happend");</script>';

                                    }
                                }

                            }

                        }
                    }

                }
            }
        }

    }
}

function updateLeader()
{
    global $db, $errors;
    $employee = e($_POST['empname']);
    $leader = e($_POST['leaderSelect']);
    $user_check = "SELECT firstname, lastname FROM Users WHERE idUsers = $leader ";
    $result = $db->query($user_check);
    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        echo '<script type="text/javascript">alert("Not a user");</script>';
        echo $user_check;
        array_push($errors, "Not a user");
    } else {
        $id = "SELECT idNewemployee FROM Newemployee WHERE idNewemployee = '$employee'";
        $id2 = "SELECT idUsers FROM Users WHERE idUsers = '$leader' ";
        $resultid = $db->query($id);

        if (!$resultid) {
            echo '<script type="text/javascript">alert("Wrong id");</script>';
        } else {
            while ($row = mysqli_fetch_assoc($resultid)) {
                $resultid2 = $db->query($id2);
                $id4 = $row['idNewemployee'];

                if (!$resultid2) {
                    echo '<script type="text/javascript">alert("User and id dont match");</script>';
                } else {
                    while ($row = mysqli_fetch_assoc($resultid2)) {
                        $id3 = $row['idUsers'];
                        $querya = "SELECT Users_idUsers FROM Users_has_Newemployee WHERE Newemployee_idNewemployee = '$id4'";
                        $resulta = $db->query($querya);
                        if (!$resulta) {
                            echo "something";
                        } else {
                            while ($row2 = mysqli_fetch_assoc($resulta)) {
                                $Userid = $row2['Users_idUsers'];
                                if ($Userid == $id3) {
                                    echo '<script type="text/javascript">alert("same leader error");</script>';
                                }
                                else {
                                    $query = "UPDATE Users_has_Newemployee SET Users_idUsers= '$id3' WHERE Newemployee_idNewemployee='$id4'";
                                    $result = $db->query($query);

                                    if ($result === TRUE) {

                                        echo '<script type="text/javascript">alert("Leader edit worked");</script>';

                                    } else {
                                        echo '<script type="text/javascript">alert("Something wrong happened");</script>';

                                    }
                                }

                            }

                        }
                    }

                }
            }
        }

    }
}

function addHr()
{
    global $db, $username, $errors;
    $employee = e($_POST['empname']);
    $hr = e($_POST['hrSelect']);
    $sql = "SELECT idNewemployee, firstname, lastname FROM Newemployee WHERE idNewemployee = '$employee'";
    $result = $db->query($sql);
    $user = mysqli_fetch_assoc($result);
    if (!$user) {
        echo '<script type="text/javascript">alert("Not a user");</script>';
        echo $sql;
        array_push($errors, "Not a user");
    } else {
        $sql2 = "SELECT idNewemployee FROM Newemployee WHERE idNewemployee = '$employee'";
        $sql3 = "SELECT idUsers FROM Users WHERE idUsers = '$hr'";
        $resultId = $db->query($sql2);

        if (!$resultId) {
            echo '<script type="text/javascript">alert("Wrong id");</script>';

        } else {
            while ($row = mysqli_fetch_assoc($resultId)) {
                $resultId2 = $db->query($sql3);
                $idNewemployee = $row['idNewemployee'];
                $sql4 = "Select Newemployee_idNewemployee FROM Users_has_Newemployee WHERE Newemployee_idNewemployee = '$idNewemployee' ";
                $testresult = $db->query($sql4);
                if (!$resultId2) {
                    echo '<script type="text/javascript">alert("User and id dont match");</script>';
                } else {
                    while ($row = mysqli_fetch_assoc($resultId2)) {
                        $idUsers = $row['idUsers'];

                        $query = "INSERT INTO Users_has_Newemployee (Users_idUsers, Newemployee_idNewemployee)
                                VALUES ('$idUsers', '$idNewemployee') ";
                        $res = mysqli_query($db, $query);
                        if (!$res) {

                        } elseif ($db->affected_rows == 0) {
                            echo '<script type="text/javascript">alert("Something failed");</script>';
                        } else {
                            echo '<script type="text/javascript">alert("HR-employee assigned");</script>';
                        }
                    }
                }
            }
        }
    }
}

function updateHr()
{
    global $db, $errors;
    $employee = e($_POST['empname']);
    $leader = e($_POST['leaderSelect']);
    $user_check = "SELECT firstname, lastname FROM Users WHERE idUsers = $leader ";
    $result = $db->query($user_check);
    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        echo '<script type="text/javascript">alert("Not a user");</script>';
        echo $user_check;
        array_push($errors, "Not a user");
    } else {
        $id = "SELECT idNewemployee FROM Newemployee WHERE idNewemployee = '$employee'";
        $id2 = "SELECT idUsers FROM Users WHERE idUsers = '$leader' ";
        $resultid = $db->query($id);

        if (!$resultid) {
            echo '<script type="text/javascript">alert("Wrong id");</script>';
        } else {
            while ($row = mysqli_fetch_assoc($resultid)) {
                $resultid2 = $db->query($id2);
                $id4 = $row['idNewemployee'];

                if (!$resultid2) {
                    echo '<script type="text/javascript">alert("User and id dont match");</script>';
                } else {
                    while ($row = mysqli_fetch_assoc($resultid2)) {
                        $id3 = $row['idUsers'];
                        $querya = "SELECT Users_idUsers FROM Users_has_Newemployee WHERE Newemployee_idNewemployee = '$id4'";
                        $resulta = $db->query($querya);
                        if (!$resulta) {
                            echo "something";
                        } else {
                            while ($row2 = mysqli_fetch_assoc($resulta)) {
                                $haha = $row2['Users_idUsers'];
                                if ($haha == $id3) {
                                    echo '<script type="text/javascript">alert("same leader error");</script>';
                                }
                                else {
                                    $query = "UPDATE Users_has_Newemployee SET Users_idUsers= '$id3' WHERE Newemployee_idNewemployee='$id4'";
                                    $result = $db->query($query);

                                    if ($result === TRUE) {

                                        echo '<script type="text/javascript">alert("Leader edit worked");</script>';

                                    } else {
                                        echo '<script type="text/javascript">alert("Something wrong happened");</script>';

                                    }
                                }

                            }

                        }
                    }

                }
            }
        }

    }
}

if (isset($_POST['assignMentor'])) {
    addMentor();
}

if (isset($_POST['assignLeader'])) {
    addLeader();
}

if (isset($_POST['assignHr'])) {
    addHr();
}

if (isset($_POST['updateMentor'])) {
    updateMentor();
}

if (isset($_POST['updateLeader'])) {
    updateLeader();
}

if (isset($_POST['updateHr'])) {
    updateHr();
}