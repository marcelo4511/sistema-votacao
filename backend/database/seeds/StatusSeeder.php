<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->insert([
            'name' => 'Ativo',
        ]);

        DB::table('status')->insert([
            'name' => 'Inativo',
        ]);

        DB::table('status')->insert([
            'name' => 'Não Iniciadas',
        ]);

        DB::table('status')->insert([
            'name' => 'Em  andamento',
        ]);

        DB::table('status')->insert([
            'name' => 'FInalizada',
        ]);
    }
}
