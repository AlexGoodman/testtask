<?php
/**
 * Created by PhpStorm.
 * User: Alexandr
 * Date: 21.06.2015
 * Time: 20:32
 */
require_once 'db.php';
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $db = new MyDb;
    /*if (
        isset($_SERVER['HTTP_X_REQUESTED_WITH'])
        && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
    ) {
        if (array_key_exists('action', $_POST)) {
            switch ($_POST['action']) {
                case 'save':
                    $db->saveNote($_POST);
                    break;
                case 'delete':
                    $db->deleteNote($_POST['id']);
                    break;
            }
        }
    }*/

    echo json_encode('Tru-la0la');
}
