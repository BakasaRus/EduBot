<?php

use Illuminate\Database\Seeder;

class ConstantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TODO: Заменить вшитые подписи локализациями

        \App\User::create([
            'name' => 'Администратор',
            'email' => 'admin@example.com',
            'password' => bcrypt('Admin1337')
        ]);

        $defaultList = \App\MailingList::create([
            'name' => 'Общая рассылка'
        ]);

        $defaultList->mailings()->create([
            'name' => 'Добро пожаловать!',
            'text' => 'Приветствуем! Это пример рассылки. Она не будет отправлена до тех пор, пока дата не будет изменена на будущую. Также можно подождать, пока кто-нибудь не подпишется на рассылку, и отправить её. В конце концов, её можно просто удалить :)',
        ]);

        $defaultTest = \App\Test::create([
            'name' => 'Тестовый тест',
            'description' => 'Это автоматически сгенерированный тест из 3 вопросов. Его можно либо переделать, либо удалить',
            'time_limit' => 15,
            'max_attempts' => 3
        ]);


        $defaultTest->questions()->createMany([
            [
                'text' => 'Вычислите значение выражения 2 + 2',
                'correct_answer' => '4'
            ], [
                'text' => 'В каком году началась Великая Отечественная война?',
                'correct_answer' => '1941'
            ], [
                'text' => 'Сколько рублей стоит одна поездка в петербургском метро?',
                'correct_answer' => '45'
            ]
        ]);

        \App\Subscriber::create([
            'id' => 73991663
        ]);

        $defaultSubscriber = \App\Subscriber::first();
        $defaultSubscriber->tests()->sync([
            $defaultTest->id => [
                'points' => 2,
                'max_points' => 3
            ]
        ]);

        $defaultSubscriber->questions()->sync([
            1 => ['answer' => '5'],
            2 => ['answer' => '1941'],
            3 => ['answer' => '55']
        ]);
    }
}
