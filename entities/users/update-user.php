<?php

function updateUser($id, $body)
{
    require_once __DIR__ . "/../../database/connection.php";
    $databaseConnection = getDatabaseConnection();

    // Ensure $body is an array; if not, convert to empty array
    $body = is_array($body) ? $body : [];

    if (count($body) === 0) {
        return true; // Nothing to update
    }

    $authorizedColumns = ["name", "surname", "phone_number", "address"];
    $set = [];
    $data = [];

    foreach ($body as $column => $value) {
        if (in_array($column, $authorizedColumns)) {
            $set[] = "$column = :$column";
            $data[$column] = htmlspecialchars($value);
        }
    }

    if (empty($set)) {
        return false; // No valid columns to update
    }

    $setString = implode(', ', $set);
    $updateUserQuery = $databaseConnection->prepare("UPDATE users SET $setString WHERE id = :id");
    $data['id'] = $id;

    return $updateUserQuery->execute($data);
}
