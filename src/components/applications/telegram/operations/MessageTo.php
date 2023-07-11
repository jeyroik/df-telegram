<?php
namespace deflou\components\applications\telegram\operations;

enum MessageTo: string
{
    case NAME = 'message_to';

    case PARAM__CHAT_ID = 'chat_id';
    case PARAM__TOPIC_ID = 'topic_id';
    case PARAM__MESSAGE = 'message';
    case PARAM__PARSE_MODE = 'parse_mode';
}
