<?php
	try{
		$conexion = new PDO('mysql:host=localhost:3306;dbname=josesald_paginacion', 'josesald_user_test', 'QjyrNfR65*{i');
	}
	catch(PDOException $e){
		echo "ERROR: " . $e->getMessage();
	}

$pagina        = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$postPorPagina = 5;
$inicio        = ($pagina > 1) ? ($pagina * $postPorPagina - $postPorPagina) : 0 ;

$articulos = $conexion->prepare("
	SELECT * FROM articulos
	WHERE ARTICULO_ID > $inicio
	LIMIT $postPorPagina
");

$articulos->execute();
$articulos = $articulos->fetchAll();

if (!$articulos) {
	header('Location: https://josesaldivarc.com/php/Paginacion/');
}

$totalArticulos = $conexion->prepare('SELECT COUNT(*) as total FROM articulos');
$totalArticulos->execute();
$totalArticulos = $totalArticulos->fetch()['total'];

$numeroPaginas = ceil($totalArticulos / $postPorPagina);

require 'index.view.php';
?>