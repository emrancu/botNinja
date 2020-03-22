<?php



$route->get('dashboard/{id?}', 'DashboardController@dashboard');

$route->get('Campaigns', 'CampaignController@getCampaign');

$route->post('createCampaign', 'CampaignController@createCampaign', true);

$route->post('UpdateCampaign', 'CampaignController@updateCampaign', true);

$route->get('CampaignDetails/{phoneNumber}',  'CampaignController@getCampaignDetails' );

$route->get('setting', 'SettingsController@getSetting', true);

$route->post('saveSetting','SettingsController@saveSetting', true);


$route->post('campaign-report','CampaignController@report');
$route->post('call-summery','CampaignController@summery');



