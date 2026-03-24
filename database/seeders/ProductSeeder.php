<?php

namespace Database\Seeders;

use Database\Seeders\products\Blinds\BlindsSeeder25;
use Database\Seeders\products\Blinds\BlindsSeeder50;
use Database\Seeders\products\CassetteBlinds\CassetteBlindsSeeder;
use Database\Seeders\products\PleatedBlinds\PleatedBlindsSeeder;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            CassetteBlindsSeeder::class,
            PleatedBlindsSeeder::class,
            BlindsSeeder25::class,
            BlindsSeeder50::class,
            BlindsPatchSeeder::class,
        ]);
    }
}
