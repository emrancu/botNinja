<?php


use App\controller\api\CampaignController;
use App\controller\api\DashboardController;
use App\controller\api\SettingsController;

$route->get('dashboard', [new DashboardController, 'dashboardResponse']);

$route->get('Campaigns', [new CampaignController, 'getCampaignResponse']);

$route->post('createCampaign', [new CampaignController, 'createCampaignResponse'], true);

$route->post('UpdateCampaign', [new CampaignController, 'updateCampaignResponse'], true);

$route->get('CampaignDetails/(?P<phoneNumber>\d+)', [new CampaignController, 'getCampaignDetailsResponse']);

$route->get('setting', [new SettingsController, 'getSettingResponse'], true);

$route->post('saveSetting', [new SettingsController, 'saveSettingResponse'], true);

