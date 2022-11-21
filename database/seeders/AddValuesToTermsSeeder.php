<?php

namespace Database\Seeders;

use App\Models\Term\Term;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddValuesToTermsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Term::factory()
            ->count(50)
            ->create();
    }
}
