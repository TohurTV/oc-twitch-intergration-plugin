<?php

namespace Tohur\TwitchIntergration\Components;

use Cms\Classes\ComponentBase;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;

class Check extends ComponentBase {

    /**
     * @var bool
     */
    public $channelIsOnline;

    /**
     * @inheritdoc
     */
    public function ComponentDetails() {
        return [
            'name' => 'tohur.twitchintergration::lang.check.name',
            'description' => 'tohur.twitchintergration::lang.check.description',
        ];
    }

    /**
     * @inheritdoc
     */
    public function defineProperties() {
        return [
            'channel' => [
                'title' => 'tohur.twitchintergration::lang.settings.channel_name',
                'description' => 'tohur.twitchintergration::lang.settings.channel_description',
                'type' => 'string',
                'required' => true
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function onRun() {
        $this->channelIsOnline = $this->page['channelIsOnline'] = $this->getChannelStatus();
    }

    /**
     * @return bool
     */
    public function getChannelStatus() {
        $twitch = new TwitchAPI();
        return $twitch->isChannelLive($this->property('channel'));
    }

}
