<?php

return [
    "environment" => "production", // staging or production
    "app_name" => "Easy Plugin",
    "endpoints" => [
        "createCampaign" => "http://localhost/cl/twilioApp/public/createBot",
        "campaign" => "http://localhost/cl/twilioApp/public/getCampaign",
        "updateCampaign" => "http://localhost/cl/twilioApp/public/updateCampaignSettings",
        "campaign_details" => "http://localhost/cl/twilioApp/public/getCampaignDetails",
        "campaign_report" => "http://localhost/cl/twilioApp/public/campaign-call-report",
        "summery" => "http://localhost/cl/twilioApp/public/campaign-call-summery",
    ],
    "production_endpoints" => [
        "createCampaign" => "https://wpapi.chatleads.io/createBot",
        "campaign" => "https://wpapi.chatleads.io/getCampaign",
        "updateCampaign" => "https://wpapi.chatleads.io/updateCampaignSettings",
        "campaign_details" => "https://wpapi.chatleads.io/getCampaignDetails",
        "campaign_report" => "https://wpapi.chatleads.io/campaign-call-report",
        "summery" => "https://wpapi.chatleads.io/campaign-call-summery",
    ],
    "middleware" => [
        "Admin" => "App\\middleware\\Admin"
    ]
];

