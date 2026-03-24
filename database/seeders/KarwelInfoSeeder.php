<?php

namespace Database\Seeders;

use App\Models\CompanyInfo;
use Illuminate\Database\Seeder;

class KarwelInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companyInfo = CompanyInfo::create([
            'name' => 'KARWEL Z. Jędrychowski, K. Reński spółka jawna',
            'address' => "ul. Tysiąclecia 39\n13-203 Stare Dłutowo",
            'phone' => '(+48) 23 698 20 12',
            'phone_alt' => ' (+48) 23 698 22 50',
            'email' => 'zamowienia@karwel.com.pl',
            'tax_id' => 'PL5711480528',
        ]);

        $logoPath = public_path('logo.png');

        if (file_exists($logoPath)) {
            $companyInfo->addMedia($logoPath)
                ->preservingOriginal()
                ->toMediaCollection('logo');
        } else {
            $this->command->warn("Logo nie znalezione: {$logoPath}");
        }
    }
}
