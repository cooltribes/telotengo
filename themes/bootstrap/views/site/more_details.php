       <?php 
       /* foreach ($busqueda as $id => $value) 
        {
	        	
		    if($id!="_id" || $id=!"producto")
			{
				if(is_array($busqueda[$id]))
				{
					foreach($busqueda[$id] as $gente)
					{
					echo $gente."///////";
					}
				}
				else 
				{
					echo $busqueda[$id]."///////////////";
				}
			}
		}*/
		
		//$a = array('leg1'=>'LA', 'leg2'=>'NY', 'leg3'=>'NY', 'leg4'=>'FL');

        ?>

<table width="100%" class="detailTable margin_top">
                            <col width="15%">
                            <col width="35%"> 
                            <col width="15%">
                            <col width="35%">    
                        <?php
                        
                        $i=0;
                        foreach($busqueda as $id => $value) 
                        {?>
                             <?php
                            if($i==0 || ($i!=0 && $i%2==0 ))
							 {?>
							 	
							<tr>
							 <?php
							 }
							 ?>
							 	
	                            <td class="title">Lorem ipsum</td>
	                            <td  class=""> Nulla porta nisi et eros fermentum luctus. Donec id aliquet nisl. Curabitur quis sodales turpis. Vivamus id tortor nibh. Nulla facilisi. Praesent nibh lorem, sollicitudin malesuada viverra eu, venenatis ac purus.</td>
								<?php
								 ?>
								<td class="title">Lorem ipsum</td>
	                            <td  class=""> Nulla porta nisi et eros fermentum luctus. Donec id aliquet nisl. Curabitur quis sodales turpis. Vivamus id tortor nibh. Nulla facilisi. Praesent nibh lorem, sollicitudin malesuada viverra eu, venenatis ac purus.</td>

                       		                              <?php
                             if($i==0 || ($i!=0 && $i%2==0 ))
							 {?>
							</tr>
							 <?php
							 }
							// $i++;
                        }
						?>


                    </table>