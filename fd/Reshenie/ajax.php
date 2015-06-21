<?php
/**
 * Created by PhpStorm.
 * User: Alexandr
 * Date: 21.06.2015
 * Time: 20:32
 */
if($_SERVER['REQUEST_METHOD'] == 'POST'
    && isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
) {
    require_once 'php/db.php';
    $db = new MyDb;
    if (array_key_exists('action', $_POST)) {
        switch ($_POST['action']) {
            case 'save':
                $db->saveNote($_POST);
                if(array_key_exists('id', $_POST) && !$_POST['id']) {
                    $result = $db->getNotes() ->fetchAll();
                    echo json_encode($result);
                } else{
                    echo json_encode('OK');
                }
                break;
            case 'delete':
                $db->deleteNote($_POST['id']);
                break;
        }
    }
}
