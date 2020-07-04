<?php

return [
    'plugin' => [
        'name' => 'Twitch Intergration',
        'description' => 'Provides Twitch.tv integration services.'
    ],
    'settings' => [
        'channel_name' => 'Channel Name',
        'channel_description' => 'Name of the twitch channel.',
        'channel_client_id' => 'Client ID',
        'channel_client_description' => 'Enter the Client ID of the Twitch Channel you wish to connect to',
        'channel_client_id2' => 'Client ID for access token',
        'channel_client_description2' => 'Enter the Client ID of the acess token',
        'channel_access token' => 'Acess toke for this client id',
        'channel_access_token_description2' => 'Enter acess token for this client id',
        'twitch_id_title' => 'Twitch ID',
        'twitch_id_description' => 'Channel name for live streams or video id for past broadcast.',
        'width_name' => 'Stream Width',
        'width_description' => 'Width of the embed Stream/Video.',
        'height_name' => 'Height',
        'height_description' => 'Height of the embed Stream/Video and Chat.',
        'volume_name' => 'Volume',
        'volume_description' => 'Default Volume of the embed Stream/Video.',
        'parent_name' => 'Parent Domain',
        'parent_description' => 'The Parent Domain it is required.',
        'theme_name' => 'Theme',
        'theme_description' => 'Light or Dark theme.',
        'limit_title' => 'Limit',
        'limit_description' => 'Limit of Items to show. Default: 10',
        'offset_title' => 'Offset',
        'offset_description' => 'Offset the items to show. Default: 0',
        'page_title' => 'View Page',
        'page_description' => 'Url to View items on. Example: /past-broadcasts/view/',
        'dedicatedpage_title' => 'Dedicated View Page',
        'dedicatedpage_description' => 'Dedicated view page with url parameter :video_id',
        'posts_no_posts' => 'Show Twitch Feed Posts.',
        'posts_no_posts_description' => 'Show Twitch Feed Posts.',
        'chat_name' => 'Chat',
        'chat_description' => 'Display Stream Chat',
        'chat_width_name' => 'Chat Width',
        'chat_width_description' => 'Width of the Chat',
        'oldapi_name' => 'Use Kraken API?',
        'oldapi_description' => 'should use old kraken api? True uses new API does not work in all cases'
    ],
    'check' => [
        'name' => 'Twitch Online Check',
        'description' => 'Shows if a Channel is online.'
    ],
    'bits' => [
        'name' => 'Bits Leaderboard',
        'description' => 'Outputs Twitch Channel Bits leaderboard'
    ],
    'videos' => [
        'name' => 'Twitch Videos and Clips',
        'description' => 'Outputs Twitch Videos to a list',
        'type_title' => 'Video Type'
    ],
    'stream' => [
        'name' => 'Twitch Embed',
        'description' => 'Embeds Streams, Videos, and Clips',
        'type_title' => 'Type',
        'type_description' => 'Stream for live streams or Video for past broadcasts',
    ]
];
