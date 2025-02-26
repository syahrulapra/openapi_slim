<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTicketsTableMigration extends AbstractMigration
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
        $table = $this->table('tbtickets');

        $table->addColumn('title', 'string', ['limit' => 255])
          ->addColumn('description', 'text')
          ->addColumn('status', 'enum', ['values' => ['open', 'in_progress', 'closed'], 'default' => 'open'])
          ->addColumn('priority', 'enum', ['values' => ['low', 'medium', 'hard'], 'default' => 'low'])
          ->addTimestamps()
          ->create();
    }
}
