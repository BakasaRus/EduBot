<?php

namespace App;

use ATehnix\VkClient\Client;
use ATehnix\VkClient\Requests\Request;
use Carbon\Carbon;

class Bot
{
    const KEYBOARDS = [
        'empty' => '{"buttons":[],"one_time":true}',

        'test_selection' => '
            { 
                "one_time": false, 
                "buttons": [ 
                    [{ 
                        "action": { 
                            "type": "text", 
                            "payload": "{\"command\": \"list\"}", 
                            "label": "Список тестов" 
                        }, 
                        "color": "primary" 
                    }]
                ] 
            } 
        ',

        'test_action' => '
            { 
                "one_time": false, 
                "buttons": [ 
                    [{ 
                        "action": { 
                            "type": "text", 
                            "payload": "{\"command\": \"pass\"}", 
                            "label": "Пройти тест" 
                        }, 
                        "color": "primary" 
                    }],
                    [{ 
                        "action": { 
                            "type": "text", 
                            "payload": "{\"command\": \"results\"}", 
                            "label": "Результаты" 
                        }, 
                        "color": "default" 
                    }, 
                    { 
                        "action": { 
                            "type": "text", 
                            "payload": "{\"command\": \"back\"}", 
                            "label": "Назад" 
                        }, 
                        "color": "default" 
                    }]
                ] 
            } 
        ',

        'test_confirmation' => ' 
            { 
                "one_time": true, 
                "buttons": [ 
                    [{ 
                        "action": { 
                            "type": "text", 
                            "payload": "{\"command\": \"start\"}", 
                            "label": "Да" 
                        }, 
                        "color": "positive" 
                    }, 
                    { 
                        "action": { 
                            "type": "text", 
                            "payload": "{\"command\": \"cancel\"}", 
                            "label": "Нет" 
                        }, 
                        "color": "negative" 
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
        $keyboard = static::KEYBOARDS['empty'];
        $payload = $data['payload'] ?? null;
        $command = $payload ? json_decode($payload)->command : "";

        $requests = collect();

        switch ($subscriber->state) {
            case "test_selection":
                /*
                 * If $testNumber cannot be parsed to integer,
                 * it'll be equal to 0, and $test will be null.
                 */
                $testNumber = (int)$data['text'];
                $test = Test::find($testNumber);
                if (!is_null($test)) {
                    $subscriber->test_id = $test->id;
                    $subscriber->state = "test_action";
                    $subscriber->save();

                    $message = __('bot.test_action', [
                        'name' => $test->name,
                        'description' => $test->description
                    ]);
                    $keyboard = self::KEYBOARDS['test_action'];
                }
                else {
                    $list = Test::availableList();
                    if (is_null($list))
                        $message = __('bot.no_tests', [
                            'name' => $subscriber->name
                        ]);
                    else
                        $message = __('bot.test_list', [
                            'name' => $subscriber->name,
                            'list' => $list
                        ]);
                    $keyboard = self::KEYBOARDS['test_selection'];
                }

                $requests->push(compact('message', 'keyboard'));
                break;

            case "test_action":
                $test = $subscriber->current_test;
                $info = $subscriber->test_info;
                if ($command == "pass") {
                    if ($test->max_attempts > $info->attempts)
                    {
                        $subscriber->state = "test_confirmation";
                        $subscriber->save();

                        $message = __('bot.test_rules', [
                            'time' => $test->time_limit_humans
                        ]);
                        $requests->push(compact('message', 'keyboard'));

                        $availableAttempts = $test->max_attempts - $info->attempts;
                        $message = trans_choice('bot.test_confirmation', $availableAttempts, [
                            'count' => $availableAttempts
                        ]);
                        $keyboard = self::KEYBOARDS['test_confirmation'];
                        $requests->push(compact('message', 'keyboard'));
                    }
                    else {
                        $message = __('bot.test_no_attempts');
                        $keyboard = self::KEYBOARDS['test_action'];
                        $requests->push(compact('message', 'keyboard'));
                    }
                }
                elseif ($command == "results") {
                    if ($info->attempts == 0)
                        $message = __('bot.no_results');
                    else
                        $message = __('bot.results', [
                            'name' => $test->name,
                            'total' => $info->max_points,
                            'correct' => $info->points,
                            'percentage' => $info->percentage
                        ]);
                    $keyboard = self::KEYBOARDS['test_action'];
                    $requests->push(compact('message', 'keyboard'));
                }
                else {
                    $subscriber->state = "test_selection";
                    $subscriber->save();

                    $list = Test::availableList($subscriber);
                    if (is_null($list))
                        $message = __('bot.no_tests', [
                            'name' => $subscriber->name
                        ]);
                    else
                        $message = __('bot.test_list', [
                            'name' => $subscriber->name,
                            'list' => $list
                        ]);
                    $keyboard = self::KEYBOARDS['test_selection'];
                    $requests->push(compact('message', 'keyboard'));
                }
                break;

            case "test_confirmation":
                if ($command == "start") {
                    $subscriber->startTest();
                    $subscriber->current_question()->associate($subscriber->current_test->questions()->first());
                    $subscriber->state = "test_question";
                    $subscriber->save();

                    $message = __('bot.test_question', [
                        'current' => $subscriber->questions()->where('test_id', $subscriber->test_id)->count() + 1,
                        'total' => $subscriber->current_test->questions()->count(),
                        'text' => $subscriber->current_question->text
                    ]);
                    $requests->push(compact('message', 'keyboard'));
                }
                else {
                    $subscriber->state = "test_action";
                    $subscriber->save();

                    $message = __('bot.test_action', [
                        'name' => $subscriber->current_test->name,
                        'description' => $subscriber->current_test->description
                    ]);
                    $keyboard = self::KEYBOARDS['test_action'];
                    $requests->push(compact('message', 'keyboard'));
                }

                break;

            case "test_question":
                $test = $subscriber->current_test;
                $info = $subscriber->test_info;

                $endOfTest = $info->started_at->addMinutes($test->time_limit);
                $timeIsUp = Carbon::now()->greaterThan($endOfTest);

                if ($timeIsUp) {
                    $message = __('bot.time_is_up', [
                        'time' => $test->time_limit_humans
                    ]);
                    $requests->push(compact('message', 'keyboard'));
                }
                else {
                    $subscriber->questions()->attach([
                        $subscriber->question_id => ['answer' => $data['text']]
                    ]);
                    if ($subscriber->current_question->correct_answer == $data['text']) {
                        $info->points++;
                        $info->save();
                    }
                    $subscriber->save();

                    $used = $subscriber->questions()->where('test_id', $subscriber->test_id)->get()->pluck('id');
                    $available = $test->questions()->whereNotIn('id', $used)->get();
                }

                if ($timeIsUp || $available->isEmpty()) {
                    $subscriber->state = "test_selection";
                    $subscriber->save();
                    $subscriber->finishTest();

                    $message = __('bot.results', [
                        'name' => $test->name,
                        'total' => $info->max_points,
                        'correct' => $info->points,
                        'percentage' => $info->percentage
                    ]);
                    $keyboard = self::KEYBOARDS['test_selection'];
                    $requests->push(compact('message', 'keyboard'));
                }
                else {
                    $subscriber->question_id = $available->first()->id;
                    $subscriber->save();
                    $subscriber->load('current_question');
                    $message = __('bot.test_question', [
                        'current' => $subscriber->questions()->where('test_id', $subscriber->test_id)->count() + 1,
                        'total' => $subscriber->current_test->questions()->count(),
                        'text' => $subscriber->current_question->text
                    ]);
                    $requests->push(compact('message', 'keyboard'));
                }

                break;

            default:
                $message = __('bot.unknown');
                $subscriber->state = "test_selection";
                $subscriber->save();
                $requests->push(compact('message', 'keyboard'));
                break;
        }

        $requests->transform(function ($item) use ($data) {
            return new Request('messages.send', [
                'peer_id' => $data['from_id'],
                'random_id' => random_int(PHP_INT_MIN, PHP_INT_MAX),
                'message' => $item['message'],
                'keyboard' => $item['keyboard']
            ]);
        });

        $api = new Client('5.92');
        $api->setDefaultToken(config('services.vk.group_token'));
        foreach ($requests as $request) {
            $api->send($request);
        }
    }
}