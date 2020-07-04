<?php

namespace Tohur\SocialConnect\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTohurTwitchIntergrationAppTokensTable extends Migration {

    public function up() {
        Schema::create('tohur_twitchintergration_apptokens', function($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('access_token')->default('');
            $table->string('refresh_token')->default('');
            $table->string('expires_in')->default('');
            $table->timestamps();
            $table->index(['access_token', 'refresh_token'], 'access_token_index');
        });
    }

    public function down() {
        Schema::drop('tohur_twitchintergration_apptokens');
    }

}
