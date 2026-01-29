<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Substation;

class SubstationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Substation::create([
            'name' => 'UPT BENGKULU',
            'latitude' => -3.787107316026355,
            'longitude' => 102.26866473811393,
        ]);

        Substation::create([
            'name' => 'GI SUKAMERINDU',
            'latitude' => -3.787107316026355,
            'longitude' => 102.26866473811393,
        ]);

        Substation::create([
            'name' => 'GI PULAU BAI',
            'latitude' => -3.837991345565958,
            'longitude' => 102.36501299138737,
        ]);

        Substation::create([
            'name' => 'GI PEKALONGAN',
            'latitude' => -3.526611085700103,
            'longitude' => 102.51550005087554,
        ]);

        Substation::create([
            'name' => 'GI/GITET LUBUK LINGGAU',
            'latitude' => -3.2354886899381077,
            'longitude' => 102.85725190167567,
        ]);

        Substation::create([
            'name' => 'GI LAHAT',
            'latitude' => -3.766669999962043,
            'longitude' => 103.51106226806988,
        ]);

        Substation::create([
            'name' => 'GITET LAHAT',
            'latitude' => -3.766669999962043,
            'longitude' => 103.51106226806988,
        ]);

        Substation::create([
            'name' => 'GI PAGARALAM',
            'latitude' => -3.980755605663234,
            'longitude' => 103.22497542651561,
        ]);

        Substation::create([
            'name' => 'GI MANNA',
            'latitude' => -4.113381249165217,
            'longitude' => 102.9334828950627,
        ]);

        Substation::create([
            'name' => 'GI PLTU BANJARSARI',
            'latitude' => -3.722774143708681,
            'longitude' => 103.68932709378139,
        ]);

        Substation::create([
            'name' => 'GI ARGAMAKMUR',
            'latitude' => -3.491479705385356,
            'longitude' => 102.1023794090256,
        ]);

        Substation::create([
            'name' => 'GI PLTU KEBAN AGUNG',
            'latitude' => -3.7502754610802045,
            'longitude' => 103.64537333468415,
        ]);

        Substation::create([
            'name' => 'GI PLTA MUSI',
            'latitude' => -3.589949010360499,
            'longitude' => 102.48567969657056,
        ]);

        Substation::create([
            'name' => 'GI EMPAT LAWANG',
            'latitude' => -3.5487910792295496,
            'longitude' => 103.07854643589124,
        ]);

        Substation::create([
            'name' => 'GI TESS',
            'latitude' => -3.204744639931645,
            'longitude' => 102.31881112534653,
        ]);

        Substation::create([
            'name' => 'GI BINTUHAN',
            'latitude' => -4.756803844464253,
            'longitude' => 103.32750375536737,
        ]);
    }
}
