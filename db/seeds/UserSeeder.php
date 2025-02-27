<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;
use App\Models\Users;

require_once __DIR__ . '/../../bootstrap/database.php';

class UserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $users = new Users();
        $users->name = 'Admin';
        $users->email = 'admin@gmail.com';
        $users->password = password_hash('admin123', PASSWORD_DEFAULT);
        $users->save();
    }
}
