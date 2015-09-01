<?php 

class MongoClass {
    	
		
		

    function getCollection($string)
    {
       $connection = new MongoClient();
	   return $connection->pruebas->$string;
	   
	   
    }
    
        
    

}
?>