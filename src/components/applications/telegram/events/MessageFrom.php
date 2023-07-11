<?php
namespace deflou\components\applications\telegram\events;

enum MessageFrom: string
{
    case NAME = 'message_from';

    case PARAM__BOT_NAME = 'bot_name';
    case PARAM__CHAT_ID = 'chat_id';
    case PARAM__TOPIC_ID = 'topic_id';
    case PARAM__MESSAGE = 'message';
    case PARAM__MESSAGE_ID = 'message_id';
    case PARAM__USER_FROM__USERNAME = 'user_from__username';
}
