<?php

/**
 * @Created by          : Raja Azian <rajaazian08@gmail.com>
 * @Date                : 20/07/2023 18:03
 * @File name           : 1_CreateSearchRecommedationsSettingsTable.php
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

use SLiMS\Table\Schema;
use SLiMS\Table\Blueprint;

class CreateSearchRecommedationsSettingsTable extends \SLiMS\Migration\Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    function up()
    {
        Schema::create('search_recommendations_settings', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->autoIncrement('id');
            $table->string('rest_uri', 255)->notNull();
            $table->string('token', 255)->notNull();
            $table->string('count', 10)->notNull();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    function down()
    {
        Schema::drop('search_recommendations_settings');
    }
}
