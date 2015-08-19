<html>
    <head>
        <title>MYSql</title>
        <style>
            thead{
                font-weight: bold;
                font-size: 20px;
            }

            td{
                padding: 10px;
                border: 2px solid #000000;
                text-align: center;
            }
        </style>
    </head>
    <body>

<?php
/**
 * Created by PhpStorm.
 * User: Alexandr
 * Date: 18.08.2015
 * Time: 20:59
 */

$dbh = new PDO('mysql:host=localhost;dbname=expressdiya', 'root', '');

$result = $dbh->query('
      SELECT
        categories.name as cName,
        P.productCount,
        P.minPrice,
        P.maxPrice,
        products.name,
        P.lengthMaxDescription,
        products.description
      FROM categories
      INNER JOIN products ON products.category_id = categories.id
      INNER JOIN
      (SELECT
        COUNT(*) as productCount,
        MIN(products.price) as minPrice,
        MAX(products.price) as maxPrice,
        MAX(LENGTH(products.description)) as lengthMaxDescription
        FROM products
        GROUP BY products.category_id
      ) AS P ON P.lengthMaxDescription = LENGTH(products.description)
      GROUP BY  categories.name
    ', PDO::FETCH_ASSOC);

echo '<table>
            <thead>
                <tr>
                    <td>Категория</td>
                    <td>Количество</td>
                    <td>Мин. цена</td>
                    <td>Макс. цена</td>
                    <td>Название товара с самым длинным описанием</td>
                    <td>Длина самого длинного описания</td>
                    <td>Самое длинное описание</td>
                </tr>
            </thead>
            <tbody>';

foreach($result as $row) {
    echo '<tr>
                <td>'.$row["cName"].'</td>
                <td>'.$row["productCount"].'</td>
                <td>'.$row["minPrice"].'</td>
                <td>'.$row["maxPrice"].'</td>
                <td>'.$row["name"].'</td>
                <td>'.$row["lengthMaxDescription"].'</td>
                <td>'.$row["description"].'</td>
            </tr>';
}

echo '</tbody></table>';

?>

    </body>
</html>