<?php

namespace Tohur\TwitchIntergration\Components;

use Cms\Classes\ComponentBase;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;

class Stream extends ComponentBase {

    /**
     * @var array
     */
    public $videoID;

    /**
     * @inheritdoc
     */
    public function ComponentDetails() {
        return [
            'name' => 'tohur.twitchintergration::lang.stream.name',
            'description' => 'tohur.twitchintergration::lang.stream.description'
        ];
    }

    /**
     * @inheritdoc
     */
    public function defineProperties() {
        return [
            'type' => [
                'title' => 'tohur.twitchintergration::lang.stream.type_title',
                'description' => 'tohur.twitchintergration::lang.stream.type_description',
                'type' => 'dropdown',
                'default' => 'stream',
                'options' => ['stream' => 'Stream', 'video' => 'Video', 'clip' => 'Clip']
            ],
            'twitchId' => [
                'title' => 'tohur.twitchintergration::lang.settings.twitch_id_title',
                'description' => 'tohur.twitchintergration::lang.settings.twitch_id_description',
                'placeholder' => 'channel name or video id'
            ],
                'dedicatedpage' => [
                'title' => 'tohur.twitchintergration::lang.settings.dedicatedpage_title',
                'description' => 'tohur.twitchintergration::lang.settings.dedicatedpage_description',
                'type' => 'dropdown',
                'default' => 'false',
                'options' => ['false' => 'False', 'true' => 'True']
            ],
            'width' => [
                'title' => 'tohur.twitchintergration::lang.settings.width_name',
                'description' => 'tohur.twitchintergration::lang.settings.width_description',
                'type' => 'string',
                'default' => '854'
            ],
            'height' => [
                'title' => 'tohur.twitchintergration::lang.settings.height_name',
                'description' => 'tohur.twitchintergration::lang.settings.height_description',
                'type' => 'string',
                'default' => '480'
            ],
            'theme' => [
                'title' => 'tohur.twitchintergration::lang.settings.theme_name',
                'description' => 'tohur.twitchintergration::lang.settings.theme_description',
                'type' => 'dropdown',
                'default' => 'light',
                'options' => ['light' => 'Light', 'dark' => 'Dark']
            ],
            'volume' => [
                'title' => 'tohur.twitchintergration::lang.settings.volume_name',
                'description' => 'tohur.twitchintergration::lang.settings.volume_description',
                'type' => 'string',
                'default' => '0.5'
            ],
            'parent' => [
                'title' => 'tohur.twitchintergration::lang.settings.parent_name',
                'description' => 'tohur.twitchintergration::lang.settings.parent_description',
                'type' => 'string',
                'default' => ''
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function onRun() {
        $this->videoID = $this->param('video_id');
    }

}
