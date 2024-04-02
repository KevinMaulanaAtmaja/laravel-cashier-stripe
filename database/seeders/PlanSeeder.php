<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create([
            'title' => 'Monthly',
            'slug' => 'monthly',
            'stripe_id' => 'price_1OynyrP5JXOVIdi0VC3ueC93',
        ]);
        Plan::create([
            'title' => 'Yearly',
            'slug' => 'yearly',
            'stripe_id' => 'price_1Oyo2DP5JXOVIdi0CoEEnlct',
        ]);
    }
}
