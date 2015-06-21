<?php

use yii\db\Schema;
use yii\db\Migration;

class m150524_110629_phone_table extends Migration
{
    public function up()
    {
        $this -> createTable('phone', [
            'id' => Schema::TYPE_PK,
            'phone' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('phone');
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
