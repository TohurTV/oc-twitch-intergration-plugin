<?php

namespace Tohur\SocialConnect\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTohurTwitchIntergrationAppTokensTable extends Migration {

    public function up() {
        Schema::create('tohur_twitchintergration_apptokens', function($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('access_token', 100)->default('')->index();
            $table->string('expires_in', 100)->default('')->index();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::drop('tohur_twitchintergration_apptokens');
    }

}
