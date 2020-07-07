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
use October\Rain\Exception\ApplicationException;
use Backend\Widgets\Form;
use Carbon\Carbon;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;
use Tohur\SocialConnect\Models\TwitchApptokens;

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
            if (!strlen($twitchAPISettings['Twitch']['client_id']))
                throw new ApplicationException('Twitch API access is not configured. Please configure it on the Social Connect Settings Twitch tab.');
            $client_id = $twitchAPISettings['Twitch']['client_id'];
            $client_secret = $twitchAPISettings['Twitch']['client_secret'];
            $tokens = \DB::select('select * from tohur_socialconnect_twitch_apptokens where id = ?', array(1));
            $expiresIn = $tokens[0]->expires_in;
            $current = Carbon::now();
            $expired = Carbon::parse($tokens[0]->updated_at)->addSeconds($expiresIn);

            if ($current > $expired) {
                $tokenRequest = json_decode($twitch->helixTokenRequest($twitch->oAuthbaseUrl . "?client_id=" . $client_id . "&client_secret=" . $client_secret . "&grant_type=refresh_token&scope=channel:read:hype_train%20channel:read:subscriptions%20bits:read%20user:read:broadcast%20user:read:email"), true);
                $accessToken = $tokenRequest['access_token'];
                $tokenExpires = $expiresIn;
                \Db::table('tohur_socialconnect_twitch_apptokens')
                        ->where('id', 1)
                        ->update(['access_token' => $accessToken, 'expires_in' => $tokenExpires, 'updated_at' => now()]);
            }
        })->weekly();
    }

    public function boot() {
        
    }

}
