<div class="_3vMlZCRTDMcko6fQUVb1Uf css-1qvl0ud css-y2hsyn tabcontent api-key">
   <div class="sc-keFjpB lhMHlV">
      <form class="sc-jWojfa dlRYFl">
         <div class="_3WCfA5WYRlXEJAXoSGLCJM">
            <span class="_2emChIs6yt79MK9bxuriDh">API-key</span>
            <input disabled="" placeholder="Api-Key" id="Api-Key" type="text" class="_1Yox25pgA6Bt9-R0uIDpcS _2U8LClDsGTjhEIQtswl0q7 _2WJImvbnE8I3_hccXYSMQ css-4s204c" 
            value="<?php echo $this->member->api_key;?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="_2ZTo9--SzlVupN_LAvBNdo css-gyuu5p">
               <path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path>
            </svg>
         </div>
         <div>
            <button type="submit" id="resetApikey" class="K3TX2EnGEDIGIEiEIo_0X _3-Xcfgk4YnBeM0kgvmZfs_ css-ssqfmv">
               <div class="_3kiCWIsiMrRqCXneU8Asq6" style="height: 0px; width: 0px; left: 0px; top: 0px;"></div>
               <span class="_3axrJUuPR6Tfk-J1aQF4dm">Regenerate API-key</span>
              
            </button>
         </div>
      </form>
      <br>
      API URL: <?php echo base_url('3.0/offers?API-Key='.$this->member->api_key);?>
      <br>
      <a href="https://api.affise.com/docs3.1/">Api Document</a>
      
    
   </div>
</div>