<div class="col-sm-1 col-xs-1 col-md-2 menuleft">
   <ul class="nav nav-pills nav-stacked main-menu">
      <li role="presentation">
         <a href="<?php echo base_url($this->config->item('manager'));?>">
         <span class="glyphicon glyphicon-home"></span>
         <span class="hidden-xs hidden-sm">Home</span>
         </a>
      </li>
       <li>
        <a href="<?php echo base_url($this->config->item('manager').'/showev/report/list');?>">
            <span class="glyphicon glyphicon-search"></span>
            <span class="hidden-xs hidden-sm">Offer Report</span>
        </a>
    </li>
    <li>
        <a href="<?php echo base_url('proxy_report');?>">
            <span class="glyphicon glyphicon-zoom-in"></span>
            <span class="hidden-xs hidden-sm">Conversion Report</span>
        </a>
    </li>
      <li>
         <a href="<?php echo base_url($this->config->item('manager').'/affiliate');?>">
         <span class="glyphicon glyphicon-user"></span>
         <span class="hidden-xs hidden-sm">Affiliate</span>
         </a>
      </li>
   
      <li>
         <a href="<?php echo base_url($this->config->item('manager').'/offers/listoffer');?>">
         <span class="glyphicon glyphicon-gift"></span>
         <span class="hidden-xs hidden-sm">Offer</span>
         </a>
      </li>
      
    
         
       <li>
         <a href="<?php echo base_url($this->config->item('manager').'/offersrequest/orlist');?>">
         <span class="glyphicon glyphicon-eye-open"></span>
         <span class="hidden-xs hidden-sm">Pending offer rq</span>
         </a>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('manager').'/invoice/invoicedt/');?>">
         <span class="glyphicon glyphicon-gbp"></span>
         <span class="hidden-xs hidden-sm">Invoice</span>
         </a>
      </li>
     
     
      <li>
         <a href="<?php echo base_url($this->config->item('manager').'/offers/smartlinks');?>">
         <span class="glyphicon glyphicon-refresh"></span>
         <span class="hidden-xs hidden-sm">Smartlink</span>
         </a>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('manager').'/offers/smartoffers');?>">
         <span class="glyphicon glyphicon-phone"></span>
         <span class="hidden-xs hidden-sm">SmartOffer</span>
         </a>
      </li>
      <li>
      <li>
         <a href="<?php echo base_url($this->config->item('manager').'/emailtool');?>">
         <span class="glyphicon glyphicon-envelope"></span>
         <span class="hidden-xs hidden-sm">Email Tool</span>
         </a>
      </li>
         <li>
         <a href="<?php echo base_url($this->config->item('manager').'/offers/pubcap');?>">
         <span class="glyphicon glyphicon-certificate"></span>
         <span class="hidden-xs hidden-sm">Capped- Pub</span>
         </a>
      </li>
      <li>
            <a href="<?php echo base_url($this->config->item('manager').'/route/sub2cap/list');?>">
            <span class="glyphicon glyphicon-certificate"></span>
            <span class="hidden-xs hidden-sm">Capped Sub2cap</span>
            </a>
        </li>
        <li>
         <a href="<?php echo base_url($this->config->item('manager').'/route/domainrefblacklist/list');?>">
         <span class="glyphicon glyphicon-certificate"></span>
         <span class="hidden-xs hidden-sm">Domain Referal Blacklist</span>
         </a>
      </li>
   </ul>
</div>
