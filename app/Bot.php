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
        Subscriber::withTrashed()->firstOrCreate(['id' => $id])->restore();
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
        $api = new Client('5.92');
        $api->setDefaultToken(config('services.vk.group_token'));
        $response = $api->request('messages.send', [
            'peer_id' => $data['from_id'],
            'random_id' => random_int(PHP_INT_MIN, PHP_INT_MAX),
            'reply_to' => $data['id'],
            'message' => 'Это сообщение является ответом на данное'
        ]);
    }
}