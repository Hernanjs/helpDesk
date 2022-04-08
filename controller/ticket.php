
<?php
    require_once("../config/conexion.php");
    require_once("../models/Ticket.php");
    $ticket = new Ticket();

    switch($_GET["op"]){
        case "insert":
          $ticket->insert_ticket($_POST["usu_id"],$_POST["cat_id"],$_POST["ticket_titulo"],$_POST["ticket_descrip"]);
        break;

        case "update":
          $ticket->update_ticket($_POST["ticket_id"]);
          $ticket->insert_ticketdetalle_cerrar($_POST["ticket_id"],$_POST["usu_id"]);

        break;

        case "listar_x_usu";
        $datos=$ticket->listar_ticket_x_usu($_POST["usu_id"]);
        $data= Array();
        foreach($datos as $row){
              $sub_array = array();
              $sub_array[]=$row["ticket_id"];
              $sub_array[]=$row["cat_nombre"];
              $sub_array[]=$row["ticket_titulo"];
              
              if($row["ticket_estado"]=="abierto"){
                $sub_array[]= '<span class="label label-pill label-success">Abierto</span>';


              }else{
                $sub_array[]= '<span class="label label-pill label-danger">Cerrado</span>';
                  
              };

              $sub_array[]=date("d/m/Y H:i:s",strtotime($row["fech_crea"]));
              
              $sub_array[] = '<button type="button" onClick="ver('.$row["ticket_id"].');"  id="'.$row["ticket_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
              $data[] = $sub_array;

        }

        $results = array(
            "sEcho"=>1,
            "iTotalRecords"=>count($data),
            "iTotalDisplayRecords"=>count($data),
            "aaData"=>$data);
        echo json_encode($results);

        break;





        case "listar";
        $datos=$ticket->listar_ticket();
        $data= Array();
        foreach($datos as $row){
              $sub_array = array();
              $sub_array[]=$row["ticket_id"];
              $sub_array[]=$row["cat_nombre"];
              $sub_array[]=$row["ticket_titulo"];
                
              if($row["ticket_estado"]=="abierto"){
                $sub_array[]= '<span class="label label-pill label-success">Abierto</span>';


              }else{
                $sub_array[]= '<span class="label label-pill label-danger">Cerrado</span>';
                  
              };

              $sub_array[]=date("d/m/Y H:i:s",strtotime($row["fech_crea"]));
              
              $sub_array[] = '<button type="button" onClick="ver('.$row["ticket_id"].');"  id="'.$row["ticket_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
              $data[] = $sub_array;

        }

        $results = array(
            "sEcho"=>1,
            "iTotalRecords"=>count($data),
            "iTotalDisplayRecords"=>count($data),
            "aaData"=>$data);
        echo json_encode($results);

        break;
       

        case "listardetalle":
          $datos=$ticket->listar_ticketdetalle_x_ticket($_POST["ticket_id"]);

          ?>
              <?php

                 foreach($datos as $row){
                      ?>
          <article class="activity-line-item box-typical">
					<div class="activity-line-date">
						<?php echo date("d/m/Y", strtotime($row["fech_crea"]));?>
					</div>
					<header class="activity-line-item-header">
						<div class="activity-line-item-user">
							<div class="activity-line-item-user-photo">
								<a href="#">
									<img src="../../public/<?php echo $row['rol_id']?>.jpg" alt="">
								</a>
							</div>
							<div class="activity-line-item-user-name"><?php echo $row['usu_nombre'].' '.$row['usu_apellido'];?></div>
							<div class="activity-line-item-user-status">
                  <?php 

                    if($row['rol_id']==1){
                           echo 'Usuario';
                    }else{
                      echo 'Soporte';
                           
                    }
              
                  ?>
                </div>
						</div>
					</header>
					<div class="activity-line-action-list">
						<section class="activity-line-action">
						<?php echo date("H i:s", strtotime($row["fech_crea"]));?>
							<div class="time"> </div>
							<div class="cont">
								<div class="cont-in">
									<p>
						<?php echo ($row["ticketd_descrip"]);?>
                      
                  </p>
									<ul class="meta">
										
									</ul>
								</div>
							</div>
						</section>
					</div><!--.activity-line-action-list-->
				</article>
                          

                       <?php
                  }
              ?>    

            <?php

      break;

      case "mostrar";
            $datos=$ticket->listar_ticket_x_id($_POST["ticket_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["ticket_id"] = $row["ticket_id"];
                    $output["usu_id"] = $row["usu_id"];
                    $output["cat_id"] = $row["cat_id"];
                    $output["ticket_titulo"] = $row["ticket_titulo"];
                    $output["ticket_descrip"] = $row["ticket_descrip"];

                    if ($row["ticket_estado"]=="abierto"){
                        $output["ticket_estado"] = '<span class="label label-pill label-success">Abierto</span>';
                  }else{
                      $output["ticket_estado"] = '<span class="label label-pill label-danger">Cerrado</span>';
                  }
                  $output["ticket_estado_texto"] = $row["ticket_estado"];
                    

                    $output["fech_crea"] = date("d/m/y H:i:s",strtotime($row["fech_crea"]));
                    $output["usu_nombre"] = $row["usu_nombre"];
                    $output["usu_apellido"] = $row["usu_apellido"];
                    $output["cat_nombre"] = $row["cat_nombre"];
                }
                echo json_encode($output);
            }   
        break;


        case "insertdetalle":
          $ticket->insert_ticketdetalle($_POST["ticket_id"],$_POST["usu_id"],$_POST["ticketd_descrip"]);
        break;

        case "total";
        $datos=$ticket->get_ticket_total(); 
       if(is_array($datos)==true and count($datos)>0){
            foreach($datos as $row)
            {
                $output["TOTAL"] = $row["TOTAL"];
            }
            echo json_encode($output);
        }
        break;


        case "totalabierto";
        $datos=$ticket->get_ticket_totalabierto(); 
       if(is_array($datos)==true and count($datos)>0){
            foreach($datos as $row)
            {
                $output["TOTAL"] = $row["TOTAL"];
            }
            echo json_encode($output);
        }
        break;

        case "totalcerrado";
        $datos=$ticket->get_ticket_totalcerrado(); 
       if(is_array($datos)==true and count($datos)>0){
            foreach($datos as $row)
            {
                $output["TOTAL"] = $row["TOTAL"];
            }
            echo json_encode($output);
        }
        break;

        case "grafico";
        $datos=$ticket->get_ticket_grafico();
        echo json_encode($datos);
        break;

        

    }
    
?>