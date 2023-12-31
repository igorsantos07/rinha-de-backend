<?php
use Phinx\Migration\AbstractMigration;

final class CreatePessoas extends AbstractMigration
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
    public function change() {
//        $this->execute('CREATE EXTENSION IF NOT EXISTS "uuid-ossp"');
        $this->table('pessoas', ['id' => false])
            ->addColumn('id', 'uuid'
            //easier if this is just generated by Eloquent instead: https://laravel.com/docs/10.x/eloquent#uuid-and-ulid-keys
//                ,['default' => \Phinx\Util\Literal::from('uuid_generate_v4()')]
            )
            ->addColumn('apelido','text') //TODO unique
            ->addColumn('nome','text')
            ->addColumn('nascimento','date')
            ->addColumn('stack','jsonb', ['null' => true])
            ->addIndex(['apelido'], ['unique' => true])
            ->create();
    }
}
