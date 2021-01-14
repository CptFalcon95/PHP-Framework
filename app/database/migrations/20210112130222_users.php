<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;
use App\Core\Hash;

final class Users extends AbstractMigration
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
    public function change(): void
    {
        if(!$this->hasTable('users')) {
            $users = $this->table('users', ['id' => false, 'primary_key' => ['id']]);
            $users->addColumn('id', 'uuid', ['default' => Hash::randomString(16), 'limit' => 16])
                  ->addColumn('name', 'string')
                  ->addColumn('email', 'string')
                  ->addColumn('password', 'string', ['limit' => 60])
                  ->addColumn('password_salt', 'string', ['limit' => 60])
                  ->addColumn('image', 'string')
                  ->addColumn('url', 'string')
                  ->addColumn('created', 'datetime', ['default' => Literal::from('now()')])
                  ->addColumn('updated', 'datetime', ['default' => Literal::from('now()')])
                  ->create();
        }              
    }
}
