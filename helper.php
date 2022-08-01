<?php
function save_sesion($conn)
{
    $session = $_SESSION;
    $sesionId = session_id();

    $sessionQuery = $conn->prepare("Select * from sessions where session_id  = ? LIMIT 1;");
    $sessionQuery->execute(array($sesionId));

    $savedSession = $sessionQuery->fetch();
    #create session
    if (empty($savedSession)) {
        $query = $conn->prepare("INSERT INTO sessions SET
        session_id  = ?,
        session_val  = ?");

        $insert = $query->execute(array($sesionId,json_encode($session)));
    } else {
        #update session
        $query = $conn->prepare("UPDATE sessions SET
        session_val  = ? WHERE session_id = ?");
        $insert = $query->execute(array(json_encode($session),$sesionId));
    }
}
