<?php 

 	 $servidorsispes = "172.17.6.2";
      $usuariosispes  = "barbosa_desenv" ;
      $senhasispes    = "B@rbosa4" ;
      $bancosispes    = "sispes" ;  


                  $conexaosispes =  mysqli_connect($servidorsispes,$usuariosispes,$senhasispes,$bancosispes) or trigger_error(mysqli_error(),E_USER_ERROR);	
                  $sql = "SELECT * FROM vw_sismatbel where rg = '48081'" ;
                  $result = mysqli_query($conexaosispes,$sql) or die("Erro no banco de dados!"); 
                  print_r(mysqli_fetch_array($result));       
           
  
       
        ?>