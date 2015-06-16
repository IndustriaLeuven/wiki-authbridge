<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150616111100 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $users = $schema->createTable('users');
        $users->addColumn('id', 'integer');
        $users->addColumn('auth_id', 'string');
        $users->addColumn('username', 'string');
        $users->addColumn('realname', 'string');
        $users->addColumn('groups', 'simple_array');
        $users->addColumn('wikiName', 'string')->setNotnull(false);

        $users->setPrimaryKey(array('id'));
        $users->addUniqueIndex(array('auth_id'));
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('users');
    }
}
