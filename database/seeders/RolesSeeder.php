<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! Role::exists()) {
            foreach ($this->data() as $roleData) {
                Role::create($roleData);
            }
        }
    }

    /**
     * Returns an array of data to be used in seeding.
     *
     * Each sub-array contains the 'name' key with a corresponding role.
     *
     * @return array
     */
    private function data(): array
    {
        return [
            ['name' => 'administrator'],
            ['name' => 'client'],
        ];
    }
}
