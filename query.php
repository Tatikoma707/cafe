<?php
$conn = sqlsrv_connect('DIMKA', array("CharacterSet" => "UTF-8"));
if ((isset($_GET['cmd'])) && ($_GET['cmd'] == "insert")) {
    if (isset($_GET['table'])) {
        if ($_GET['table'] == "tables") {
            $sql = sqlsrv_query($conn, "INSERT INTO [Restaurant].[dbo].[Tables] VALUES ('{$_POST['seats']}')");
            header('Location: /?table=tables');
            exit();
        }
        if ($_GET['table'] == "category") {
            $sql = sqlsrv_query($conn, "INSERT INTO [Restaurant].[dbo].[Category] VALUES ('{$_POST['category']}')");
            header('Location: /?table=category');
            exit();
        }
        if ($_GET['table'] == "products") {
            $sql = sqlsrv_query($conn, "INSERT INTO [Restaurant].[dbo].[Products] VALUES ('{$_POST['products']}')");
            header('Location: /?table=products');
            exit();
        }
        if ($_GET['table'] == "comp_dish") {
            $sql = sqlsrv_query($conn, "INSERT INTO [Restaurant].[dbo].[Composition_dish] VALUES ('{$_POST['dish']}' , '{$_POST['product']}' , '{$_POST['products']}')");
            header('Location: /?table=comp_dish');
            exit();
        }
        if ($_GET['table'] == "waiter") {
            $sql = sqlsrv_query($conn, "INSERT INTO [Restaurant].[dbo].[Waiter] VALUES ('{$_POST['2name']}', '{$_POST['1name']}', '{$_POST['3name']}')");
            header('Location: /?table=waiter');
            exit();
        }
        if ($_GET['table'] == "drinks") {
            $sql = sqlsrv_query($conn, "INSERT INTO [Restaurant].[dbo].[Drinks] VALUES ('{$_POST['name']}', '{$_POST['price']}')");
            header('Location: /?table=drinks');
            exit();
        }
        if ($_GET['table'] == "dish") {
            $sql = sqlsrv_query($conn, "INSERT INTO [Restaurant].[dbo].[Dish] VALUES ('{$_POST['name']}', '{$_POST['price']}', '{$_POST['category']}' ,'{$_POST['weight']}')");
            header('Location: /?table=dish');
            exit();
        }
        if ($_GET['table'] == "checks") {
            $sql = sqlsrv_query($conn, "INSERT INTO [Restaurant].[dbo].[Checks] VALUES ('{$_POST['date']}', '{$_POST['time']}', '{$_POST['table']}', '{$_POST['waiter']}' ,'{$_POST['summ']}' ,'{$_POST['order']}')");
            header('Location: /?table=checks');
            exit();
        }
        if ($_GET['table'] == "orders") {
            $sql = sqlsrv_query($conn, "INSERT INTO [Restaurant].[dbo].[Orders] VALUES ('{$_POST['dish']}', '{$_POST['drink']}', '{$_POST['check']}')");
            header('Location: /?table=orders');
            exit();
        }
    }
}

if ((isset($_GET['cmd'])) && ($_GET['cmd'] == "delete")) {
    if (isset($_GET['table'])) {
        if ($_GET['table'] == "tables") {
            $sql = sqlsrv_query($conn, "DELETE FROM [Restaurant].[dbo].[Tables] WHERE Id_table ={$_GET['id']}");
            header('Location: /?table=tables');
            exit();
        }
        if ($_GET['table'] == "category") {
            $sql = sqlsrv_query($conn, "DELETE FROM [Restaurant].[dbo].[Category] WHERE Id_category ={$_GET['id']}");
            header('Location: /?table=category');
            exit();
        }
        if ($_GET['table'] == "products") {
            $sql = sqlsrv_query($conn, "DELETE FROM [Restaurant].[dbo].[Products] WHERE Id_product ={$_GET['id']}");
            header('Location: /?table=products');
            exit();
        }
        if ($_GET['table'] == "comp_dish") {
            $sql = sqlsrv_query($conn, "DELETE FROM [Restaurant].[dbo].[Composition_dish] WHERE Id_product ={$_GET['id']} AND Id_dish ={$_GET['id2']}");
            header('Location: /?table=comp_dish');
            exit();
        }
        if ($_GET['table'] == "waiter") {
            $sql = sqlsrv_query($conn, "DELETE FROM [Restaurant].[dbo].[Waiter] WHERE Id_waiter ={$_GET['id']}");
            header('Location: /?table=waiter');
            exit();
        }
        if ($_GET['table'] == "drinks") {
            $sql = sqlsrv_query($conn, "DELETE FROM [Restaurant].[dbo].[Drinks] WHERE Id_drink ={$_GET['id']}");
            header('Location: /?table=drinks');
            exit();
        }
        if ($_GET['table'] == "dish") {
            $sql = sqlsrv_query($conn, "DELETE FROM [Restaurant].[dbo].[Dish] WHERE Id_dish ={$_GET['id']}");
            header('Location: /?table=dish');
            exit();
        }
        if ($_GET['table'] == "checks") {
            $sql = sqlsrv_query($conn, "DELETE FROM [Restaurant].[dbo].[Checks] WHERE Id_check ={$_GET['id']}");
            header('Location: /?table=checks');
            exit();
        }
        if ($_GET['table'] == "orders") {
            $sql = sqlsrv_query($conn, "DELETE FROM [Restaurant].[dbo].[Orders] WHERE Id_order ={$_GET['id']}");
            header('Location: /?table=orders');
            exit();
        }
    }
}


if ((isset($_GET['cmd'])) && ($_GET['cmd'] == "update")) {
    if (isset($_GET['table'])) {
        if ($_GET['table'] == "tables") {
            $sql = sqlsrv_query($conn, "UPDATE [Restaurant].[dbo].[Tables] SET Number_of_seats = '{$_POST['seats']}' WHERE Id_table ={$_GET['id']}");
            header('Location: /?table=tables');
            exit();
        }
        if ($_GET['table'] == "category") {
            $sql = sqlsrv_query($conn, "UPDATE [Restaurant].[dbo].[Category] SET Category_name = '{$_POST['category']}' WHERE Id_category ={$_GET['id']}");
            header('Location: /?table=category');
            exit();
        }
        if ($_GET['table'] == "products") {
            $sql = sqlsrv_query($conn, "UPDATE [Restaurant].[dbo].[Products] SET Title_product = '{$_POST['product']}' WHERE Id_product ={$_GET['id']}");
            header('Location: /?table=products');
            exit();
        }
        if ($_GET['table'] == "comp_dish") {
            $sql = sqlsrv_query($conn, "UPDATE [Restaurant].[dbo].[Composition_dish] SET Id_dish = '{$_POST['dish']}', Id_product = '{$_POST['product']}', Weight_product = '{$_POST['weight']}' WHERE Id_product ={$_GET['id']} AND Id_dish ={$_GET['id2']}");
            header('Location: /?table=comp_dish');
            exit();
        }
        if ($_GET['table'] == "waiter") {
            $sql = sqlsrv_query($conn, "UPDATE [Restaurant].[dbo].[Waiter] SET Second_name = '{$_POST['2name']}', First_name = '{$_POST['1name']}', Last_name = '{$_POST['3name']}' WHERE Id_waiter ={$_GET['id']}");
            header('Location: /?table=waiter');
            exit();
        }
        if ($_GET['table'] == "drinks") {
            $sql = sqlsrv_query($conn, "UPDATE [Restaurant].[dbo].[Drinks] SET Title_drink = '{$_POST['title']}', Price = '{$_POST['price']}' WHERE Id_drink ={$_GET['id']}");
            header('Location: /?table=drinks');
            exit();
        }
        if ($_GET['table'] == "dish") {
            $sql = sqlsrv_query($conn, "UPDATE [Restaurant].[dbo].[Dish] SET Title = '{$_POST['title']}', Portion_weight = '{$_POST['weight']}', Id_category = '{$_POST['category']}', Price = '{$_POST['price']}' WHERE Id_dish ={$_GET['id']}");
            header('Location: /?table=dish');
            exit();
        }
        if ($_GET['table'] == "orders") {
            $sql = sqlsrv_query($conn, "UPDATE [Restaurant].[dbo].[Orders] SET Id_dish = '{$_POST['dish']}', Id_drink = '{$_POST['drink']}', Id_check = '{$_POST['check']}' WHERE Id_order ={$_GET['id']}");
            header('Location: /?table=orders');
            exit();
        }
        if ($_GET['table'] == "checks") {
            $sql = sqlsrv_query($conn, "UPDATE [Restaurant].[dbo].[Checks] SET Date = '{$_POST['date']}', Time = '{$_POST['time']}', Id_table = '{$_POST['table']}', " .
                "Id_waiter = '{$_POST['waiter']}', Total = '{$_POST['total']}', Id_order = '{$_POST['order']}'WHERE Id_check ={$_GET['id']}");
            header('Location: /?table=checks');
            exit();
        }
    }
}