
<?php 
include('filter.php');
if(!empty($data)){?>

<div class="_2JyLbpIPgPwI6RhYP28lbl">
   <div class="_12e1_3IHEVbMTMaTUzZ7r9">
      <table role="table">
         <thead>
            <tr role="row">
            <th colspan="1" role="columnheader">&nbsp;<span></span></th>
               <th colspan="1" role="columnheader">&nbsp;<span></span></th>
               <th colspan="2" role="columnheader">Traffic<span></span></th>
               <th colspan="1" role="columnheader">&nbsp;<span></span></th>
               <th colspan="4" role="columnheader">Conversions<span></span></th>               
               <th colspan="4" role="columnheader">Finances<span></span></th>
            </tr>
            <tr role="row">
            <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Id<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Smartoffers<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Hosts<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Hits<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Impressions<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">All<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Pending<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Declined<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Paid<span></span></th>
               
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Pending<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Declined<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Paid<span></span></th>
               <th colspan="1" role="columnheader" title="Toggle SortBy" style="cursor: pointer;">Total<span></span></th>
            </tr>
         </thead>
         <tbody role="rowgroup">
         <?php 
         $thosts = $tclick = $tlead = $treve=$tdec=0;
         $tmtotal= $tmpending=$tmdeclined= $tmpayed= 0;
         if($data){            
            foreach( $data as $data){
               $thosts +=$data->hosts;
               $tclick += $data->click;
               $tlead += $data->lead;
               $tdec +=$data->declined;
               $tapp +=$data->approved;
               $tpayed +=$data->payed;

               $tmtotal +=$data->mtotal;
               $tmpending +=$data->mpending;
               $tmdeclined +=$data->mdeclined;
               $tmpayed +=$data->mpayed;
               echo '
                  <tr role="row" class="">
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _1YEl4yCJEz0C3EFWAe9CjL"><span>'.$data->smartoff.'</span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _1YEl4yCJEz0C3EFWAe9CjL"><span>'.$data->oname.'</span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>'.$data->hosts.'</span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>'.$data->click.'</span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>0</span></span></td>
                     <td role="cell">
                        <div class="vfMk5_UxQXI9UPIwF1yqG  rpo">     
                           <a  href="'.base_url('/v2/statistics/conversions').'">                      
                              '.$data->lead.'          
                           </a>                
                        </div>
                     </td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI rpo"><span><a  href="'.base_url('/v2/statistics/conversions').'">   '.$data->approved.'</a></span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>'.$data->declined.'</span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>'.$data->payed.'</span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>$'.number_format(round($data->mpending,2),2).'</span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>$'.number_format(round($data->mdeclined,2),2).'</span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>$'.number_format(round($data->mpayed,2),2).'</span></span></td>
                     <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>$'.number_format(round($data->mtotal,2),2).'</span></span></td>
                     
                  </tr>
               ';
            }
         }?>
            
            
            

         </tbody>
         <tfoot>
            <tr>
            <td colspan="1">Total</td>
               <td colspan="1">&nbsp;</td>
               <td colspan="1"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?php echo $thosts;?></span></span></td>
               <td colspan="1"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?php echo $thosts;?></span></span></td>
               <td colspan="1"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>0</span></span></td>
               <td colspan="1">
                  <div class="vfMk5_UxQXI9UPIwF1yqG"><a class="_3HJFBHwnlFb4c_d31FZhBy _2WYuGVXe0FBr9Ni6eMd-pM" href="<?php echo base_url('/v2/statistics/smoffers_convert');?>"><?php echo $tlead;?></a></div>
               </td>
               <td colspan="1"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?php echo $tapp;?></span></span></td>
               <td colspan="1"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?php echo $tdec;?></span></span></td>
               <td colspan="1"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span><?php echo $tpayed;?></span></span></td>

               <td colspan="1"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>$<?php echo number_format(round($tmpending,2),2);?></span></span></td>
               <td colspan="1"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>$<?php echo number_format(round($tmdeclined,2),2);?></span></span></td>
               <td colspan="1"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>$<?php echo number_format(round($tmpayed,2),2);?></span></span></td>
               <td colspan="1"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>$<?php echo number_format(round($tmtotal,2),2);?></span></span></td>
                                                   
            </tr>
         </tfoot>
      </table>
   </div>
</div>

<?php }else{
   echo '
   <div clas="col-12 d-flex">
   <div class="sc-hMFtBS JjGPM mt-3"><p class="sc-cLQEGU fdNgUv">There are no stats data</p><svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=""><path d="M22.61 16.95A5 5 0 0 0 18 10h-1.26a8 8 0 0 0-7.05-6M5 5a8 8 0 0 0 4 15h9a5 5 0 0 0 1.7-.3"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg></div>
   </div>
   ';
}?><style>
.rpo a{color:#666}
</style>