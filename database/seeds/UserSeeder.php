<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$names_raw = json_decode('
[{"name":{"title":"mademoiselle","first":"stella","last":"leclercq"},"email":"stella.leclercq@example.com","phone":"(833)-404-0684"},{"name":{"title":"mademoiselle","first":"léa","last":"picard"},"email":"léa.picard@example.com","phone":"(675)-821-2040"},{"name":{"title":"mademoiselle","first":"giulia","last":"arnaud"},"email":"giulia.arnaud@example.com","phone":"(630)-294-4738"},{"name":{"title":"madame","first":"olivia","last":"leclercq"},"email":"olivia.leclercq@example.com","phone":"(521)-119-9873"},{"name":{"title":"madame","first":"justine","last":"colin"},"email":"justine.colin@example.com","phone":"(158)-614-2183"},{"name":{"title":"madame","first":"andréa","last":"nguyen"},"email":"andréa.nguyen@example.com","phone":"(413)-411-2695"},{"name":{"title":"mademoiselle","first":"léa","last":"lefebvre"},"email":"léa.lefebvre@example.com","phone":"(949)-977-4091"},{"name":{"title":"mademoiselle","first":"sélène","last":"mercier"},"email":"sélène.mercier@example.com","phone":"(763)-720-5814"},{"name":{"title":"mademoiselle","first":"valentine","last":"marchand"},"email":"valentine.marchand@example.com","phone":"(016)-991-9295"},{"name":{"title":"madame","first":"léa","last":"clement"},"email":"léa.clement@example.com","phone":"(906)-149-0779"},{"name":{"title":"madame","first":"lila","last":"caron"},"email":"lila.caron@example.com","phone":"(247)-233-9591"},{"name":{"title":"mademoiselle","first":"agathe","last":"roger"},"email":"agathe.roger@example.com","phone":"(093)-679-4262"},{"name":{"title":"mademoiselle","first":"laly","last":"morin"},"email":"laly.morin@example.com","phone":"(077)-658-4583"},{"name":{"title":"mademoiselle","first":"emeline","last":"rousseau"},"email":"emeline.rousseau@example.com","phone":"(206)-165-2754"},{"name":{"title":"madame","first":"angelina","last":"dubois"},"email":"angelina.dubois@example.com","phone":"(590)-115-1952"},{"name":{"title":"madame","first":"amelia","last":"arnaud"},"email":"amelia.arnaud@example.com","phone":"(782)-361-6537"},{"name":{"title":"madame","first":"louise","last":"muller"},"email":"louise.muller@example.com","phone":"(846)-593-9042"},{"name":{"title":"madame","first":"clara","last":"da silva"},"email":"clara.dasilva@example.com","phone":"(775)-346-3870"},{"name":{"title":"mademoiselle","first":"daphné","last":"adam"},"email":"daphné.adam@example.com","phone":"(863)-949-3403"},{"name":{"title":"madame","first":"garance","last":"fontai"},"email":"garance.fontai@example.com","phone":"(954)-384-6877"},{"name":{"title":"mademoiselle","first":"lola","last":"martinez"},"email":"lola.martinez@example.com","phone":"(283)-485-7141"},{"name":{"title":"mademoiselle","first":"albane","last":"blanc"},"email":"albane.blanc@example.com","phone":"(915)-829-4286"},{"name":{"title":"mademoiselle","first":"mélody","last":"brunet"},"email":"mélody.brunet@example.com","phone":"(429)-650-4637"},{"name":{"title":"madame","first":"faustine","last":"rey"},"email":"faustine.rey@example.com","phone":"(442)-728-4174"},{"name":{"title":"mademoiselle","first":"lila","last":"simon"},"email":"lila.simon@example.com","phone":"(917)-675-2686"},{"name":{"title":"mademoiselle","first":"chloé","last":"dupuis"},"email":"chloé.dupuis@example.com","phone":"(212)-903-8200"},{"name":{"title":"mademoiselle","first":"elya","last":"pierre"},"email":"elya.pierre@example.com","phone":"(628)-014-0597"},{"name":{"title":"mademoiselle","first":"anaïs","last":"olivier"},"email":"anaïs.olivier@example.com","phone":"(175)-078-4815"},{"name":{"title":"mademoiselle","first":"margot","last":"carpentier"},"email":"margot.carpentier@example.com","phone":"(407)-883-1761"},{"name":{"title":"mademoiselle","first":"enora","last":"vincent"},"email":"enora.vincent@example.com","phone":"(102)-755-1248"},{"name":{"title":"mademoiselle","first":"laura","last":"renard"},"email":"laura.renard@example.com","phone":"(818)-198-2017"},{"name":{"title":"madame","first":"elsa","last":"petit"},"email":"elsa.petit@example.com","phone":"(179)-537-3514"},{"name":{"title":"madame","first":"héloïse","last":"brunet"},"email":"héloïse.brunet@example.com","phone":"(350)-267-4630"},{"name":{"title":"mademoiselle","first":"lila","last":"marie"},"email":"lila.marie@example.com","phone":"(134)-830-2137"},{"name":{"title":"madame","first":"bérénice","last":"giraud"},"email":"bérénice.giraud@example.com","phone":"(383)-353-0770"},{"name":{"title":"madame","first":"camille","last":"mercier"},"email":"camille.mercier@example.com","phone":"(522)-398-7532"},{"name":{"title":"mademoiselle","first":"anaïs","last":"petit"},"email":"anaïs.petit@example.com","phone":"(824)-325-0186"},{"name":{"title":"madame","first":"charlotte","last":"marchand"},"email":"charlotte.marchand@example.com","phone":"(380)-921-0600"},{"name":{"title":"mademoiselle","first":"aurore","last":"aubert"},"email":"aurore.aubert@example.com","phone":"(805)-216-3254"},{"name":{"title":"mademoiselle","first":"eden","last":"faure"},"email":"eden.faure@example.com","phone":"(898)-413-1168"}]');

        $names = [];

        foreach ($names_raw as $name) {
            $names[] = [
                'name' => ucfirst($name->name->first) . ' ' . ucfirst($name->name->last),
                'email' => $name->email,
                'phone' => $name->phone
            ];
        }

        for( $i=0; $i < 30; $i++ ) {
            DB::table('users')->insert([
                'name'          => $names[$i]['name'],
                'email'         => $names[$i]['email'],
                'phone'         => $names[$i]['phone'],
                'password'      => bcrypt('123456'),
                'nursery_id'    => rand(1, 15),
                'created_at'    => \Carbon\Carbon::now()
            ]);
        }*/

        factory(App\User::class, 30)->create();
    }
}
