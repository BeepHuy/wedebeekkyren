<div class="col-sm-1 col-xs-1 col-md-2 menuleft">
   <ul class="nav nav-pills nav-stacked main-menu">
      <li role="presentation">
         <a href="<?php echo base_url($this->config->item('admin'));?>">
         <span class="glyphicon glyphicon-home"></span>
         <span class="hidden-xs hidden-sm">Home</span>
         </a>
      </li>
       <li>
        <a href="<?php echo base_url($this->config->item('admin').'/showev/report/list');?>">
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
        <a href="<?php echo base_url('ipreport/show');?>">
            <span class="glyphicon glyphicon-zoom-in"></span>
            <span class="hidden-xs hidden-sm">Click report</span>
        </a>
    </li>
      <li>
         <a href="<?php echo base_url($this->config->item('admin').'/route/users/list');?>">
         <span class="glyphicon glyphicon-user"></span>
         <span class="hidden-xs hidden-sm">Affiliate</span>
         </a>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('admin').'/route/network/list');?>">
         <span class="glyphicon glyphicon-inbox"></span>
         <span class="hidden-xs hidden-sm">Network</span>
         </a>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('admin').'/offers/listoffer');?>">
         <span class="glyphicon glyphicon-gift"></span>
         <span class="hidden-xs hidden-sm">Offer</span>
         </a>
      </li>
      <!--li>
         <a href="#" class="dropmenu">
         <span class="glyphicon glyphicon-compressed"></span>
         <span class="hidden-xs hidden-sm">Data Khách Hàng</span>
         </a>
         <ul>
            <li>
            <a href="<?php echo base_url($this->config->item('admin').'/route/campaign/list');?>">
               <span class=" glyphicon glyphicon-remove"></span>
               <span class="hidden-xs hidden-sm">Campaign </span>
               </a>
            </li>
            <li>
               <a href="<?php echo base_url('/khachhang/index');?>">
               <span class="glyphicon glyphicon-globe"></span>
               <span class="hidden-xs hidden-sm">Data</span>
               </a>
            </li>  
         </ul>
      </li-->
      <li>
         <a href="#" class="dropmenu">
         <span class="glyphicon glyphicon-compressed"></span>
         <span class="hidden-xs hidden-sm">Offer tool</span>
         </a>
         <ul>
            <li>
                  <a href="<?php echo base_url($this->config->item('admin').'/route/traftype/list');?>">
                  <span class=" glyphicon glyphicon-remove"></span>
                  <span class="hidden-xs hidden-sm">Trafic Type </span>
                  </a>
            </li>
            <li>
               <a href="<?php echo base_url($this->config->item('admin').'/route/disoffer/list');?>">
               <span class=" glyphicon glyphicon-remove"></span>
               <span class="hidden-xs hidden-sm">Disabled/Enable </span>
               </a>
            </li>
            <li>
               <a href="<?php echo base_url($this->config->item('admin').'/route/country/list');?>">
               <span class="glyphicon glyphicon-globe"></span>
               <span class="hidden-xs hidden-sm">Country</span>
               </a>
            </li>
            <li>
               <a href="<?php echo base_url($this->config->item('admin').'/route/device/list');?>">
               <span class="glyphicon glyphicon-inbox"></span>
               <span class="hidden-xs hidden-sm">Device</span>
               </a>
            </li>
            <li>
               <a href="<?php echo base_url($this->config->item('admin').'/route/offertype/list');?>">
               <span class="glyphicon glyphicon-sound-dolby"></span>
               <span class="hidden-xs hidden-sm">Offer type</span>
               </a>
            </li>
             <li>
               <a href="<?php echo base_url($this->config->item('admin').'/route/offercat/list');?>">
               <span class="glyphicon glyphicon-list-alt"></span>
               <span class="hidden-xs hidden-sm">Offer Categories</span>
               </a>
            </li>
             <li>
               <a href="<?php echo base_url($this->config->item('admin').'/route/paymterm/list');?>">
               <span class="glyphicon glyphicon-usd"></span>
               <span class="hidden-xs hidden-sm">Payment term</span>
               </a>
            </li>
         </ul>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('admin').'/route/manager/list');?>">
         <span class="glyphicon glyphicon-phone-alt"></span>
         <span class="hidden-xs hidden-sm">Manager</span>
         </a>
      </li>      
       <li>
         <a href="<?php echo base_url($this->config->item('admin').'/offersrequest/orlist');?>">
         <span class="glyphicon glyphicon-eye-open"></span>
         <span class="hidden-xs hidden-sm">Pending offer rq</span>
         </a>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('admin').'/invoice/invoicedt/');?>">
         <span class="glyphicon glyphicon-gbp"></span>
         <span class="hidden-xs hidden-sm">Invoice</span>
         </a>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('admin').'/emailtool');?>">
         <span class="glyphicon glyphicon-envelope"></span>
         <span class="hidden-xs hidden-sm">Email Tool</span>
         </a>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('admin').'/resetip/');?>">
         <span class="glyphicon glyphicon-refresh"></span>
         <span class="hidden-xs hidden-sm">Reset Ip</span>
         </a>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('admin').'/offers/smartlinks');?>">
         <span class="glyphicon glyphicon-screenshot"></span>
         <span class="hidden-xs hidden-sm">Smartlink</span>
         </a>
      </li>
      <li>
      <a href="<?php echo base_url($this->config->item('admin').'/offers/smartoffers');?>">
         <span class="glyphicon glyphicon-phone"></span>
         <span class="hidden-xs hidden-sm">SmartOffer</span>
         </a>
      </li>
      <li>
      <a href="<?php echo base_url($this->config->item('admin').'/route/content/list');?>">
         <span class="glyphicon glyphicon-folder-open"></span>
         <span class="hidden-xs hidden-sm">News</span>
         </a>
      </li>
      <li>
      <a href="<?php echo base_url($this->config->item('admin').'/route/contact/list');?>">
         <span class="glyphicon glyphicon-comment"></span>
         <span class="hidden-xs hidden-sm">Contact</span>
         </a>
      </li>
      <li>
      <a href="<?php echo base_url($this->config->item('admin').'/route/setting/edit/1');?>">
         <span class="glyphicon glyphicon-cog"></span>
         <span class="hidden-xs hidden-sm">Setting HomePage</span>
         </a>
      </li>
    <!--li>
         <a href="<?php echo base_url($this->config->item('admin').'/route/rrs/list');?>">
         <span class="glyphicon glyphicon-certificate"></span>
         <span class="hidden-xs hidden-sm">RRS</span>
         </a>
      </li-->
       <li>
         <a href="#" class="dropmenu">
         <span class="glyphicon glyphicon-compressed"></span>
         <span class="hidden-xs hidden-sm">Check Offers</span>
         </a>
         <ul>
            <li>
               <a href="<?php echo base_url($this->config->item('admin').'/route/network_source/list');?>">
               <span class=" glyphicon glyphicon-remove"></span>
               <span class="hidden-xs hidden-sm">Network Source</span>
               </a>
            </li>
            <li>
               <a href="<?php echo base_url($this->config->item('admin').'/route/log_check_offers/list');?>">
               <span class="glyphicon glyphicon-globe"></span>
               <span class="hidden-xs hidden-sm">log check</span>
               </a>
            </li>
            <li>
               <a href="https://wedebeek.com:3000/check_source">
               <span class="glyphicon glyphicon-certificate"></span>
               <span class="hidden-xs hidden-sm">Check Source</span>
               </a>
            </li>
           
         </ul>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('admin').'/offers/pubcap');?>">
         <span class="glyphicon glyphicon-certificate"></span>
         <span class="hidden-xs hidden-sm">Capped- Pub</span>
         </a>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('admin').'/route/sub2cap/list');?>">
         <span class="glyphicon glyphicon-certificate"></span>
         <span class="hidden-xs hidden-sm">Capped Sub2cap</span>
         </a>
      </li>
      <li>
         <a href="<?php echo base_url($this->config->item('admin').'/route/domainrefblacklist/list');?>">
         <span class="glyphicon glyphicon-certificate"></span>
         <span class="hidden-xs hidden-sm">Domain Referal Blacklist</span>
         </a>
      </li>
   </ul>
</div>
