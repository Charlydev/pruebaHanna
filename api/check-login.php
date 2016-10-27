<?php
header('Content-Type: application/json');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//include_once 'controlador.php';
    require_once('config/mysql.php');
   
    $db  = new dbConnect();
    $dbh = $db->conectardb();
   

if(isset($_POST['login']) && isset($_POST['clave'])){  
//echo "entro al login y clave";  

        //$cx = new controlador();
        $login=$_POST['login'];
        $pass=md5($_POST['clave']);
        $csql="select * from usuario where upper(codigo_usuario)=upper('$login')";
        $stmt = $dbh->prepare($csql);
        $stmt->execute();
        $rx = $stmt->fetchAll(PDO::FETCH_ASSOC);

   // var_dump($rx);
      //  echo $rx[0]['IDAREA'];
      //  echo $pass;
    
        if(count($rx)==1){
                if($rx[0]['password']==$pass){
                    session_start();
                    $_SESSION['IDUSUARIO']=$rx[0]['id_usuario'];
                    $_SESSION['login']=$rx[0]['codigo_usuario'];
                    $_SESSION['nombreus']=$rx[0]['nombres'];
                    $_SESSION['apellidous']=$rx[0]['apellidos'];
                    $_SESSION['perfil']=$rx[0]['id_perfil'];
                    //$_SESSION['emailus']=$rx[0]['email'];
                    $_SESSION['type']="usuario";
                    
                    // Si el usuario es cliente traemos el ID de la empresa
                    $csql="select id_cliente, id_usuario from usuarios_x_cliente where id_usuario = :id_usuario";
                    $stmt = $dbh->prepare($csql);
                    $stmt->bindParam(':id_usuario', $rx[0]['id_usuario'], PDO::PARAM_INT);
                    $stmt->execute();
                    $rx1 = $stmt->fetch(PDO::FETCH_ASSOC);

                    if(isset($rx1['id_cliente'])){
                        $_SESSION['id_cliente'] = $rx1['id_cliente'];
                    }
                    else{
                        $_SESSION['id_cliente'] = null;
                    }

                    // Si el usuario es consultor traemos el ID del consultor
                    $csql="select id_consultor, id_usuario from consultor where id_usuario = :id_usuario";
                    $stmt = $dbh->prepare($csql);
                    $stmt->bindParam(':id_usuario', $rx[0]['id_usuario'], PDO::PARAM_INT);
                    $stmt->execute();
                    $rx2 = $stmt->fetch(PDO::FETCH_ASSOC);

                    if(isset($rx2['id_consultor'])){
                        $_SESSION['id_consultor']=$rx2['id_consultor'];
                    }
                    else{
                        $_SESSION['id_consultor']=null;
                    }
                    
                    echo "{\"acceso\":\"true\",\"url\":\"admin\"}";
                }
            
                else{
                    echo "{\"acceso\":\"false\"}";
                }
            
        }else{
            echo "{\"acceso\":\"false\"}";
        }            
}else{
    echo "{\"acceso\":\"false\"}";
}
?>