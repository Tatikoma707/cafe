<?php
$conn = sqlsrv_connect('DIMKA', array("CharacterSet" => "UTF-8"));
if (isset($_GET['query'])) {
    if ($_GET['query'] == "1")
    {
        $sql_temp = sqlsrv_query($conn, "SELECT Title
FROM [Restaurant].[dbo].[Dish]
WHERE Id_category IN
(
 SELECT Id_category
 FROM [Restaurant].[dbo].[Category]
 WHERE Category_name LIKE '%Десерт%'
)");
        print_r(sqlsrv_errors());
        while ($result = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
            echo $result['Title'];//var_dump($result);
        }
    }

    if ($_GET['query'] == "2")
    {
        $sql_temp = sqlsrv_query($conn,"SELECT Dish.Title, Products.Title_product, Category_name
FROM [Restaurant].[dbo].[Dish],[Restaurant].[dbo].[Products],[Restaurant].[dbo].[Composition_dish],[Restaurant].[dbo].[Category]
WHERE Dish.Id_dish=Composition_dish.Id_dish
AND [Restaurant].[dbo].[Composition_dish].Id_product=[Restaurant].[dbo].[Products].Id_product
AND [Restaurant].[dbo].[Dish].Id_category=[Restaurant].[dbo].[Category].Id_category
AND [Restaurant].[dbo].[Category].Id_category=8
");
        print_r(sqlsrv_errors());
        while ($result = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
            //echo var_dump($result);
            echo $result['Title'] . " " .  $result['Title_product']  . " " .  $result['Category_name']  . "<br>" ;
        }
    }

    if ($_GET['query'] == "3")
    {
        $sql_temp = sqlsrv_query($conn,"
        SELECT [Restaurant].[dbo].[Products].Title_product AS Продукт, [Restaurant].[dbo].[Dish].Title AS Блюдо
FROM [Restaurant].[dbo].[Products] INNER JOIN
[Restaurant].[dbo].[Composition_dish] ON [Restaurant].[dbo].[Products].Id_product = [Restaurant].[dbo].[Composition_dish].Id_product INNER JOIN
[Restaurant].[dbo].[Dish] ON [Restaurant].[dbo].[Composition_dish].Id_dish = [Restaurant].[dbo].[Dish].Id_dish
ORDER BY Продукт
        ");
        print_r(sqlsrv_errors());
        while ($result = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
            //echo var_dump($result);
            echo $result ['[Restaurant].[dbo].[Products].Title_product']. " " . $result ['[Restaurant].[dbo].[Dish].Title']  ;
        }
    }

}