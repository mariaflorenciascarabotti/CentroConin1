<?php 
    
    include "../conexion.php";

    if(!empty($_POST)){

        //Buscar Tutor
        if($_POST['action'] == 'searchTutor'){
            
           if(!empty($_POST['tutor'])){
            $dni = $_POST['tutor'];
            $query = mysqli_query($conn, "SELECT * FROM familia WHERE dni_tutor LIKE $dni");
            mysqli_close($conn);
            $result = mysqli_num_rows($query);

            $data = '';
            if($result > 0){
                $data = mysqli_fetch_assoc($query);
            }else{
                $data = 0;
            }
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
           }
           exit;
        }
        
        //Buscar producto
        if($_POST['action'] == 'infoProducto')
        {      
            $prod = $_POST['producto'];
           
            $query = mysqli_query($conn, "SELECT * FROM producto WHERE id_prod LIKE $prod");
           
            mysqli_close($conn);
           
            $result = mysqli_num_rows($query);

            if($result > 0){
                $data = mysqli_fetch_assoc($query);
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
                exit;
            }
            echo 'error';
            exit;
        }

         //Agregar producto
        if($_POST['action'] == 'addProdDetalle')
         {      
            if(empty($_POST['producto']) || empty($_POST['cantidad']) )
            {
                echo 'error';
            }else{
                $codProd = $_POST['producto'];
                $cantidad = $_POST['cantidad'];
                
                $query = mysqli_query($conn, "INSERT INTO prod_selecionados (id_prod, cantidad_selec) VALUES ($codProd, $cantidad)");
                mysqli_close($conn);
                exit;
                
            }
        };
 





    }
    exit;

?>
