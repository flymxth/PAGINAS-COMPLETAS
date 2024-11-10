<?php
    $txtID=(isset($_POST['txtID'])) ? $_POST['txtID'] : "";
    $txtNombre=(isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
    $txtApellidoP=(isset($_POST['txtApellidoP'])) ? $_POST['txtApellidoP'] : "";
    $txtApellidoM=(isset($_POST['txtApellidoM'])) ? $_POST['txtApellidoM'] : "";
    $txtCorreo=(isset($_POST['txtCorreo'])) ? $_POST['txtCorreo'] : "";
    $txtFoto=(isset($_FILES['txtFoto']['name'])) ? $_FILES['txtFoto']['name'] : "";

    $accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";
    $error = array();
    $accionAgregar = "";
    $accionModificar = $accionEliminar = $accionCancelar = "disabled";
    $mostrarModal = false;

    include ("../Conexion/conexion.php");
    switch($accion)
    {
        case "btnAgregar":

            if($txtNombre == "") {
                $error['nombre'] = "Escribe el nombre";
            }

            if($txtApellidoP == "") {
                $error['apellidop'] = "Escribe el apellido paterno";
            }

            if(count($error) > 0) {
                $mostrarModal = true;
                break;
            }
            $sentencia=$pdo->prepare("INSERT INTO empleados(nombre,apellidop,apellidom,correo,foto) VALUES (:nombre,:apellidop,:apellidom,:correo,:foto)");
            $sentencia->bindParam(':nombre',$txtNombre);
            $sentencia->bindParam(':apellidop',$txtApellidoP);
            $sentencia->bindParam(':apellidom',$txtApellidoM);
            $sentencia->bindParam(':correo',$txtCorreo);
            
            $fecha = new DateTime();
            $nombreArchivo = ($txtFoto != "") ? $fecha->getTimestamp()."_".$_FILES['txtFoto']['name'] : "imagen.jpg";
            //$sentencia->bindParam(':foto',$txtFoto);
            $tmpFoto = $_FILES['txtFoto']['tmp_name'];
            if($tmpFoto != "")
            {
                move_uploaded_file($tmpFoto, "../imagenes/".$nombreArchivo);
            }
            $sentencia->bindParam(':foto', $nombreArchivo);
            $sentencia->execute();
            header('Location: index.php');
            break;
        case "btnModificar":
            $sentencia=$pdo->prepare("UPDATE empleados SET nombre=:nombre, apellidop=:apellidop, apellidom=:apellidom, correo=:correo WHERE id=:id");
            $sentencia->bindParam(':nombre',$txtNombre);
            $sentencia->bindParam(':apellidop',$txtApellidoP);
            $sentencia->bindParam(':apellidom',$txtApellidoM);
            $sentencia->bindParam(':correo',$txtCorreo);
            $sentencia->bindParam(':id',$txtID);
            $sentencia->execute();

            $fecha = new DateTime();
            $nombreArchivo = ($txtFoto != "") ? $fecha->getTimestamp()."_".$_FILES['txtFoto']['name'] : "imagen.jpg";
            //$sentencia->bindParam(':foto',$txtFoto);
            $tmpFoto = $_FILES['txtFoto']['tmp_name'];
            if($tmpFoto != "")
            {
                move_uploaded_file($tmpFoto, "../imagenes/".$nombreArchivo);

                $sentencia = $pdo->prepare("SELECT foto FROM empleados WHERE id=:id");
                $sentencia->bindParam(':id', $txtID);
                $sentencia->execute();
                $empleado = $sentencia->fetch(PDO::FETCH_LAZY);
                print_r($empleado);
                if(isset($empleado["foto"]))
                {
                    if(file_exists("../imagenes/".$empleado["foto"]))
                    {
                        if($item ['foto']!= "imagen.jpg")
                        {
                            unlink("../imagenes/".$empleado["foto"]);
                        }
                    }
                }

                $sentencia = $pdo->prepare("UPDATE empleados SET foto=:foto WHERE id=:id");
                $sentencia->bindParam(':foto', $nombreArchivo);
                $sentencia->bindParam(':id', $txtID);
                $sentencia->execute();
            }

            header('Location: index.php');
            echo $txtID;
            echo "Presionaste btnModificar"; 
            break;
        case "btnEliminar":
            $sentencia = $pdo->prepare("SELECT foto FROM empleados WHERE id=:id");
            $sentencia->bindParam(':id', $txtID);
            $sentencia->execute();
            $empleado = $sentencia->fetch(PDO::FETCH_LAZY);
            print_r($empleado);
            if(isset($empleado["foto"]) && ($item['foto'] != "imagen.jpg"))
            {
                if(file_exists("../imagenes/".$empleado["foto"]))
                {
                    unlink("../imagenes/".$empleado["foto"]);
                }
            }

            $sentencia=$pdo->prepare("DELETE FROM empleados WHERE id=:id");
            $sentencia->bindParam(':id',$txtID);
            $sentencia->execute();
            header('Location: index.php');
            echo $txtID;
            echo "Presionaste btnEliminar"; 
            break;
        case "btnCancelar":
            header('Location: index.php');
            break;
        case "Seleccionar":
            $accionAgregar = "disabled";
            $accionModificar = $accionEliminar = $accionCancelar = "";
            $mostrarModal = true;

            $sentencia = $pdo -> prepare("SELECT * FROM empleados WHERE id=:id");
            $sentencia -> bindParam(':id', $txtID);
            $sentencia -> execute();
            $empleado = $sentencia -> fetch(PDO::FETCH_LAZY);

            $txtNombre = $empleado ['nombre'];
            $txtApellidoP = $empleado ['apellidop'];
            $txtApellidoM = $empleado ['apellidom'];
            $txtCorreo = $empleado ['correo'];
            $txtFoto = $empleado ['foto'];
            break;
    }

    $sentencia = $pdo->prepare("SELECT * FROM empleados");
    $sentencia->execute();
    $listaEmpleados=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    //print_r($listaEmpleados);
?>