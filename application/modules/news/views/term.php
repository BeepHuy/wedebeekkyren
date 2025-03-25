

<div class="row  mt-5">
    <?php
    if(!empty($article)){       
            echo '
            <div class="col-12 mt-2">
                <div name="white" class="p-3 shadow bg-body border rounded d-flex box-offers-items">
                    
                    <div class="box-offers-container">
                    <div class="box-offers-detail">
                    
                        <a class="box-offers-links" href="#"><h5>Terms And Conditions</h5></a>
                        <div class="box-offers-point mt-2 pt-2">
                        '.$article.'
                        </div>
                    </div>
                    
                    </div>
                </div>
            </div>
            
            ';
        
    }
    ?>
    

</div>