<?php

namespace Tohur\TwitchIntergration\Components;

use Cms\Classes\ComponentBase;
use Tohur\TwitchIntergration\Classes\TwitchAPI;

class Videos extends ComponentBase {

    /**
     * @var array
     */
    public $videoItems;

    /**
     * @inheritdoc
     */
    public function ComponentDetails() {
        return [
            'name' => 'tohur.twitchintergration::lang.videos.name',
            'description' => 'tohur.twitchintergration::lang.videos.description'
        ];
    }

    /**
     * @inheritdoc
     */
    public function defineProperties() {
        return [
            'videoType' => [
                'title' => 'tohur.twitchintergration::lang.videos.type_title',
                'type' => 'dropdown',
                'default' => 'games',
                'options' => ['archive' => 'Archive', 'highlight' => 'Highlight', 'upload' => 'Upload', 'clips' => 'Clips']
            ],
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
            'page' => [
                'title' => 'tohur.twitchintergration::lang.settings.page_title',
                'description' => 'tohur.twitchintergration::lang.settings.page_description',
                'type' => 'string',
                'default' => '/base-page/view/'
            ],
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

        $this->videoItems = $this->page['videoItems'] = $this->getvideoItems();
    }

    /**
     * @return array
     */
    public function getVideoItems() {
        $twitch = new TwitchAPI();
        $apiCall = '';
        if ($this->property('videoType') === 'archive' || $this->property('videoType') === 'highlight' || $this->property('videoType') === 'upload'){
           $apiCall = $twitch->getVideoList($this->property('channel'), $this->property('limit'), $this->property('offset'), $this->property('videoType'),$this->property('oldapi'));
        } else {
          $apiCall = $twitch->getClipList($this->property('channel'), $this->property('limit'), $this->property('offset'), 'all', $this->property('oldapi'));  
        }
        return $apiCall;
    }

}
