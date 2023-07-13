<?php
namespace deflou\components\plugins\telegram;

use deflou\components\plugins\triggers\PluginTemplateHtml;
use deflou\components\triggers\operations\plugins\PluginTelegramParseModes;
use deflou\interfaces\triggers\ITemplateHtml;
use extas\components\parameters\Param;
use extas\interfaces\parameters\IParam;

class PluginTemplateHtmlParseModes extends PluginTemplateHtml
{
    public const STAGE = self::STAGE__PREFIX . PluginTelegramParseModes::NAME;

    protected array $descriptions = [
        PluginTelegramParseModes::MODE__HTML => 'Можно использовать <b>text</b> для выделения жирным и т.п.',
        PluginTelegramParseModes::MODE__MARKDOWN => 'Можно использовать **text** для выделения жирным и т.п.',
    ];
    
    protected function renderEachItem($templateData, $contextParam, $render, $data): array
    {
        $items = [];

        foreach ($templateData as $parseMode) {
            $curData = [
                ITemplateHtml::FIELD__PARAM => $contextParam,
                IParam::FIELD__NAME => $parseMode,
                IParam::FIELD__TITLE => ucfirst($parseMode),
                IParam::FIELD__DESCRIPTION => $this->descriptions[$parseMode] ?? $parseMode,
                'plugin' => new Param([
                    Param::FIELD__NAME => PluginTelegramParseModes::NAME,
                    Param::FIELD__VALUE => $parseMode,
                    Param::FIELD__TITLE => ucfirst($parseMode)
                ])
            ];

            $items[] = $render->render($this->itemViewPath, $curData);
        }

        return $items;
    }
}
