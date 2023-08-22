<?php
use Phinx\Migration\AbstractMigration;

final class CreateIndexes extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up() {
        //https://www.crunchydata.com/blog/postgres-full-text-search-a-search-engine-in-a-database
        $this->execute("ALTER TABLE pessoas ADD COLUMN terms tsvector GENERATED ALWAYS AS (
                setweight(to_tsvector('english', 'nome'), 'A') ||
                setweight(to_tsvector('english', 'apelido'), 'B')
            ) STORED
        ");

        $this->table('pessoas')
            //https://stackoverflow.com/questions/19925641/check-if-a-postgres-json-array-contains-a-string
            ->addIndex(['stack', 'terms'], ['type' => 'gin'])
            ->update();
    }
    
    public function down() {
        $this->table('pessoas')
            ->removeColumn('terms')
            ->removeIndex(['stack','terms'])
            ->update();
    }
}
