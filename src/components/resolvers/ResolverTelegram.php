<?php
namespace deflou\components\resolvers;

use deflou\components\applications\Telegram;
use deflou\components\exceptions\telegram\MissedRequiredEventParam;
use deflou\interfaces\resolvers\events\IResolvedEvent;

/**
 * Event:
 * POST deflou.url
 * BODY
 * {
 *  "bot_token": "<string>", 
 *  "bot_name": "<string>",
 *  "chat_id": "<int>"
 *  "topic_id": "<int>",
 *  "message": "<string>",
 *  "message_id": "<int>",
 *  "user_from__username": "<string>"
 * }
 * 
 * Operation
 * <instance.options.options__method> <instance.options.options__base_url>
 * HEADERS
 * - X-DF-BOT-TOKEN
 * BODY depends on method, use `json` method to send json data with the POST method.
 * - chat_id
 * - topic_id
 * - message
 * - parse_mode
 */
class ResolverTelegram extends ResolverHttp
{
    /**
     * Проверить наличие токена и всех параметров события
     *
     * @return IResolvedEvent
     */
    public function resolveEvent(): IResolvedEvent
    {
        $resolvedEvent = parent::resolveEvent();
        $currentEventParams = $resolvedEvent->buildParams();
        $instance = $resolvedEvent->getInstance();

        Telegram::TOKEN->eventHasToken($instance, $resolvedEvent);

        $event = $instance->buildEvents()->buildOne($resolvedEvent->getName());
        $requiredParams = $event->buildParams()->buildAll();

        foreach ($requiredParams as $name => $param) {
            if (!$currentEventParams->hasOne($name)) {
                throw new MissedRequiredEventParam($param->getTitle() . ' (' . $param->getName() . ')');
            }
        }

        return $resolvedEvent;
    }
}
