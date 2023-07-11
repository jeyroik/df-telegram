<?php
namespace deflou\components\applications;

use deflou\components\exceptions\telegram\IncorrectBotToken;
use deflou\components\exceptions\telegram\MissedBotToken;
use deflou\interfaces\instances\IInstance;
use deflou\interfaces\resolvers\events\IResolvedEvent;

enum Telegram: string
{
    case TOKEN = 'bot_token';
    case URL = 'bot_url';

    case NAME = 'telegram';
    case EVENT__MESSAGE_FROM = 'message_from';
    case OPERATION__MESSAGE_TO = 'message_to';

    public function eventHasToken(IInstance $instance, IResolvedEvent $resolvedEvent): bool
    {
        $currentEventParams = $resolvedEvent->buildParams();

        if (!$currentEventParams->hasOne(Telegram::TOKEN->value)) {
            throw new MissedBotToken();
        }

        $correctToken = $instance->buildOptions()->buildOne(Telegram::TOKEN->value)->getValue();
        $currentToken = $currentEventParams->buildOne(Telegram::TOKEN->value)->getValue();

        if ($currentToken != $correctToken) {
            throw new IncorrectBotToken($currentToken);
        }

        return true;
    }
}
