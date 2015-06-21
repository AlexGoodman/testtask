<?php
/**
 * Created by PhpStorm.
 * User: Alexandr
 * Date: 29.05.2015
 * Time: 0:04
 */

// MySQL Task

    $dbh = new PDO('mysql:host=localhost;dbname=intend', 'root', '');

    $result = $dbh->query('
      SELECT article.data as aData, GROUP_CONCAT(tag.data SEPARATOR ", ") AS tData
      FROM article_has_tag
      JOIN article ON article.id = article_has_tag.article_id
      JOIN tag ON tag.id = article_has_tag.tag_id
      GROUP BY  article.data
      LIMIT 20
    ', PDO::FETCH_ASSOC);

    foreach($result as $row) {
        echo '<br><br>';
        print_r($row);
    }

?>


