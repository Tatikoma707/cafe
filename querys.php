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
        SELECT [Restaurant].[dbo].[Products].Title_product, [Restaurant].[dbo].[Dish].Title
FROM [Restaurant].[dbo].[Products] INNER JOIN
[Restaurant].[dbo].[Composition_dish] ON [Restaurant].[dbo].[Products].Id_product = [Restaurant].[dbo].[Composition_dish].Id_product INNER JOIN
[Restaurant].[dbo].[Dish] ON [Restaurant].[dbo].[Composition_dish].Id_dish = [Restaurant].[dbo].[Dish].Id_dish
ORDER BY Title_product
        ");
        print_r(sqlsrv_errors());
        while ($result = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
            //echo var_dump($result);
            echo $result ['Title_product']. " " . $result ['Title'].  "<br>" ;
        }
    }


    if ($_GET['query'] == "4")
    {
        $sql_temp = sqlsrv_query($conn,"
        SELECT [Restaurant].[dbo].[Orders].Id_order,
ISNULL([Restaurant].[dbo].[Dish].Title, 'not_ordered'),
ISNULL([Restaurant].[dbo].[Drinks].Title_drink, 'not_ordered')
FROM [Restaurant].[dbo].[Orders] LEFT OUTER JOIN [Restaurant].[dbo].[Dish]
ON [Restaurant].[dbo].[Dish].Id_dish = [Restaurant].[dbo].[Orders].Id_dish LEFT OUTER JOIN [Restaurant].[dbo].[Drinks]
ON [Restaurant].[dbo].[Orders].Id_drink = [Restaurant].[dbo].[Drinks].Id_drink
    ");
        print_r(sqlsrv_errors());
        while ($result = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
            echo var_dump($result);
            echo $result ['Id_order']. " " . $result ['Title']. " " . $result ['Title_drink']. "<br>" ;
        }
    }//лешка фикс

    if ($_GET['query'] == "5")
    {
        $sql_temp = sqlsrv_query($conn,"
         SELECT [Restaurant].[dbo].[Waiter].First_name, COUNT([Restaurant].[dbo].[Checks].Id_check)
 AS 'count'
 FROM [Restaurant].[dbo].[Checks] INNER JOIN [Restaurant].[dbo].[Waiter] on [Restaurant].[dbo].[Checks].Id_waiter = [Restaurant].[dbo].[Waiter].Id_waiter
 GROUP BY [Restaurant].[dbo].[Waiter].First_name  HAVING COUNT([Restaurant].[dbo].[Checks].Id_check) >= 2
    ");
        print_r(sqlsrv_errors());
        while ($result = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
            //echo var_dump($result);
            echo $result ['First_name']. " " . $result ['count']. "<br>" ;
        }
    }


    if ($_GET['query'] == "6")
    {
        $sql_temp = sqlsrv_query($conn,"
        SELECT Id_check, Id_table, Total,
CASE
WHEN (Total >= 350 AND Total<390)THEN '5%'
WHEN Total >= 390 THEN '8%'
ELSE '0%'
END SaleProcent,
Total/100*
CASE
WHEN (Total >= 350 AND Total<390) THEN 5
WHEN Total >= 390 THEN 8
ELSE 0
END Sale
FROM [Restaurant].[dbo].[Checks]
        ");
        print_r(sqlsrv_errors());
        while ($result = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
            //echo var_dump($result);
            echo $result ['Id_check']. " " . $result ['Id_table']. " " . $result ['Total']. " " . $result ['SaleProcent']." " . $result ['Sale']. "<br>" ;
        }
    }

    if ($_GET['query'] == "7")
    {
        $sql_temp = sqlsrv_query($conn,"
        SELECT Title, Price,
CASE
WHEN Price = (SELECT MAX(Price) FROM [Restaurant].[dbo].[Dish]) THEN 'Max_price'
WHEN Price = (SELECT MIN(Price) FROM [Restaurant].[dbo].[Dish]) THEN 'Min_price'
WHEN Price > (SELECT AVG(Price) FROM [Restaurant].[dbo].[Dish]) THEN 'Price_is_above_average'
WHEN Price < (SELECT AVG(Price) FROM [Restaurant].[dbo].[Dish]) THEN 'Price_below_average'
ELSE 'Average_price'
END 'Status_prices'
FROM [Restaurant].[dbo].[Dish]
UNION ALL
SELECT Title_drink, Price,
CASE
WHEN Price = (SELECT MAX(Price) FROM [Restaurant].[dbo].[Drinks]) THEN 'Max_price'
WHEN Price = (SELECT MIN(Price) FROM [Restaurant].[dbo].[Drinks]) THEN 'Min_price'
WHEN Price > (SELECT AVG(Price) FROM [Restaurant].[dbo].[Drinks]) THEN 'Price_is_above_average'
WHEN Price < (SELECT AVG(Price) FROM [Restaurant].[dbo].[Drinks]) THEN 'Price_below_average'
ELSE 'Average_price'
END 'Status_prices'
FROM [Restaurant].[dbo].[Drinks]

        ");
        print_r(sqlsrv_errors());
        while ($result = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
            //echo var_dump($result);
            echo $result ['Title']. " " . $result ['Price']. " " . $result ['Status_prices']. "<br>" ;
        }
    }


    if ($_GET['query'] == "8")
    {
        $sql_temp = sqlsrv_query($conn,"
        select date, total, count(*) count
from [Restaurant].[dbo].[Checks]
group by rollup ( date, total)
        ");
        print_r(sqlsrv_errors());
        while ($result = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
            //echo var_dump($result);
            echo $result ['date']->format('Y-m-d'). " " . $result ['total']. " " . $result ['count']. "<br>" ;
        }
    }//лешка фикс

    if ($_GET['query'] == "9")
    {
        $sql_temp = sqlsrv_query($conn,"DECLARE @a time(0)='09:00:00', @b time(0)='10:00:00'
WHILE( @b <'23:00:00')
BEGIN
DECLARE @t table(С time(0), До time(0), Количество_заказов int)
INSERT INTO @t
SELECT @a, @b, COUNT(Checks.Id_check)
FROM Checks
WHERE (Time>=@a AND Time<=@b)
SET @a=DATEADD(hour, 1, @a)
SET @b=DATEADD(hour, 1, @b)
END
SELECT*FROM @t

SELECT Waiter.First_name
FROM  Waiter, Checks, @t
WHERE (Checks.Time>С AND Checks.Time<До AND Количество_заказов=7  AND Checks.Id_waiter=Waiter.Id_waiter)
        ");
        print_r(sqlsrv_errors());
        while ($result = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
            //echo var_dump($result);

        }
    }// спаси и слхрани Святой Алексий Адольфович


    if ($_GET['query'] == "10")
    {
        $sql_temp = sqlsrv_query($conn,"
        select distinct t1.id_dish, t1.Id_order
from [Restaurant].[dbo].[Orders] t1, [Restaurant].[dbo].[Checks] t3
where t1.Id_dish in
   (select t2.id_dish
    from [Restaurant].[dbo].[Dish] t2
    where t1.Id_dish = t2.Id_dish)

            ");
        print_r(sqlsrv_errors());
        while ($result = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
            //echo var_dump($result);
            echo $result ['id_dish']. " " . $result ['Id_order']. "<br>" ;
        }
    }
}