<script type="text/javascript">
   $(document).ready(function() {
  
   	$('#copy_button').click(function() {
        $('.chidden').show();
   		var clipboardValue = $('#json_link')[0].href;
   		var aux = document.createElement("input");
   		aux.setAttribute("value", clipboardValue);
   		document.body.appendChild(aux);
   		aux.select();
   		document.execCommand("copy");
   		document.body.removeChild(aux);
        $('.chidden').hide();
        $('.thongbao').text('Coppied !');
   	});
   	//updateFeedLink($("#pubkey_radio"));
   	
   });
</script>

<h4 class="mt-5">Api document</h4>
<div class="card my-3">
   <div class="card-header text-uppercase">
      API BASICS
   </div>
   <div class="card-body">
      <style>
         .bdl a{
         text-decoration:none;
         }
         .bdl{
         display: inline-block; border: 1px solid #0dcaf0; border-radius:5px; padding:5px; background-color: white;
         }
         .card-body p{margin-bottom:2px;font-weight:bold}
      </style>
      <p class="mt-2">API URL:</p>
      <?php
      
         $pubkey = md5('wdb-'.$this->member->id);
         $aplink = base_url('api/offer_feed_json?user_id='.$this->member->id.'&pubkey='.$pubkey);
         ?>
      <div class="bdl">
         <a id="json_link" target="_blank" href="<?php echo $aplink;?>">
         <?php echo $aplink;?></a>
      </div>
       
      <button type="button" id="copy_button" class="btn btn-info dblueB btn-sm">Copy Link</button>
      <div class="spinner-border text-primary chidden spinner-border-sm" role="status" style="display:none">
            <span class="visually-hidden">Coppying...</span>
      </div>
      <span class="thongbao text-success"></span>
      <br/>
      <p class="mt-2"> Sample Call:</p>
      <span style="color:green">
      This is a sample call of the Offer Category IDs API. The URL will return a listing of Category IDs.
      <br/>
      JSON:<b> <?php echo $aplink;?>&action=offers_cats&format=json</b>
      </span>
   </div>
</div>
<div class="card my-3">
   <div class="card-header text-uppercase">
      Offer Category IDs
   </div>
   <div class="card-body">
      <p>This action will return a listing of Category IDs that can be used in conjunction with the "cat" parameter on the offers API.
      </p>
      <table class="table table-striped table-bordered table-hover">
         <thead>
            <tr>
               <td width="100">
                  <div>Parameter<span></span></div>
               </td>
               <td width="200">
                  <div>Accepted Values<span></span></div>
               </td>
               <td width="600">
                  <div>Parameter Description<span></span></div>
               </td>
            </tr>
         </thead>
         <tbody>
            <tr>
               <td>action</td>
               <td>
                  offers_cats
               </td>
               <td>Tells the API to use the Offers Category IDs Action</td>
            </tr>
            <tr>
               <td>format</td>
               <td>
                  json
               </td>
               <td>Tells the API to return a json string.</td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
<div class="card my-3">
   <div class="card-header text-uppercase">
      Offer Type IDs
   </div>
   <div class="card-body">
      <p>
         This action will return a listing of Offer Type IDs that can be used in conjunction with the "type" parameter on the offers API.
      </p>
      <table class="table table-striped table-bordered table-hover">
         <thead>
            <tr>
               <td width="100">
                  <div>Parameter<span></span></div>
               </td>
               <td width="200">
                  <div>Accepted Values<span></span></div>
               </td>
               <td width="600">
                  <div>Parameter Description<span></span></div>
               </td>
            </tr>
         </thead>
         <tbody>
            <tr>
               <td>action</td>
               <td>
                  offers_types
               </td>
               <td>Tells the API to use the Offers Types IDs Action</td>
            </tr>
            <tr>
               <td>format</td>
               <td>
                  json
               </td>
               <td>Tells the API to return a json string.</td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
<div class="card my-3">
   <div class="card-header text-uppercase">
      Campaigns / Offers
   </div>
   <div class="card-body">
      <p>
         This action will return a detailed listing of campaigns and the parameters for each campaign.
      </p>
      <table class="table table-striped table-bordered table-hover">
         <thead>
            <tr>
               <td width="100">
                  <div>Parameter<span></span></div>
               </td>
               <td width="200">
                  <div>Accepted Values<span></span></div>
               </td>
               <td width="600">
                  <div>Parameter Description<span></span></div>
               </td>
            </tr>
         </thead>
         <tbody>
            <tr>
               <td>action</td>
               <td>offers</td>
               <td>Tells the API to use the Offers Action</td>
            </tr>
            <tr>
               <td>format</td>
               <td>json</td>
               <td>This API Only returns Json.</td>
            </tr>
         </tbody>
      </table>
      <p>OPTIONAL SEARCH PARAMETERS </p>
      <table class="table table-striped table-bordered table-hover">
         <tbody>
            <tr>
               <td>id</td>
               <td>numeric value</td>
               <td>Campaign/offer ID</td>
            </tr>
            <tr>
               <td>cat</td>
               <td>numeric value</td>
               <td>Category ID<br><small>See APIs below to get list of accepted IDs</small></td>
            </tr>
            <tr>
               <td>type</td>
               <td>numeric value</td>
               <td>Traffic Type ID<br><small>See API's below to get list of accepted IDs</small></td>
            </tr>
            <tr>
               <td>country</td>
               <td>2 Digit Country Code</td>
               <td>Defines country code to search by. Must be in Capital Letters<br><small>See APIs below to get list of accepted IDs</small></td>
            </tr>
         </tbody>
      </table>
   </div>
</div>