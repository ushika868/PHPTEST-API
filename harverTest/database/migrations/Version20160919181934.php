<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160919181934 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        (new Builder($schema))->create('employee', function (Table $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->timestamps();
            $table->softDeletes();

            $table->unique('email');
        });
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        
        (new Builder($schema))->table('employee', function(Table $table) {
            $table->dropUnique('users_email_unique');
        });
        (new Builder($schema))->drop('employee');
    }
}
