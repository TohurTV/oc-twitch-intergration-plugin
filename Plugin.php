<?php

namespace Tohur\TwitchIntergration;

use App;
use Backend;
use Event;
use URL;
use Config;
use Illuminate\Foundation\AliasLoader;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;
use October\Rain\Support\Collection;
use Backend\Widgets\Form;
use Tohur\TwitchIntergration\Classes\TwitchAPI;

class Plugin extends PluginBase {

    // Make this plugin run on updates page
    public $elevated = true;
    public $require = ['Tohur.SocialConnect'];

    public function pluginDetails() {
        return [
            'name' => 'Twitch Intergration',
            'description' => 'tohur.twitchintergration::lang.plugin.description',
            'author' => 'Joshua Webb',
            'icon' => 'icon-video-camera'
        ];
    }

    public function registerComponents() {
        return [
//            'Tohur\twitchintergration\Components\Bits' => 'bits',
            'Tohur\twitchintergration\Components\Check' => 'check',
            'Tohur\twitchintergration\Components\Stream' => 'stream',
            'Tohur\twitchintergration\Components\Videos' => 'stream'
        ];
    }

    public function registerSchedule($schedule) {
        $schedule->call(function () {
            $twitch = new TwitchAPI();
            $twitchAPISettings = \Tohur\SocialConnect\Models\Settings::instance()->get('providers', []);
            $client_id = $twitchAPISettings['Twitch']['client_id'];
            $client_secret = $twitchAPISettings['Twitch']['client_secret'];
            $tokenRequest = json_decode($twitch->helixTokenRequest($twitch->oAuthbaseUrl . "?client_id=" . $client_id . "&client_secret=" . $client_secret . "&grant_type=client_credentials&scope=channel:read:hype_train%20channel:read:subscriptions%20bits:read%20user:read:broadcast%20user:read:email"), true);
            $accessToken = $tokenRequest['access_token'];
            $tokenExpires = $tokenRequest['expires_in'];
            \Db::table('tohur_twitchintergration_apptokens')
                    ->where('id', 1)
                    ->update(['access_token' => $accessToken, 'expires_in' => $tokenExpires, 'updated_at' => now()]);
        })->weekly();
    }

    public function boot() {
        
    }

}