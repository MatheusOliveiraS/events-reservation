<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Event::create([
            'name' => "Obon",
            'description' => "The festival is based on a legend about a Buddhist monk called Mogallana. The story goes that Mogallana could see into the afterlife and saved his deceased mother from "
            ."going to hell by giving offerings to Buddhist monks. Having gained redemption for his mother, he danced in celebration, joined by others in a large circle. This dance is known as the Bon "
            ."Odori dance.",
            'occurence_date' => "2027-08-13 13:00:00",
            'tickets_remaining' => 10
        ]);

        Event::create([
            'name' => "Carnival",
            'description' => "This festival is known for being a time of great indulgence before Lent (which is a time stressing the opposite), with drinking, overeating, and various other activities of "
            ."indulgence being performed. During Lent, dairy and animal products are eaten less, if at all, and individuals make a Lenten Sacrifice, thus giving up a certain object or activity of desire. "
            ."On the final day of the season, Shrove Tuesday, many traditional Christians, such as Lutherans, Anglicans, and Roman Catholics, \"make a special point of self-examination, of considering "
            ."what wrongs they need to repent, and what amendments of life or areas of spiritual growth they especially need to ask God's help in dealing with.\"",
            'occurence_date' => "2013-03-03 10:00:00",
            'tickets_remaining' => 5
        ]);

        Event::create([
            'name' => "Swiss Yodeling Festival",
            'description' => "Natural yodeling exists all over the world, but especially in mountainous and inaccessible regions where the technique was used to communicate over extended "
            ."distances. Although yodeling was probably used back in the Stone Age, the choir singing only developed in the 19th century.",
            'occurence_date' => "2025-06-17 14:00:00",
            'tickets_remaining' => 1
        ]);

        Event::create([
            'name' => "Tanabata Matsuri",
            'description' => "This event celebrates the meeting of the deities Orihime and Hikoboshi (represented by the stars Vega and Altair respectively). According to legend, the Milky "
            ."Way separates these lovers, and they are allowed to meet only once a year on the seventh day of the seventh lunar month of the lunisolar calendar.",
            'occurence_date' => "2007-07-07 13:00:00",
            'tickets_remaining' => 200
        ]);

        Event::create([
            'name' => "Sechseläuten",
            'description' => "This Zurich Spring custom got its unusual name from the medieval custom of ringing a bell of the Grossmünster every evening at six o'clock to proclaim the end of the "
            ."working day during the summer semester. Since it marked the beginning of springtime, the first ringing of the bell provided a good opportunity for a celebration.",
            'occurence_date' => "2047-04-21 09:00:00",
            'tickets_remaining' => 0
        ]);
    }
}
