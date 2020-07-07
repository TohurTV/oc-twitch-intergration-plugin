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
            'username' => [
                'title' => 'tohur.twitchintergration::lang.settings.username_title',
                'description' => 'tohur.twitchintergration::lang.settings.username_description',
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
        $user = \Db::table('users')->where('username', $this->property('username'))->first();
        $findToken = \DB::table('tohur_socialconnect_providers')->where('user_id', '=', array($user->id))->where('provider_id', '=', 'Twitch')->get();
        $token = $findToken[0]->provider_token;
        $apiCall = $twitch->getBitsLeaderboard($token, $this->property('limit'));

        return $apiCall;
    }

}
