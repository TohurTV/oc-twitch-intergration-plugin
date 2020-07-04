<?php

namespace Tohur\TwitchIntergration\Classes;

class TwitchAPI {

    /**
     * @var string Twitch helix API Base URL
     */
    public $oAuthbaseUrl = 'https://id.twitch.tv/oauth2/token';

    /**
     * @var string Twitch Kraken API Base URL
     */
    public $krakenbaseUrl = 'https://api.twitch.tv/kraken';

    /**
     * @var string Twitch helix API Base URL
     */
    public $helixbaseUrl = 'https://api.twitch.tv/helix';

    /**
     * @var string Rest URL based on Toplist Type
     */
    public $typeUrl;

    /**
     * Do Helix API setup with given url
     *
     * @param string $url
     * @return string
     */
    function helixTokenRequest($url) {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        curl_close($ch);
        return $result;
    }

    /**
     * Do Helix API setup with given url
     *
     * @param string $url
     * @return string
     */
    function helixApi($url) {
        $twitchAPISettings = \Tohur\SocialConnect\Models\Settings::instance()->get('providers', []);
        $client_id = $twitchAPISettings['Twitch']['client_id'];
        $client_secret = $twitchAPISettings['Twitch']['client_secret'];
        $count = \DB::table('tohur_twitchintergration_apptokens')->count();
        if ($count == 0) {
            $tokenRequest = json_decode($this->helixTokenRequest($this->oAuthbaseUrl . "?client_id=" . $client_id . "&client_secret=" . $client_secret . "&grant_type=client_credentials&scope=channel:read:hype_train%20channel:read:subscriptions%20bits:read%20user:read:broadcast%20user:read:email"), true);
            $accessToken = $tokenRequest['access_token'];
            $tokenExpires = $tokenRequest['expires_in'];
            \Db::table('tohur_twitchintergration_apptokens')->insert([
                ['access_token' => $accessToken, 'expires_in' => $tokenExpires, 'created_at' => now()]
            ]);
            $token = $accessToken;
        } else {
            $getToken = \DB::select('select * from tohur_twitchintergration_apptokens where id = ?', array(1));
            $token = $getToken[0]->access_token;
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Client-ID: ' . $client_id,
            'Authorization: Bearer ' . $token
        ));

        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * Do kraken API Request with given url
     *
     * @param string $url
     * @return string
     */
    public function oldapiRequest($url) {
        $twitchAPISettings = \Tohur\SocialConnect\Models\Settings::instance()->get('providers', []);
        $client_id = $twitchAPISettings['Twitch']['client_id'];
        return file_get_contents($this->krakenbaseUrl . $url . "&client_id=" . $client_id . "&api_version=5");
    }

    /**
     * Do kraken API Request with given url
     *
     * @param string $url
     * @return string
     */
    public function oldapiCheckRequest($url) {
        $twitchAPISettings = \Tohur\SocialConnect\Models\Settings::instance()->get('providers', []);
        $client_id = $twitchAPISettings['Twitch']['client_id'];
        return file_get_contents($this->krakenbaseUrl . $url . "?client_id=" . $client_id . "&api_version=5");
    }

    /**
     * Get Videolist with given Type, Limit and Offset
     *
     * @param string $type
     * @param int $limit
     * @param int $offset
     * @return string
     */
    public function getVideoList($channel, $limit = 10, $offset = 0, $broadcastType = 'archive') {
        $channelID = file_get_contents('https://api.tohur.me/twitch/id/' . $channel);
        $object = json_decode($this->helixApi($this->helixbaseUrl . "/videos?user_id=" . $channelID . "&first=" . $limit . "&type=" . $broadcastType), true);
        return $object['data'];
    }

    /**
     * Get Cliplist with given Type, Limit and Offset
     *
     * @param string $type
     * @param int $limit
     * @param int $offset
     * @return string
     */
    public function getClipList($channel, $limit = 10, $offset = 0, $period = 'all') {
        $channelID = file_get_contents('https://api.tohur.me/twitch/id/' . $channel);
        $object = json_decode($this->helixApi($this->helixbaseUrl . "/clips?broadcaster_id=" . $channelID . "&first=" . $limit), true);
        return $object['data'];
    }

    /**
     * Get BitsLeaderboard with given Type, Limit and Offset
     *
     * @param string $type
     * @param int $limit
     * @param int $offset
     * @return string
     */
    public function getBitsLeaderboard($acessToken = null, $clientID = null, $limit = 10, $period = 'all') {
        $object = json_decode($this->helixApi($this->helixbaseUrl . "/bits/leaderboard?count=" . $limit, $clientID, $acessToken), true);
        return $object['data'];
    }

    /**
     * Returns True of False whether the Channel is online or not
     *
     * @param string $channel Name of the Twitch Channel
     * @return bool
     */
    public function isChannelLive($channel) {
        $channelID = file_get_contents('https://api.tohur.me/twitch/id/' . $channel);
        $callAPI = $this->oldapiCheckRequest("/streams/" . $channelID);
        $dataArray = json_decode($callAPI, true);

        return (!is_null($dataArray["stream"]) ) ? true : false;
    }

}
