<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // TypeVoertuig
        DB::table('type_voertuig')->insert([
            ['TypeVoertuig' => 'Personenauto', 'Rijbewijscategorie' => 'B'],
            ['TypeVoertuig' => 'Vrachtwagen', 'Rijbewijscategorie' => 'C'],
            ['TypeVoertuig' => 'Bus', 'Rijbewijscategorie' => 'D'],
            ['TypeVoertuig' => 'Bromfiets', 'Rijbewijscategorie' => 'AM'],
        ]);

        // Instructeur
        DB::table('instructeur')->insert([
            ['Voornaam' => 'Li', 'Tussenvoegsel' => null, 'Achternaam' => 'Zhan', 'Mobiel' => '06-28493827', 'DatumInDienst' => '2015-04-17', 'AantalSterren' => '***'],
            ['Voornaam' => 'Leroy', 'Tussenvoegsel' => null, 'Achternaam' => 'Boerhaven', 'Mobiel' => '06-39398734', 'DatumInDienst' => '2018-06-25', 'AantalSterren' => '*'],
            ['Voornaam' => 'Yoeri', 'Tussenvoegsel' => 'Van', 'Achternaam' => 'Veen', 'Mobiel' => '06-24383291', 'DatumInDienst' => '2010-05-12', 'AantalSterren' => '***'],
            ['Voornaam' => 'Bert', 'Tussenvoegsel' => 'Van', 'Achternaam' => 'Sali', 'Mobiel' => '06-48293823', 'DatumInDienst' => '2023-01-10', 'AantalSterren' => '****'],
            ['Voornaam' => 'Mohammed', 'Tussenvoegsel' => 'El', 'Achternaam' => 'Yassidi', 'Mobiel' => '06-34291234', 'DatumInDienst' => '2010-06-14', 'AantalSterren' => '*****'],
        ]);

        // Voertuig
        DB::table('voertuig')->insert([
            ['Kenteken' => 'AU-67-IO', 'Type' => 'Golf', 'Bouwjaar' => '2017-06-12', 'Brandstof' => 'Diesel', 'TypeVoertuigId' => 1],
            ['Kenteken' => 'TR-24-OP', 'Type' => 'DAF', 'Bouwjaar' => '2019-05-23', 'Brandstof' => 'Diesel', 'TypeVoertuigId' => 2],
            ['Kenteken' => 'TH-78-KL', 'Type' => 'Mercedes', 'Bouwjaar' => '2023-01-01', 'Brandstof' => 'Benzine', 'TypeVoertuigId' => 1],
            ['Kenteken' => '90-KL-TR', 'Type' => 'Fiat 500', 'Bouwjaar' => '2021-09-12', 'Brandstof' => 'Benzine', 'TypeVoertuigId' => 1],
            ['Kenteken' => '34-TK-LP', 'Type' => 'Scania', 'Bouwjaar' => '2015-03-13', 'Brandstof' => 'Diesel', 'TypeVoertuigId' => 2],
            ['Kenteken' => 'YY-OP-78', 'Type' => 'BMW M5', 'Bouwjaar' => '2022-05-13', 'Brandstof' => 'Diesel', 'TypeVoertuigId' => 1],
            ['Kenteken' => 'UU-HH-JK', 'Type' => 'M.A.N', 'Bouwjaar' => '2017-12-03', 'Brandstof' => 'Diesel', 'TypeVoertuigId' => 2],
            ['Kenteken' => 'ST-FZ-28', 'Type' => 'Citroën', 'Bouwjaar' => '2018-01-20', 'Brandstof' => 'Elektrisch', 'TypeVoertuigId' => 1],
            ['Kenteken' => '123-FR-T', 'Type' => 'Piaggio ZIP', 'Bouwjaar' => '2021-02-01', 'Brandstof' => 'Benzine', 'TypeVoertuigId' => 4],
            ['Kenteken' => 'DRS-52-P', 'Type' => 'Vespa', 'Bouwjaar' => '2022-03-21', 'Brandstof' => 'Benzine', 'TypeVoertuigId' => 4],
            ['Kenteken' => 'STP-12-U', 'Type' => 'Kymco', 'Bouwjaar' => '2022-07-02', 'Brandstof' => 'Benzine', 'TypeVoertuigId' => 4],
            ['Kenteken' => '45-SD-23', 'Type' => 'Renault', 'Bouwjaar' => '2023-01-01', 'Brandstof' => 'Diesel', 'TypeVoertuigId' => 3],
        ]);

        // VoertuigInstructeur
        DB::table('voertuig_instructeur')->insert([
            ['VoertuigId' => 1, 'InstructeurId' => 5, 'DatumToekenning' => '2017-06-18'],
            ['VoertuigId' => 3, 'InstructeurId' => 1, 'DatumToekenning' => '2021-09-26'],
            ['VoertuigId' => 9, 'InstructeurId' => 1, 'DatumToekenning' => '2021-09-27'],
            ['VoertuigId' => 4, 'InstructeurId' => 4, 'DatumToekenning' => '2022-08-01'],
            ['VoertuigId' => 5, 'InstructeurId' => 1, 'DatumToekenning' => '2019-08-30'],
            ['VoertuigId' => 10, 'InstructeurId' => 5, 'DatumToekenning' => '2020-02-02'],
        ]);
    }
}