<div class="col-sm-1 col-xs-1 col-md-2 menuleft">
   <ul class="nav nav-pills nav-stacked main-menu">
      <li role="presentation">
         <a href="<?php echo base_url($this->config->item('manager'));?>">
         <span class="glyphicon glyphicon-home"></span>
         <span class="hidden-xs hidden-sm">Home</span>
         </a>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('manager').'/users');?>">
         <span class="glyphicon glyphicon-user"></span>
         <span class="hidden-xs hidden-sm">Users</span>
         </a>
      </li>
      <li role="presentation">
         <a href="#" class="dropmenu">
         <span class="glyphicon glyphicon-flash"></span>
         <span class="hidden-xs hidden-sm">Advertisers</span>
         </a>
         <ul>
            <li>
               <a href="<?php echo base_url($this->config->item('manager').'/route/network/list');?>">
               <span class="glyphicon glyphicon-inbox"></span>
               <span class="hidden-xs hidden-sm">Network</span>
               </a>
            </li>
            <li>
               <a href="<?php echo base_url($this->config->item('manager').'/route/offer/list');?>">
               <span class="glyphicon glyphicon-gift"></span>
               <span class="hidden-xs hidden-sm">Offer</span>
               </a>
            </li>
         </ul>
      </li>
      <li>
         <a href="#" class="dropmenu">
         <span class="glyphicon glyphicon-compressed"></span>
         <span class="hidden-xs hidden-sm">Offer tool</span>
         </a>
         <ul>
            <li>
               <a href="<?php echo base_url($this->config->item('manager').'/route/country/list');?>">
               <span class="glyphicon glyphicon-globe"></span>
               <span class="hidden-xs hidden-sm">Country</span>
               </a>
            </li>
            <li>
               <a href="<?php echo base_url($this->config->item('manager').'/route/offertype/list');?>">
               <span class="glyphicon glyphicon-sound-dolby"></span>
               <span class="hidden-xs hidden-sm">Offer type</span>
               </a>
            </li>
             <li>
               <a href="<?php echo base_url($this->config->item('manager').'/route/offercat/list');?>">
               <span class="glyphicon glyphicon-list-alt"></span>
               <span class="hidden-xs hidden-sm">Offer Categories</span>
               </a>
            </li>
             <li>
               <a href="<?php echo base_url($this->config->item('manager').'/showev/groupcat/list');?>">
               <span class="glyphicon glyphicon-list-alt"></span>
               <span class="hidden-xs hidden-sm">Group Categories</span>
               </a>
            </li>
         </ul>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('manager').'/route/manager/list');?>">
         <span class="glyphicon glyphicon-phone-alt"></span>
         <span class="hidden-xs hidden-sm">Manager</span>
         </a>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('manager').'/route/payment/list');?>">
         <span class="glyphicon glyphicon-folder-open"></span>
         <span class="hidden-xs hidden-sm">Payout History</span>
         </a>
      </li>
   </ul>
</div>
