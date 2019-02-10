<?php

namespace App;

use ATehnix\VkClient\Client;
use Illuminate\Support\Facades\Log;

class Bot
{
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
        Bot::createSubscriber($data['from_id']);
        $message = "";

        $available = Test::where('is_available', true)->get();
        foreach ($available as $test) {
            $message .= $test->name . "\r\n" .
                        $test->description . "\r\n\r\n";
        }

        if ($message == "")
            $message = "Доступных тестов нет :(";

        $api = new Client('5.92');
        $api->setDefaultToken(config('services.vk.group_token'));
        $api->request('messages.send', [
            'peer_id' => $data['from_id'],
            'random_id' => random_int(PHP_INT_MIN, PHP_INT_MAX),
            'message' => $message
        ]);
    }
}