<?php

namespace Tohur\TwitchIntergration\Components;

use Cms\Classes\ComponentBase;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;

class Bits extends ComponentBase {

    /**
     * @var array
     */
    public $bitsItems;

    /**
     * @inheritdoc
     */
    public function ComponentDetails() {
        return [
            'name' => 'tohur.twitchintergration::lang.bits.name',
            'description' => 'tohur.twitchintergration::lang.bits.description'
        ];
    }

    /**
     * @inheritdoc
     */
    public function defineProperties() {
        return [
            'limit' => [
                'title' => 'tohur.twitchintergration::lang.settings.limit_title',
                'description' => 'tohur.twitchintergration::lang.settings.limit_description',
                'type' => 'string',
                'default' => '10'
            ],
            'offset' => [
                'title' => 'tohur.twitchintergration::lang.settings.offset_title',
                'description' => 'tohur.twitchintergration::lang.settings.offset_description',
                'type' => 'string',
                'default' => '0'
            ],
            'acesstoken' => [
                'title' => 'tohur.twitchintergration::lang.settings.channel_access token',
                'description' => 'tohur.twitchintergration::lang.settings.channel_access_token_description2',
                'type' => 'string'
            ],
            'clientid' => [
                'title' => 'tohur.twitchintergration::lang.settings.channel_client_id2',
                'description' => 'tohur.twitchintergration::lang.settings.channel_client_description2',
                'type' => 'string'
            ]            
        ];
    }

    /**
     * @inheritdoc
     */
    public function onRun() {

        $this->bitsItems = $this->page['bitsItems'] = $this->getBitsLeaders();
    }

    /**
     * @return array
     */
    public function getBitsLeaders() {
        $twitch = new TwitchAPI();
        $apiCall = $twitch->getBitsLeaderboard($this->property('accesstoken'), $this->property('clientid'), $this->property('limit'));

        return $apiCall;
    }

}
