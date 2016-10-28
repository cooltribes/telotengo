/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function changeFilter(e){

   var column = $(this);
   
   var fecha = ['create_at'];
   var opciones = ['algo'];
   var texto = [ 'nombre', 'email', 'empresa', 'nombreInvitado', 'emailQuienInvita'];
    
       
   //si es fecha
   if(fecha.indexOf(column.val()) != -1) //Fechas
   {
       dateFilter(column);
    
   }else if(opciones.indexOf(column.val()) != -1) //Estado del usuario, tipo usuario, fuenteRegistro
   {       
       
       listFilter(column, column.val());
        

   }else if(texto.indexOf(column.val()) != -1) 
   {
       textFilter(column);       
        
   }else //campo normal (numérico)
   {      
      valueFilter(column);       
      
   }
    
}