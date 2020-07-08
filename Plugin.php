<?php

namespace Tohur\TwitchIntergration;

use App;
use Event;
use URL;
use Config;
use System\Classes\PluginBase;

class Plugin extends PluginBase {

    // Make this plugin run on updates page
    public $elevated = true;
    public $require = ['Tohur.SocialConnect'];

    public function pluginDetails() {
        return [
            'name' => 'Twitch Intergration',
            'description' => 'Provides Twitch.tv integration services.',
            'author' => 'Joshua Webb',
            'icon' => 'icon-video-camera'
        ];
    }

    public function registerComponents() {
        return [
            'Tohur\twitchintergration\Components\Bits' => 'bits',
            'Tohur\twitchintergration\Components\Check' => 'check',
            'Tohur\twitchintergration\Components\Stream' => 'stream',
            'Tohur\twitchintergration\Components\Videos' => 'stream'
        ];
    }


    public function boot() {

    }

}
