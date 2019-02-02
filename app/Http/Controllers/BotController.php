<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bot;

class BotController extends Controller
{
    /**
     * Handle the incoming request from VK Callback API.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     * @throws \ATehnix\VkClient\Exceptions\VkException
     */
    public function __invoke(Request $request)
    {
        $all = $request->json()->all();

        $type = $all['type'];
        $group_id = $all['group_id'];
        $data = $all['object'] ?? null;

        if ($group_id != config('services.vk.group_id'))
            return abort(412, 'Wrong group ID. Please check that you have connected this bot to right group');

        switch ($type) {
            case 'confirmation':
                return config('services.vk.group_confirmation');
                break;

            case 'message_allow':
                Bot::createSubscriber($data['user_id']);
                break;

            case 'message_deny':
                Bot::deleteSubscriber($data['user_id']);
                break;

            case 'message_new':
                Bot::processMessage($data);
                break;
        }

        return 'ok';
    }
}
