<?php
    require_once 'clases/respuestas.class.php';
    require_once 'clases/pacientes.class.php';

    $_respuestas = new respuestas;
    $_pacientes = new pacientes;

    if($_SERVER['REQUEST_METHOD'] == "GET"){
        if(isset($_GET["page"])){
            $pagina = $_GET["page"];
            $listaPacientes = $_pacientes->listaPacientes($pagina);
            header('Content-Type: application/json');
            echo json_encode($listaPacientes, JSON_PRETTY_PRINT);
            http_response_code(200);
        }else if(isset($_GET['id'])){
            $pacienteid = $_GET['id'];
            $datosPaciente = $_pacientes->obtenerPaciente($pacienteid);
            header('Content-Type: application/json');
            echo json_encode($datosPaciente, JSON_PRETTY_PRINT);
            http_response_code(200);
        }

    }else if($_SERVER['REQUEST_METHOD'] == "POST"){
        //recibimos los datos enviados
        $postBody = file_get_contents("php://input");
        //enviamos al manejador
        $datosArray = $_pacientes->post($postBody);
       //devolvemos una respuesta
        //devuelve una respuesta 
        header('content-Type: application/json');
        if (isset($datosArray["result"]["error_id"])){
            $responsecode = $datosArray["result"]["error_id"];
            http_response_code($responsecode);
        }else{
            http_response_code(200);
        }
        echo json_encode($datosArray);

    }else if($_SERVER['REQUEST_METHOD'] == "PUT"){

        //recibimos los datos enviados
        $postBody = file_get_contents("php://input");
       //enviamos datos al manejador
        $datosArray = $_pacientes->put($postBody);
      //devuelve una respuesta 
        header('content-Type: application/json');
        if (isset($datosArray["result"]["error_id"])){
            $responsecode = $datosArray["result"]["error_id"];
            http_response_code($responsecode);
        }else{
            http_response_code(200);
        }
        echo json_encode($datosArray);

    }else if($_SERVER['REQUEST_METHOD'] == "DELETE"){

          //recibimos los datos enviados
           $postBody = file_get_contents("php://input");
         //enviamos datos al manejador
            $datosArray = $_pacientes->delete($postBody);
         //devuelve una respuesta 
           header('content-Type: application/json');
            if (isset($datosArray["result"]["error_id"])){
                  $responsecode = $datosArray["result"]["error_id"];
                  http_response_code($responsecode);
            }else{
                     http_response_code(200);
                 }
                 echo json_encode($datosArray);

    }else{
        header('content-Type: application/json');
        $datosArray = $_respuestas->error_405();
        echo json_encode($datosArray);
    }

?>