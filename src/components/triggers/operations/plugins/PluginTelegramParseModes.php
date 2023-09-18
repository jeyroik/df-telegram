<?php
namespace deflou\components\triggers\operations\plugins;

use deflou\interfaces\resolvers\events\IResolvedEvent;
use deflou\interfaces\templates\contexts\IContext;
use deflou\interfaces\templates\IWithTemplate;
use deflou\interfaces\triggers\values\plugins\IValuePlugin;
use deflou\interfaces\triggers\values\plugins\IValuePluginDispatcher;

class PluginTelegramParseModes implements IValuePluginDispatcher
{
    public const MODE__HTML = 'html';
    public const MODE__MARKDOWN = 'markdown';

    public const NAME = 'tg_parse_modes';

    public function __invoke(string|int $triggerValue, IResolvedEvent $event, IValuePlugin $plugin): string|int
    {
        return $triggerValue;
    }

    public function getTemplateData(IWithTemplate $templated, IContext $context): array
    {
        return [
            static::MODE__HTML,
            static::MODE__MARKDOWN,
        ];
    }
}
