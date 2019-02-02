<?php

namespace App;

use ATehnix\LaravelVkRequester\Models\VkRequest;
use Illuminate\Support\Facades\Log;

class Bot
{
    /**
     * Creates a new subscriber or restores existing one after VK Callback.
     *
     * @param $id
     */
    static function createSubscriber($id) {
        Subscriber::onlyTrashed()->firstOrCreate(['id' => $id])->restore();
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

    static function processMessage($data) {
        Bot::createSubscriber($data['from_id']);

        VkRequest::create([
            'method' => 'message.send',
            'parameters' => [
                'peer_id' => $data['from_id'],
                'reply_to' => $data['id'],
                'message' => 'Вы мне написали вот это:'
            ],
            'token' => config('services.vk.group_token')
        ]);
    }
}