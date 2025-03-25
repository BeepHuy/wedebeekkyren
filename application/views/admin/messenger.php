  <?php 
            if(!empty($error)){
                echo '                
                <div class="error relative">
                    <div class="error_mess messcontent">
                    '.$error.'
                    </div>
                    <span class="close"></span>
                </div>
                ';
            }
            
            if(!empty($success)){
               echo '
                <div class="succ relative">
                        <div class="succ_mess messcontent">
                        '.$success.'
                        </div>
                        <span class="close"></span>
                    </div>
               ' ;
            }
            
            if(!empty($warrning)){
                echo '
                    <div class="war relative">
                        <div class="war_mess messcontent">
                        '.$warrning.'
                        </div>
                        <span class="close"></span>
                    </div>
                ';
            }
            
            ?>