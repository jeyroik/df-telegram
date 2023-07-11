<?php

use deflou\components\applications\Telegram;
use deflou\components\plugins\telegram\PluginRequestHeaders;
use deflou\components\plugins\telegram\PluginTemplateHtmlParseModes;
use deflou\components\triggers\operations\plugins\PluginTelegramParseModes;
use deflou\interfaces\stages\resolvers\http\IStageRequestHeaders;
use deflou\interfaces\triggers\operations\ITriggerOperationPlugin;
use extas\interfaces\plugins\IPlugin;

return [
    'name' => 'jeyroik/df-telegram',
    'plugins' => [
        [
            IPlugin::FIELD__CLASS => PluginRequestHeaders::class,
            IPlugin::FIELD__STAGE => IStageRequestHeaders::NAME
        ],
        [
            IPlugin::FIELD__CLASS => PluginTemplateHtmlParseModes::class,
            IPlugin::FIELD__STAGE => PluginTemplateHtmlParseModes::STAGE
        ]
    ],
    'trigger_operation_plugins' => [
        [
            ITriggerOperationPlugin::FIELD__NAME => PluginTelegramParseModes::NAME,
            ITriggerOperationPlugin::FIELD__TITLE => 'Режимы разбора',
            ITriggerOperationPlugin::FIELD__DESCRIPTION => 'Подставить режимы разбора',
            ITriggerOperationPlugin::FIELD__CLASS => PluginTelegramParseModes::class,
            ITriggerOperationPlugin::FIELD__APPLICATION_NAME => Telegram::NAME->value
        ]
    ]
];
