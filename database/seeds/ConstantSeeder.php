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
    }
}
