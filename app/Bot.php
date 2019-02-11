<?php

namespace App;

use ATehnix\VkClient\Client;
use Illuminate\Support\Facades\Log;

class Bot
{
    const MESSAGES = [
        'test_selection' =>
            "Здравствуйте, %s!
            На данный момент доступны следующие тесты:
            
            %s
            Введите номер теста для сдачи или просмотра результатов.",

        'no_tests' =>
            "Здравствуйте, %s!
            На данный момент доступных тестов нет.",

        'test_confirmation' =>
            "Вы выбрали тест \"%s\".
            %s
            
            При отсутствии ответа на вопрос следует отправить \"Нет ответа\". Возможность вернуться к предыдущему вопросу отсутствует.
            
            У Вас осталось %d попыток. На тест даётся %d минут. Приступить?",

        'test_question' =>
            "Вопрос %d
            
            %s",

        'results' =>
            "Результаты теста \"%s\"
            
            Всего вопросов: %d
            Пройдено вопросов: %d
            Отвечено правильно: %d",

        'unknown' => "Бот в странном состоянии, возвращаемся к начальному."
    ];

    private $keyboards = [
        'main_menu' => ' 
            { 
                "one_time": false, 
                "buttons": [ 
                  [{ 
                    "action": { 
                      "type": "text", 
                      "payload": "{\"button\": \"1\"}", 
                      "label": "Red" 
                    }, 
                    "color": "negative" 
                  }, 
                 { 
                    "action": { 
                      "type": "text", 
                      "payload": "{\"button\": \"2\"}", 
                      "label": "Green" 
                    }, 
                    "color": "positive" 
                  }], 
                  [{ 
                    "action": { 
                      "type": "text", 
                      "payload": "{\"button\": \"3\"}", 
                      "label": "White" 
                    }, 
                    "color": "default" 
                  }, 
                 { 
                    "action": { 
                      "type": "text", 
                      "payload": "{\"button\": \"4\"}", 
                      "label": "Blue" 
                    }, 
                    "color": "primary" 
                  }] 
                ] 
              } 
        '
    ];

    /**
     * Creates a new subscriber or restores existing one after VK Callback.
     *
     * @param $id
     */
    static function createSubscriber($id) {
        $subscriber = Subscriber::withTrashed()
                                ->firstOrCreate(['id' => $id]);
        $subscriber->restore();
        $subscriber->lists()->syncWithoutDetaching(1);

        $subscriber->setNameFromVk();
    }

    /**
     * Deletes a subscriber after VK Callback.
     * If subscriber does not exist, nothing will happen due to Laravel behavior.
     *
     * @param $id
     */
    static function deleteSubscriber($id) {
        try {
            Subscriber::find($id)->delete();
        } catch (\Exception $e) {
            Log::error('Looks like we do not have primary key on Subscribers model. Interesting!');
        }
    }

    /**
     * Send a reply to user's message.
     *
     * @param $data
     * @throws \ATehnix\VkClient\Exceptions\VkException
     */
    static function processMessage($data) {
        /*
         * What if we get a message from a person who doesn't allow messages explicitly?
         * Well, VK send messages_allow event in this case :)
         */
        $subscriber = Subscriber::find($data['from_id']);
        $message = "";

        switch ($subscriber->state) {
            case "test_selection":
                $list = Test::availableList($subscriber);
                if (is_null($list))
                    $message = sprintf(static::MESSAGES['no_tests'], $subscriber->name);
                else
                    $message = sprintf(static::MESSAGES['test_selection'], $subscriber->name, $list);
                break;

            case "test_confirmation":
                $message = static::MESSAGES['test_confirmation'];
                break;

            case "results":
                $message = static::MESSAGES['results'];
                break;

            default:
                $message = static::MESSAGES['unknown'];
                $subscriber->state = "test_selection";
                $subscriber->save();
                break;
        }

        $api = new Client('5.92');
        $api->setDefaultToken(config('services.vk.group_token'));
        $api->request('messages.send', [
            'peer_id' => $data['from_id'],
            'random_id' => random_int(PHP_INT_MIN, PHP_INT_MAX),
            'message' => $message
        ]);
    }
}