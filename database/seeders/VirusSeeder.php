<?php

namespace Database\Seeders;

use App\Models\Virus;
use Illuminate\Database\Seeder;

class VirusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $viruses = [
            [
                'name' => 'HIV',
                'latin_name' => 'Human Immunodeficiency Virus',
                'description' => 'HIV is a virus that attacks cells that help the body fight infection, making a person more vulnerable to other infections and diseases.',
            ],
            [
                'name' => 'Hepatitis B',
                'latin_name' => 'Hepatitis B Virus',
                'description' => 'Hepatitis B is a virus that causes inflammation of the liver. It is spread through contact with infected blood or body fluids.',
            ],
            [
                'name' => 'Hepatitis C',
                'latin_name' => 'Hepatitis C Virus',
                'description' => 'Hepatitis C is a virus that causes inflammation of the liver. It is spread through contact with infected blood or body fluids.',
            ],
            [
                'name' => 'Hepatitis D',
                'latin_name' => 'Hepatitis D Virus',
                'description' => 'Hepatitis D is a virus that causes inflammation of the liver. It is spread through contact with infected blood or body fluids.',
            ],
            [
                'name' => 'Hepatitis E',
                'latin_name' => 'Hepatitis E Virus',
                'description' => 'Hepatitis E is a virus that causes inflammation of the liver. It is spread through contact with infected blood or body fluids.',
            ],
            [
                'name' => 'Influenza',
                'latin_name' => 'Influenza Virus',
                'description' => 'Influenza is a virus that causes an infection of the nose, throat, and lungs. It is spread through contact with infected blood or body fluids.',
            ],
            [
                'name' => 'Mumps',
                'latin_name' => 'Mumps Virus',
                'description' => 'Mumps is a virus that causes an infection of the salivary glands. It is spread through contact with infected blood or body fluids.',
            ],
            [
                'name' => 'Measles',
                'latin_name' => 'Measles Virus',
                'description' => 'Measles is a virus that causes an infection of the nose, throat, and lungs. It is spread through contact with infected blood or body fluids.',
            ],
            [
                'name' => 'Meningitis',
                'latin_name' => 'Meningitis Virus',
                'description' => 'Meningitis is a virus that causes an infection of the nose, throat, and lungs. It is spread through contact with infected blood or body fluids.',
            ],
        ];

        Virus::insert($viruses);
    }
}
