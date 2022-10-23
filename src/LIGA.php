<?php
include "config.php";
include "utils.php";


$dbConn =  connect($db);

//========== INICIO TABLA LIGA ============
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
      //Mostrar lista de post
      $sql = $dbConn->prepare("SELECT * FROM LIGA");
      $sql->execute();
      $sql->setFetchMode(PDO::FETCH_ASSOC);
      header("HTTP/1.1 200 OK");
      echo json_encode( $sql->fetchAll()  );
      exit();
}
//============= FIN TABLA LIGA ============


// Crear un nuevo post
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $input = $_POST;
    $sql = "INSERT INTO LIGA
          (tipo_liga, total_puntos)
          VALUES
          (:tipo_liga, :total_puntos)";
    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    $postId = $dbConn->lastInsertId();
    if($postId)
    {
      $input['id'] = $postId;
      header("HTTP/1.1 200 OK");
      echo json_encode($input);
      exit();
	 }
}

//Borrar
if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
{
	$idLigas = $_GET['idLigas'];
  $statement = $dbConn->prepare("DELETE FROM LIGA where idLigas=:idLigas");
  $statement->bindValue(':idLigas', $idLigas);
  $statement->execute();
	header("HTTP/1.1 200 OK");
	exit();
}



//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");

?>