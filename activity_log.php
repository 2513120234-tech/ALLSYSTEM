<?php
function logActivity($condb, $user_id, $role, $action) {

    $stmt = $condb->prepare("
        INSERT INTO USER_LOGS (user_id, role, action)
        VALUES (:user_id, :role, :action)
    ");

    $stmt->execute([
        ':user_id' => $user_id,
        ':role'    => $role,
        ':action'  => $action
    ]);
}
