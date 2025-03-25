

<?php 
include('filter.php');
if(!empty($data)){?>


<div class="_2JyLbpIPgPwI6RhYP28lbl mb-5">
   <div class="_12e1_3IHEVbMTMaTUzZ7r9">
      <table role="table">
         <thead>
            <tr role="row">
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Date<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Offer<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Geography / IP<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Device<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Status<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Income<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Sub1<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Sub2<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Sub3<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Sub4<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Sub5<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Sub6<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">UserAgent<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">ID<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">ID Offers<span></span></th>
            </tr>
         </thead>
         <tbody role="rowgroup">
         <?php
            if(!empty($data)){
               foreach($data as $data){
                  if($data->status==1){
                     $status = '<div class="_1zXei-ymiJr9KAeJboeM6O _1pdGDkt2C-GSflNRE9HkEM _3ZpPE5ZwvUy6QGtl56rIQ6 _1_0OCKKJH6gPamSl7zmIss">Approved</div>';
                  }elseif($data->status==2){
                     $status = '<div style="background-color:#ffc107" class="_1zXei-ymiJr9KAeJboeM6O _1pdGDkt2C-GSflNRE9HkEM _3ZpPE5ZwvUy6QGtl56rIQ6 _1_0OCKKJH6gPamSl7zmIss">Declined</div>';
                  }elseif($data->status==3){
                     $status = '<div style="background-color:#5bc0de" class="_1zXei-ymiJr9KAeJboeM6O _1pdGDkt2C-GSflNRE9HkEM _3ZpPE5ZwvUy6QGtl56rIQ6 _1_0OCKKJH6gPamSl7zmIss">Pay</div>';
                  }
                  echo '
                  <tr role="row" class="">
                  <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>'.date('Y-m-d H:i:s',strtotime($data->date)).'</span></span></td>
                  <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>'.$data->smatlink_name.'</span></span></td>
                  <td role="cell">
                     <span class="_1zXei-ymiJr9KAeJboeM6O _1YEl4yCJEz0C3EFWAe9CjL _12Q8g8DFKS_2KPGPVMUHyl">
                        <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.3/flags/4x3/'.strtolower($data->countries).'.svg" style="display: inline-block; width: 1em; height: 1em; vertical-align: middle;">
                     <span class="_1WOmcSS9N_e3KUkqfV0NI">'.$data->cities.' '.$data->ip.'</span></span>
                  </td>
                  <td role="cell">
                     <span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI _12Q8g8DFKS_2KPGPVMUHyl">
                        <span>
                           '.$data->device_type.' '.$data->device_model.' ('.$data->browser.')
                        </span>
                     </span>
                  </td>
                  <td role="cell">
                     '.$status.'
                  </td>
                  <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>'.$data->amount2.' USD</span></span></td>
                  <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>'.$data->s1.'</span></span></td>
                  <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>'.$data->s2.'</span></span></td>
                  <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>'.$data->s3.'</span></span></td>
                  <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>'.$data->s4.'</span></span></td>
                  <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>'.$data->s5.'</span></span></td>
                  <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>'.$data->s6.'</span></span></td>
                  <td role="cell">
                     <span class="_1zXei-ymiJr9KAeJboeM6O _3ZpPE5ZwvUy6QGtl56rIQ6" data-bs-toggle="tooltip" title="'.$data->useragent.'">
                        <p data-tip="Mozilla/5.0 (Windows NT 6.0; rv:45.0) Gecko/20100101 Firefox/45.0" currentitem="false">
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                              <circle cx="12" cy="12" r="10"></circle>
                              <line x1="12" y1="16" x2="12" y2="12"></line>
                              <line x1="12" y1="8" x2="12.01" y2="8"></line>
                           </svg>
                        </p>
                     </span>
                  </td>
                  <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>'.$data->id.'</span></span></td>
                  <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>'.$data->offerid.'</span></span></td>
               </tr>
                  
                  ';
               }
            }
         ?>

            
            

         </tbody>
         <tfoot>
            <tr>
               <td colspan="1">&nbsp;</td>
               <td colspan="1">&nbsp;</td>
               <td colspan="1">&nbsp;</td>
               <td colspan="1">&nbsp;</td>
               <td colspan="1">&nbsp;</td>
               <td colspan="1">&nbsp;</td>
               <td colspan="1">&nbsp;</td>
               <td colspan="1">&nbsp;</td>
               <td colspan="1">&nbsp;</td>
               <td colspan="1">&nbsp;</td>
               <td colspan="1">&nbsp;</td>
               <td colspan="1">&nbsp;</td>
               <td colspan="1">&nbsp;</td>
               <td colspan="1">&nbsp;</td>
               <td colspan="1">&nbsp;</td>
               <td colspan="1">&nbsp;</td>
               <td colspan="1">&nbsp;</td>
               <td colspan="1">&nbsp;</td>
            </tr>
         </tfoot>
      </table>

      <div class="col-md-6 mt-2 pull-right">
         <ul class=" pagination pagination-sm">                       
            <?php echo $this->pagination->create_links();?>     
         </ul>
      </div>
   </div>
</div>

<?php }else{
   echo '
   <div clas="col-12 d-flex">
   <div class="sc-hMFtBS JjGPM mt-3"><p class="sc-cLQEGU fdNgUv">There are no stats data</p><svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=""><path d="M22.61 16.95A5 5 0 0 0 18 10h-1.26a8 8 0 0 0-7.05-6M5 5a8 8 0 0 0 4 15h9a5 5 0 0 0 1.7-.3"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg></div>
   </div>
   ';
}?>

<script>
   $(document).ready(function(){
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
      })

   })

</script>