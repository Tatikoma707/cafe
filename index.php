<!DOCTYPE html>
<html lang='en'>
<head>
	<title>Ресторан "У димки"</title>
	<link href='/style.css' rel='stylesheet'>
</head>
<body>

<a href="/?table=tables">Столы</a> |||
<a href="/?table=category">Категории</a> |||
<a href="/?table=products">Продукты</a> |||
<a href="/?table=comp_dish">Состав блюда</a> |||
<a href="/?table=waiter">Официант</a> |||
<a href="/?table=drinks">Напитки</a> |||
<a href="/?table=dish">Блюдо</a> |||
<a href="/?table=checks">Чеки</a> |||
<a href="/?table=orders">Заказы</a><br><br>
<?php
$conn = sqlsrv_connect('DIMKA', array("CharacterSet" => "UTF-8"));

if (isset($_GET['table'])) {
	if ($_GET['table'] == "tables") {
		echo "<form action='/query.php?cmd=insert&table=tables' method='post'>" .
			"<input type='text' placeholder='Количество мест' name='seats'/>" .
			"<input type='submit' value=' Добавить '></form><br>" .
			"<table><tr><td>ID</td><td>Количество мест</td></tr>";
		$sql = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Tables]");
		while ($result = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC))
			echo "<td>{$result['Id_table']}</td><td>{$result['Number_of_seats']}</td>" .
				"<td><a href='javascript:void(0)' onclick=\"document . getElementById('{$result['Id_table']}').style . display = 'block'; \">Редактировать</a></td>" .
				"<td><a href='/query.php?cmd=delete&table=tables&id={$result['Id_table']}'>Удалить</a></td></tr>" .
				"<div id='{$result['Id_table']}' style='display: none;'>" .
				"<form action='/query.php?cmd=update&table=tables&id={$result['Id_table']}' method='post'>" .
				"<input type='text' name='seats' value='{$result['Number_of_seats']}'/>" .
				"<input type='submit' value=' Редактировать '></form></div>";
		echo "</table>";
	}

	if ($_GET['table'] == "category") {
		$sql = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Category]");
		echo "<form action='/query.php?cmd=insert&table=category' method='post'>" .
			"<input type='text' placeholder='Название категории' name='category'/>" .
			"<input type='submit' value=' Добавить '></form><br>" .
			"<table><tr><td>ID</td><td>Название категории</td></tr>";
		while ($result = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC))
			echo "<td>{$result['Id_category']}</td><td>{$result['Category_name']}</td>" .
				"<td><a href='javascript:void(0)' onclick=\"document . getElementById('{$result['Id_category']}').style . display = 'block'; \">Редактировать</a></td>" .
				"<td><a href='/query.php?cmd=delete&table=category&id={$result['Id_category']}'>Удалить</a></td></tr>" .
				"<div id='{$result['Id_category']}' style='display: none;'>" .
				"<form action='/query.php?cmd=update&table=category&id={$result['Id_category']}' method='post'>" .
				"<input type='text' name='category' value='{$result['Category_name']}'/>" .
				"<input type='submit' value=' Редактировать '></form></div>";
		echo "</table>";
	}

	if ($_GET['table'] == "products") {
		$sql = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Products]");
		echo "<form action='/query.php?cmd=insert&table=products' method='post'>" .
			"<input type='text' placeholder='Продукт' name='products'/>" .
			"<input type='submit' value=' Добавить '></form><br>" .
			"<table><tr><td>ID</td><td>Название продукта</td></tr>";
		while ($result = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC))
			echo "<td>{$result['Id_product']}</td><td>{$result['Title_product']}</td>" .
				"<td><a href='javascript:void(0)' onclick=\"document . getElementById('{$result['Id_product']}').style . display = 'block'; \">Редактировать</a></td>" .
				"<td><a href='/query.php?cmd=delete&table=products&id={$result['Id_product']}'>Удалить</a></td></tr>" .
				"<div id='{$result['Id_product']}' style='display: none;'>" .
				"<form action='/query.php?cmd=update&table=products&id={$result['Id_product']}' method='post'>" .
				"<input type='text' name='product' value='{$result['Title_product']}'/>" .
				"<input type='submit' value=' Редактировать '></form></div>";
		echo "</table>";
	}

	if ($_GET['table'] == "comp_dish") {
		$sql = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Composition_dish]");
		echo "<form action='/query.php?cmd=insert&table=comp_dish' method='post'>" .
			"<select name='dish'>";
		$sql_temp = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Dish]");
		while ($result_temp = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
			echo "<option value ='{$result_temp['Id_dish']}'> {$result_temp['Title']}</option>";
		}
		echo "</select><select name='product'>";
		$sql_temp = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Products]");
		while ($result_temp = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
			echo "<option value ='{$result_temp['Id_product']}'> {$result_temp['Title_product']}</option>";
		}
		echo "</select>" .
			"<input type='text' placeholder='Вес' name='products'/>" .
			"<input type='submit' value=' Добавить '></form><br>" .
			"<table><tr><td>Название блюда</td><td>Название продукта</td><td>Вес</td></tr>";
		while ($result = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
			$sql_temp = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Dish] WHERE Id_dish = '{$result['Id_dish']}'");
			$result_temp = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC);
			echo "<td>{$result_temp['Title']}</td>";
			$sql_temp = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Products] WHERE Id_product = '{$result['Id_product']}'");
			$result_temp = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC);
			echo "<td>{$result_temp['Title_product']}</td><td>{$result['Weight_product']}</td>";
			echo "<td><a href='javascript:void(0)' onclick=\"document . getElementById('{$result['Id_product']}').style . display = 'block'; \">Редактировать</a></td>" .
				"<td><a href='/query.php?cmd=delete&table=comp_dish&id={$result['Id_product']}&id2={$result['Id_dish']}'>Удалить</a></td></tr>" .
				"<div id='{$result['Id_product']}' style='display: none;'>" .
				"<form action='/query.php?cmd=update&table=comp_dish&id={$result['Id_product']}&id2={$result['Id_dish']}' method='post'>" .
				"<select name='dish'>";
			$sql_temp = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Dish]");
			while ($result_temp = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
				if ($result_temp['Id_dish'] == $result['Id_dish'])
					echo "<option selected value ='{$result_temp['Id_dish']}'> {$result_temp['Title']}</option>";
				else
					echo "<option value ='{$result_temp['Id_dish']}'> {$result_temp['Title']}</option>";
			}
			echo "</select><select name='product'>";
			$sql_temp = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Products]");
			while ($result_temp = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
				if ($result_temp['Id_product'] == $result['Id_product'])
					echo "<option selected value ='{$result_temp['Id_product']}'> {$result_temp['Title_product']}</option>";
				else
					echo "<option value ='{$result_temp['Id_product']}'> {$result_temp['Title_product']}</option>";
			}
			echo "</select>" .
				"<input type='text' name='weight' value='{$result['Weight_product']}'/>" .
				"<input type='submit' value=' Редактировать '></form></div>";
		}
		echo "</table>";
	}


	if ($_GET['table'] == "waiter") {
		$sql = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Waiter]");
		echo "<form action='/query.php?cmd=insert&table=waiter' method='post'>" .
			"<input type='text' placeholder='Фамилия' name='2name'/>" .
			"<input type='text' placeholder='Имя' name='1name'/>" .
			"<input type='text' placeholder='Отчество' name='3name'/>" .
			"<input type='submit' value=' Добавить '></form><br>" .
			"<table><tr><td>ID</td><td>Фамилия</td><td>Имя</td><td>Отчество</td></tr>";
		while ($result = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC))
			echo "<td>{$result['Id_waiter']}</td><td>{$result['Second_name']}</td><td>{$result['First_name']}</td><td>{$result['Last_name']}</td>" .
				"<td><a href='javascript:void(0)' onclick=\"document . getElementById('{$result['Id_waiter']}').style . display = 'block'; \">Редактировать</a></td>" .
				"<td><a href='/query.php?cmd=delete&table=waiter&id={$result['Id_waiter']}'>Удалить</a></td></tr>" .
				"<div id='{$result['Id_waiter']}' style='display: none;'>" .
				"<form action='/query.php?cmd=update&table=waiter&id={$result['Id_waiter']}' method='post'>" .
				"<input type='text' name='2name' value='{$result['Second_name']}'/>" .
				"<input type='text' name='1name' value='{$result['First_name']}'/>" .
				"<input type='text' name='3name' value='{$result['Last_name']}'/>" .
				"<input type='submit' value=' Редактировать '></form></div>";
		echo "</table>";
	}

	if ($_GET['table'] == "drinks") {
		$sql = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Drinks]");
		echo "<form action='/query.php?cmd=insert&table=drinks' method='post'>" .
			"<input type='text' placeholder='Наименование' name='name'/>" .
			"<input type='text' placeholder='Цена' name='price'/>" .
			"<input type='submit' value=' Добавить '></form><br>" .
			"<table><tr><td>ID</td><td>Наименование</td><td>Цена</td></tr>";
		while ($result = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC))
			echo "<tr><td>{$result['Id_drink']}</td><td>{$result['Title_drink']}</td><td>{$result['Price']}</td>" .
				"<td><a href='javascript:void(0)' onclick=\"document . getElementById('{$result['Id_drink']}').style . display = 'block'; \">Редактировать</a></td>" .
				"<td><a href='/query.php?cmd=delete&table=drinks&id={$result['Id_drink']}'>Удалить</a></td></tr>" .
				"<div id='{$result['Id_drink']}' style='display: none;'>" .
				"<form action='/query.php?cmd=update&table=drinks&id={$result['Id_drink']}' method='post'>" .
				"<input type='text' name='title' value='{$result['Title_drink']}'/>" .
				"<input type='text' name='price' value='{$result['Price']}'/>" .
				"<input type='submit' value=' Редактировать '></form></div>";
		echo "</table>";
	}

	if ($_GET['table'] == "dish") {
		$sql = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Dish]");
		echo "<form action='/query.php?cmd=insert&table=dish' method='post'>" .
			"<input type='text' placeholder='Наименование' name='name'/>" .
			"<input type='text' placeholder='Цена' name='price'/>" .
			"<select name='category'>";
		$sql_temp = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Category]");
		while ($result_temp = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
			echo "<option value ='{$result_temp['Id_category']}'> {$result_temp['Category_name']}</option>";
		}
		echo "</select><input type='text' placeholder='Вес' name='weight'/>" .
			"<input type='submit' value=' Добавить '></form><br>" .
			"<table><tr><td>ID</td><td>Наименование</td><td>Вес</td><td>Категория</td><td>Цена</td></tr>";
		while ($result = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
			echo "<tr><td>{$result['Id_dish']}</td><td>{$result['Title']}</td><td>{$result['Portion_weight']}</td>";
			$sql_temp = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Category] WHERE Id_category = '{$result['Id_category']}'");
			$result_temp = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC);
			echo "<td>{$result_temp['Category_name']}</td><td>{$result['Price']}</td>";
			echo "<td><a href='javascript:void(0)' onclick=\"document . getElementById('{$result['Id_dish']}').style . display = 'block'; \">Редактировать</a></td>" .
				"<td><a href='/query.php?cmd=delete&table=dish&id={$result['Id_dish']}'>Удалить</a></td></tr>" .
				"<div id='{$result['Id_dish']}' style='display: none;'>" .
				"<form action='/query.php?cmd=update&table=dish&id={$result['Id_dish']}' method='post'>" .
				"<input type='text' name='title' value='{$result['Title']}'/>" .
				"<input type='text' name='price' value='{$result['Price']}'/>" .
				"<input type='text' name='weight' value='{$result['Portion_weight']}'/><select name='category'>";
			$sql_temp = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Category]");
			while ($result_temp = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
				if ($result_temp['Id_category'] == $result['Id_category'])
					echo "<option selected value ='{$result_temp['Id_category']}'> {$result_temp['Category_name']}</option>";
				else
					echo "<option value ='{$result_temp['Id_category']}'> {$result_temp['Category_name']}</option>";
			}
			echo "</select><input type='submit' value=' Редактировать '></form></div>";
		}
		echo "</table>";
	}


	if ($_GET['table'] == "checks") {
		echo "<form action='/query.php?cmd=insert&table=checks' method='post'>" .
			"<input type='text' placeholder='Дата' name='date'/>" .
			"<input type='text' placeholder='Время' name='time'/>" .
			"<input type='text' placeholder='Номер стола' name='table'/><select name='waiter'>";
		$sql_temp = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Waiter]");
		while ($result_temp = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
			echo "<option value ='{$result_temp['Id_waiter']}'> {$result_temp['Second_name']} {$result_temp['First_name']} {$result_temp['Last_name']} </option>";
		}
		echo "</select><input type='text' placeholder='Стоимость' name='summ'/>" .
			"<input type='text' placeholder='Заказ' name='order'/>" .
			"<input type='submit' value=' Добавить '></form><br>" .
			"<table><tr><td>ID</td><td>Дата</td><td>Время</td><td>Номер стола</td><td>Оффициант</td><td>Стоимость</td><td>Заказ</td></tr>";
		$sql = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Checks]");
		while ($result = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
			echo "<td>" . $result['Id_check'] . "</td><td>" . $result['Date']->format("Y-m-d") . "</td><td>" . $result['Time']->format("H:i:s") . "</td><td>{$result['Id_table']}</td>";
			$sql_temp = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Waiter] WHERE Id_waiter = '{$result['Id_waiter']}'");
			$result_temp = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC);
			echo "<td>{$result_temp['Second_name']} {$result_temp['First_name']} {$result_temp['Last_name']}</td><td>{$result['Total']}</td><td>{$result['Id_order']}</td>";
			echo "<td><a href='javascript:void(0)' onclick=\"document . getElementById('{$result['Id_check']}').style . display = 'block'; \">Редактировать</a></td>" .
				"<td><a href='/query.php?cmd=delete&table=checks&id={$result['Id_check']}'>Удалить</a></td></tr>" .
				"<div id='{$result['Id_check']}' style='display: none;'>" .
				"<form action='/query.php?cmd=update&table=checks&id={$result['Id_check']}' method='post'>
                <input type='text' name='check' value='{$result['Id_check']}'/>
                <input type='text' name='date' value='" . $result['Date']->format("Y-m-d") . "'/>
                <input type='text' name='time' value='" . $result['Time']->format("H:i:s") . "'/>
                <input type='text' name='table' value='{$result['Id_table']}'/><select name='waiter'>";

			$sql_temp = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Waiter]");
			while ($result_temp = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
				if ($result['Id_waiter'] == $result_temp['Id_waiter'])
					echo "<option selected value ='{$result_temp['Id_waiter']}'> {$result_temp['Second_name']} {$result_temp['First_name']} {$result_temp['Last_name']} </option>";
				else
					echo "<option value ='{$result_temp['Id_waiter']}'> {$result_temp['Second_name']} {$result_temp['First_name']} {$result_temp['Last_name']} </option>";
			}

			echo "</select><input type='text' name='order' value='{$result['Id_order']}'/>" .
				"<input type='submit' value=' Редактировать '></form></div>";
		}
		echo "</table>";
	}


	if ($_GET['table'] == "orders") {
		echo "<form action='/query.php?cmd=insert&table=orders' method='post'><select name='dish'>";
		$sql_temp = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Dish]");
		while ($result_temp = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
			echo "<option value ='{$result_temp['Id_category']}'> {$result_temp['Title']}</option>";
		}
		echo "</select><select name='drink'>";
		$sql_temp = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Drinks]");
		while ($result_temp = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
			echo "<option value ='{$result_temp['Id_drink']}'> {$result_temp['Title_drink']}</option>";
		}
		echo "</select><input type='text' placeholder='Номер чека' name='check'/><input type='submit' value=' Добавить '></form><br>" .
			"<table><tr><td>ID</td><td>Блюдо</td><td>Напиток</td><td>Номер чека</td></tr>";
		$sql = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Orders]");
		while ($result = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
			echo "<td>{$result['Id_order']}</td>";
			$sql_temp = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Dish] WHERE Id_dish = '{$result['Id_dish']}'");
			$result_temp = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC);
			echo "<td>{$result_temp['Title']}</td>";
			$sql_temp = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Drinks] WHERE Id_drink = '{$result['Id_drink']}'");
			$result_temp = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC);
			echo "<td>{$result_temp['Title_drink']}</td><td>{$result['Id_check']}</td>";
			echo "<td><a href='javascript:void(0)' onclick=\"document . getElementById('{$result['Id_order']}').style . display = 'block'; \">Редактировать</a></td>" .
				"<td><a href='/query.php?cmd=delete&table=orders&id={$result['Id_order']}'>Удалить</a></td></tr>" .
				"<div id='{$result['Id_order']}' style='display: none;'>" .
				"<form action='/query.php?cmd=update&table=orders&id={$result['Id_order']}' method='post'><select name='dish'>";
			$sql_temp = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Dish]");
			while ($result_temp = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
				if ($result['Id_dish'] == $result_temp['Id_dish'])
					echo "<option selected value ='{$result_temp['Id_dish']}'> {$result_temp['Title']}</option>";
				else
					echo "<option value ='{$result_temp['Id_dish']}'> {$result_temp['Title']}</option>";
			}
			echo "</select><select name='drink'>";
			$sql_temp = sqlsrv_query($conn, "SELECT * FROM [Restaurant].[dbo].[Drinks]");
			while ($result_temp = sqlsrv_fetch_array($sql_temp, SQLSRV_FETCH_ASSOC)) {
				if ($result['Id_drink'] == $result_temp['Id_drink'])
					echo "<option selected value ='{$result_temp['Id_drink']}'> {$result_temp['Title_drink']}</option>";
				else
					echo "<option value ='{$result_temp['Id_drink']}'> {$result_temp['Title_drink']}</option>";
			}
			echo "</select><input type='text' name='check' value='{$result['Id_check']}'/><input type='submit' value=' Редактировать '></form></div>";
		}
		echo "</table>";
	}

}
?>

</body>
</html>