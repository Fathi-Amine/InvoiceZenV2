<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Section;
use App\Models\Customer;
use Illuminate\Support\Str;
use App\Enums\InvoiceStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Invoice::create([
            'serial_number' => Str::random(2) . rand(1000, 9999),
            'invoice_Date' => now(),
            'due_date' => now()->addDays(7),
            'customer_id' => Customer::inRandomOrder()->first()->user_id,
            'product_id' => Product::inRandomOrder()->first()->id,
            'status'=> InvoiceStatus::Draft,
            'gross_price' => rand(0, 1000) . '.' . rand(0, 99),
            'discount' => rand(0, 10) . '.' . rand(0, 99),
            'TVA' => rand(0, 10) . '.' . rand(0, 99),
            'TVA_rate' => rand(0, 10) . '.' . rand(0, 99),
            'total' => rand(0, 1000) . '.' . rand(0, 99),
            'note' => Factory::create()->text,

        ]);
        Invoice::create([
            'serial_number' => Str::random(2) . rand(1000, 9999),
            'invoice_Date' => now(),
            'due_date' => now()->addDays(7),
            'customer_id' => Customer::inRandomOrder()->first()->user_id,
            'product_id' => Product::inRandomOrder()->first()->id,
            'status'=> InvoiceStatus::Draft,
            'gross_price' => rand(0, 1000) . '.' . rand(0, 99),
            'discount' => rand(0, 10) . '.' . rand(0, 99),
            'TVA' => rand(0, 10) . '.' . rand(0, 99),
            'TVA_rate' => rand(0, 10) . '.' . rand(0, 99),
            'total' => rand(0, 1000) . '.' . rand(0, 99),
            'note' => Factory::create()->text,

        ]);
    }
}
