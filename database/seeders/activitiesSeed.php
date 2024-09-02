<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Activity;

class activitiesSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activity = new Activity();
        $activity->activity_occupation = 'Material de referencia';
        $activity->save();

        $activity2 = new Activity();
        $activity2->activity_occupation = 'Investigación';
        $activity2->save();

        $activity3 = new Activity();
        $activity3->activity_occupation = 'Enseñanaza';
        $activity3->save();

        $activity4 = new Activity();
        $activity4->activity_occupation = 'Consulta';
        $activity4->save();

        $activity5 = new Activity();
        $activity5->activity_occupation = 'Idiomas';
        $activity5->save();

        $activity6 = new Activity();
        $activity6->activity_occupation = 'Lectura';
        $activity6->save();
    }
}
