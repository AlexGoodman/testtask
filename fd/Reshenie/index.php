<?php
/**
 * Created by PhpStorm.
 * User: Alexandr
 * Date: 20.06.2015
 * Time: 16:51
 */

    require_once 'php/db.php';
    $db = new MyDb;
    $vId = '';
    $vText = '';
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $db->saveNote($_POST);
        header('Location: '.$_SERVER['PHP_SELF']);
    }

    if(array_key_exists('action', $_GET)){
        switch($_GET['action']){
            case 'edit':
                $result = $db ->getNotes($_GET['id']) -> fetch();
                $vText = $result['text'];
                $vId = 'value="'.$_GET['id'].'"';
                break;
            case 'delete':
                $result = $db ->deleteNote($_GET['id']);
                header('Location: '.$_SERVER['PHP_SELF']);
                break;
        }
    }
    $notes = $db ->getNotes();
?>
<html>
    <head>
        <title>Test task</title>
        <link type="text/css" rel="stylesheet" href="css/bootstrap.css"/>
        <link type="text/css" rel="stylesheet" href="css/style.css"/>
        <script src="js/jquery.js"></script>
        <script src="js/init.js"></script>
    </head>
    <body>
        <div class="content">
            <h1>Test page</h1>

            <label class="checkbox-inline hidden" id="js-checkbox">
                <input type="checkbox" name="pageReload" id="page-reload">
                Without page reloading
            </label>

            <form method="post" action="<?=$_SERVER['PHP_SELF']?>" id="test-form">
                <textarea name="text" class="form-control m-top" rows="3" id="text" required="required" placeholder="Write something :)"><?=$vText;?></textarea>
                <input <?=$vId;?> name="id" class="hidden" type="text" id="pKey"/>
                <button type="submit" class="btn btn-success m-top" id="save-button">
                    Add / Edit
                </button>
            </form>

            <h3>Notes:</h3>
            <div id="notes">
                <?php foreach($notes as $v):?>
                    <div class="row m-top">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 note-text" data-id="<?=$v['id']?>">
                            <?=$v['text']?>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="text-align: right">
                            <a href="<?=$_SERVER['PHP_SELF'].'?action=edit&id='.$v['id']?>" class="btn btn-primary edit-button" data-id="<?=$v['id']?>">Edit</a>
                            <a href="<?=$_SERVER['PHP_SELF'].'?action=delete&id='.$v['id']?>" class="btn btn-danger delete-button" data-id="<?=$v['id']?>">Delete</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <script>
            $('#js-checkbox').removeClass('hidden');
            saveNote();
            editNote();
            deleteNote();
        </script>
    </body>
</html>