<style>

    .carouselBrands .carousel-control .glyphicon{
        line-height: 60px;
        position: relative;
        vertical-align: middle;
        top: 0;
        right: 0;
        left: 0;
        bottom: 0;
        
    }

    
    .carouselBrands .carousel-control{
            position: absolute;
            top: 15px;
            width: 30px;
            height: 60px;
            font-size: 20px;
            color: #555;
            text-align: center;
            text-shadow: 0px;

            background: transparent;
            
            
    }
    .carouselBrands .carousel-control .arrow{
        display: inline-block;
        margin-top: -8px;
        font-size: 45px;
        font-weight: lighter;
        font-family: Arial, Helvetica, sans-serif;
   }
   .carouselBrands .carousel-control.left{
        left:-20px;
   }
   
   .carouselBrands .carousel-control.right{
        right:-20px;
   }
    
</style>


<script>
$(document).ready(function () {
$('#carouselBrands1').carousel({
   interval: 200000
});


//$('.carousel').carousel('cycle');
});  
</script>

<div id="carouselBrands1" class="carousel slide carouselBrands margin_top">
               <!-- Carousel indicators -->
          
               <!-- Carousel items -->
               <div class="carousel-inner row-fluid">
                   
                    <div class="item active">
                     <?php for($i=0; $i<6; $i++): ?>   
                        <div class="col-md-2">
                          <a href="#">
                              <img src="http://placehold.it/130x80" width="100%" />
                          </a>  
                        </div>
                     
                     <?php endfor; ?>
                    </div>
                    <div class="item">
                     <?php for($i=0; $i<6; $i++): ?>   
                        <div class="col-md-2">
                          <a>
                              <img src="http://placehold.it/130x80" width="100%" />
                          </a>  
                        </div>
                     
                     <?php endfor; ?>
                    </div>
                    
                </div> 
           
               
               <!-- Carousel nav -->
               
                <a class="carousel-control left" href="#carouselBrands1" 
                  data-slide="prev"><span class="arrow">‹</span></a>
               <a class="carousel-control right" href="#carouselBrands1" 
                  data-slide="next"><span class="arrow">›</span></a>

            </div>