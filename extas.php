<?php

use deflou\components\applications\Telegram;
use deflou\components\applications\telegram\operations\MessageTo;
use deflou\components\plugins\telegram\PluginRequestHeaders;
use deflou\components\plugins\telegram\PluginTemplateHtmlParseModes;
use deflou\components\triggers\operations\plugins\PluginTelegramParseModes;
use deflou\interfaces\stages\resolvers\http\IStageRequestHeaders;
use deflou\interfaces\triggers\operations\ITriggerOperationPlugin;
use deflou\interfaces\triggers\values\plugins\IValuePlugin;
use extas\interfaces\parameters\IParam;
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
            IPlugin::FIELD__STAGE => PluginTemplateHtmlParseModes::STAGE,
            IPlugin::FIELD__PARAMETERS => [
                PluginTemplateHtmlParseModes::PARAM__VIEW_HEADER => [
                    IParam::FIELD__NAME => PluginTemplateHtmlParseModes::PARAM__VIEW_HEADER,
                    IParam::FIELD__VALUE => PluginTemplateHtmlParseModes::VIEW__DEFAULT
                ],
                PluginTemplateHtmlParseModes::PARAM__VIEW_ITEM => [
                    IParam::FIELD__NAME => PluginTemplateHtmlParseModes::PARAM__VIEW_ITEM,
                    IParam::FIELD__VALUE => PluginTemplateHtmlParseModes::SYS_OPTION__ITEM_BADGE
                ],
                PluginTemplateHtmlParseModes::PARAM__VIEW_ITEMS => [
                    IParam::FIELD__NAME => PluginTemplateHtmlParseModes::PARAM__VIEW_ITEMS,
                    IParam::FIELD__VALUE => PluginTemplateHtmlParseModes::SYS_OPTION__ITEMS_BADGE,
                ],
                PluginTemplateHtmlParseModes::PARAM__ACTIVE => [
                    IParam::FIELD__NAME => PluginTemplateHtmlParseModes::PARAM__ACTIVE,
                    IParam::FIELD__VALUE => PluginTemplateHtmlParseModes::ACTIVE__NO
                ],
                PluginTelegramParseModes::NAME => [
                    IParam::FIELD__NAME => PluginTelegramParseModes::NAME,
                    IParam::FIELD__TITLE => '@item.title',
                    IParam::FIELD__DESCRIPTION => 'Кликните по нужному режиму, чтобы выбрать его',
                    IParam::FIELD__VALUE => '@item.name'
                ]
            ]
        ]
    ],
    'trigger_value_plugins' => [
        [
            IValuePlugin::FIELD__NAME => PluginTelegramParseModes::NAME,
            IValuePlugin::FIELD__TITLE => 'Режимы разбора',
            IValuePlugin::FIELD__DESCRIPTION => 'Подставить режимы разбора',
            IValuePlugin::FIELD__CLASS => PluginTelegramParseModes::class,
            IValuePlugin::FIELD__APPLICATION_NAME => Telegram::NAME->value,
            IValuePlugin::FIELD__APPLY_TO_PARAM => [MessageTo::PARAM__PARSE_MODE->value]
        ]
    ]
];
