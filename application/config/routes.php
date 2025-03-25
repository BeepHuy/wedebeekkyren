<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "home";
///new
$route['aboutus'] = 'pages/aboutus';
$route['advertiser'] = 'pages/advertiser';
$route['publisher'] = 'pages/publisher';
$route['products'] = 'pages/products';
$route['contact'] = 'pages/contact';
$route['ajax-aboutus'] = 'pages/contact_ajax';

$route['v2/privacy'] = 'news/terms';
///new
$route['v2/terms'] = 'news/terms';
$route['v2/privacy'] = 'news/terms';

$route['v2'] = 'members/dashboard';
$route['v2/'] = 'members/dashboard';

//$route['v2/(:any)'] = 'members/$1';
$route['v2/offers'] = 'members/offers/list_offers';
$route['v2/offers/(:num)'] = 'members/offers/list_offers/$1';//phan trang
$route['v2/offers/available'] = 'members/offers/available';//offer active
$route['v2/offers/available/(:num)'] = 'members/offers/available/$1';//offer active

$route['v2/offers/pending'] = 'members/offers/listOfferByStatus';//offer active
$route['v2/offers/pending/(:num)'] = 'members/offers/listOfferByStatus/$1';//offer active
$route['v2/offers/approved'] = 'members/offers/listOfferByStatus';//offer active
$route['v2/offers/approved/(:num)'] = 'members/offers/listOfferByStatus/$1';//offer active

$route['v2/offers/live'] = 'members/offers/available';
$route['v2/offers/ajax_serach_offer'] = 'members/offers/ajax_serach_offer';
$route['v2/offers/request/(:num)'] = 'members/offers/request/$1';//offer request
$route['v2/offers/requpdate/(:num)'] = 'members/offers/requpdate/$1';//offer request

$route['v2/offer/(:num)'] = 'members/offers/offer_view/$1';//chi tiết offer - offer k có S

//profile
$route['v2/profile/profile'] = 'members/profile';
$route['v2/profile/aj_update_info'] = 'members/profile';
$route['v2/profile/changepass'] = 'members/profile';
$route['v2/profile/api-key'] = 'members/profile';
$route['v2/profile/resetApi'] = 'members/resetApi';
$route['v2/profile/postbacks'] = 'members/profile';
$route['members/ajax_test_postback'] = 'members/ajax_test_postback';
$route['v2/profile/locale'] = 'members/profile';
$route['v2/profile/payment'] = 'members/profile';
$route['v2/profile/post_payment'] = 'members/post_payment';


//payments
$route['v2/payments'] = 'members/payments/payment_list';
$route['v2/payments/'] = 'members/payments/payment_list';
$route['v2/request_payouts'] = 'members/payments/request_payouts';
$route['v2/edit_payouts'] = 'members/payments/edit_payouts';

$route['v2/smartlinks'] = 'members/smartlinks/list_offers';
$route['v2/smartlinks/(:num)'] = 'members/smartlinks/list_offers/$1';//offer active
$route['v2/smartlinks/(:any)'] = 'members/smartlinks/$1';
$route['v2/smartlinks/request/(:any)'] = 'members/smartlinks/request/$1';//phan trang

//smartofff
$route['v2/smartoffers'] = 'members/smartoffers/list_offers';
$route['v2/smartoffers/(:num)'] = 'members/smartoffers/list_offers/$1';//phan trang
$route['v2/smartoffers/(:any)'] = 'members/smartoffers/$1';
$route['v2/smartoffers/request/(:num)'] = 'members/smartoffers/request/$1';//offer request


//newa
$route['v2/news'] = 'news/news_list';
$route['v2/news/'] = 'news/news_list';
$route['v2/news/(:any)'] = 'news/views/$1';

//statistics
$route['v2/statistics'] = 'members/statistics/dayli';
$route['v2/statistics/'] = 'members/statistics/dayli';
$route['v2/statistics/ajax_static_dayli'] = 'members/statistics/ajax_static_dayli';

$route['v2/statistics/smartlinks'] = 'members/statistics/smartlinks';
$route['v2/statistics/smartoffers'] = 'members/statistics/smartoffers';
$route['v2/statistics/goals'] = 'members/statistics/nodata';
$route['v2/statistics/referrals'] = 'members/statistics/referrals';
$route['v2/statistics/mobile_carrier'] = 'members/statistics/nodata';
$route['v2/statistics/sub(:num)'] = 'members/statistics/sub/$1';

$route['v2/statistics/(:any)'] = 'members/statistics/$1';


//auth

$route['v2/sign/in'] = 'members/auth/login';
$route['v2/sign/up'] = 'members/auth/register';
$route['v2/sign/up/(:num)'] = 'members/auth/register/$1';
$route['v2/regmanager/(:num)'] = 'members/auth/regm/$1';
$route['v2/sign/password/reset'] = 'members/auth/resetpass';
$route['confirmation/(:any)'] = 'members/auth/activate/$1';

$route['v2/logout'] = 'members/auth/logout';
//new on home - tin tức trang chủ
$route['v/(:any)'] = 'home/view_content/$1';
$route['v/'] = 'home/view_content';

// v3 Advertiser 
$route['v3/sign/up'] = 'advertiser/auth/register';
$route['v3/sign/in'] = 'advertiser/auth/login';
$route['v3/logout'] = 'advertiser/auth/logout';
$route['v3/news/(:any)'] = 'news/views/$1';

//click
$route['click/testpb?(:any)'] = 'click/testpb/$1';
$route['click?(:any)'] = 'click/index/$1';
$route['click(:any)'] = 'click/index/$1';
//smartlink
$route['smartlink?(:any)'] = 'smartlink/index/$1';
$route['smartlink(:any)'] = 'smartlink/index/$1';
//smartoffer
$route['smartoffer?(:any)'] = 'smartoffer/index/$1';
$route['smartoffer(:any)'] = 'smartoffer/index/$1';
//proxy report
$route['proxy_report'] = 'proxy_report/index';
$route['proxy_report/filtdata'] = 'proxy_report/filtdata';
$route['proxy_report/rvdata'] = 'proxy_report/rvdata';
$route['proxy_report/search'] = 'proxy_report/search/$1';
$route['proxy_report/(:any)'] = 'proxy_report/index/$1';
//mng report
//$route['manager/report/report/(:any)'] = 'manager/report/index/$1';



$route['ad_user'] = 'ad_user/index/$1';
$route['ad_user/(:any)'] = 'ad_user/$1';
//end newsđs//
//api

$route['api/offer_feed_json?(:any)'] = 'api/index/$1';
$route['api'] = 'api/document';
$route['referallink'] = 'members/statistics/referrals';

$route['3.0/offers/(:any)'] = 'apinew/offers/$1';
$route['3.0/offers'] = 'apinew/offers/$1';
$route['3.0/(:any)'] = 'apinew/index';

//$route['contact'] = "mod_contact/mod_contact/index";
//*pótback
$route['postback/(:any)'] = 'postback/$1';







$route[$this->config->item('admin').'/(:any)'] = 'adm_adc/$1';
$route[$this->config->item('admin')] = 'adm_adc';

$route[$this->config->item('manager').'/(:any)'] = 'adm_mng/$1';
$route[$this->config->item('manager')] = 'adm_mng';


$route['advertiser/singup'] = 'mod_adv/singup';

//$route['tracking/(:any)'] = 'mod_offer/mod_offer/viewoffer/$1';


//$route['(:any)'] = 'members';
$route['404_override'] = 'members/index';


/* End of file routes.php */
/* Location: ./application/config/routes.php */