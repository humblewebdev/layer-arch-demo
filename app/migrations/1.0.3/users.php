<?php

use Phalcon\Db\Column;
use Phalcon\Db\Exception;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class UsersMigration_103
 */
class UsersMigration_103 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     * @throws Exception
     */
    public function morph(): void
    {
        $this->morphTable('users', [
            'columns' => [
                new Column( 'id', [
                    'type' => Column::TYPE_INTEGER,
                    'notNull' => true,
                    'autoIncrement' => true,
                    'size' => 11, 'first' => true ] ),
                new Column( 'foreignId', [
                    'type' => Column::TYPE_VARCHAR,
                    'notNull' => true,
                    'size' => 26, 'after' => 'id' ] ),
                new Column( 'firstName', [
                    'type' => Column::TYPE_VARCHAR,
                    'notNull' => false,
                    'size' => 40,
                    'after' => 'foreignId' ] ),
                new Column( 'lastName', [
                    'type' => Column::TYPE_VARCHAR,
                    'notNull' => false,
                    'size' => 40,
                    'after' => 'firstName' ] ),
                new Column( 'username', [
                    'type' => Column::TYPE_VARCHAR,
                    'notNull' => true,
                    'size' => 40,
                    'after' => 'lastName' ] ),
                new Column( 'email', [
                    'type' => Column::TYPE_VARCHAR,
                    'notNull' => true,
                    'size' => 40,
                    'after' => 'username' ] ),
            ],
            'indexes' => [new Index('PRIMARY', ['Id'], 'PRIMARY') ],
            'options' => [ 'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '3', 'ENGINE' => 'InnoDB',
                'TABLE_COLLATION' => 'latin1_swedish_ci' ],
        ] );
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up(): void
    {

    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down(): void
    {
    }
}
