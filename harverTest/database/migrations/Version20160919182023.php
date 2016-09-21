<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20160919182023 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        (new Builder($schema))->create('employee_department', function (Table $table) {
            $table->increments('id');
            $table->integer('department_id');
            $table->integer('employees_id');
            $table->timestamps();

        });
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    { 

        (new Builder($schema))->drop('employee_department');
    }
}
