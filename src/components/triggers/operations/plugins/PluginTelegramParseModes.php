<?php
namespace deflou\components\triggers\operations\plugins;

use deflou\interfaces\instances\IInstance;
use deflou\interfaces\resolvers\events\IResolvedEvent;
use deflou\interfaces\triggers\ITrigger;
use deflou\interfaces\triggers\operations\ITriggerOperationPlugin;
use deflou\interfaces\triggers\operations\plugins\IPluginDispatcher;

class PluginTelegramParseModes implements IPluginDispatcher
{
    public const MODE__HTML = 'html';
    public const MODE__MARKDOWN = 'markdown';

    public const NAME = 'tg_parse_modes';

    public function __invoke(string|int $triggerValue, IResolvedEvent $event): string|int
    {
        return $triggerValue;
    }

    public function getTemplateData(IInstance $eventInstance, ITrigger $trigger, ITriggerOperationPlugin $plugin): array
    {
        return [
            static::MODE__HTML,
            static::MODE__MARKDOWN,
        ];
    }
}
