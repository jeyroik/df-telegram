<?php
namespace deflou\components\plugins\telegram;

use deflou\components\applications\Telegram;
use deflou\interfaces\applications\options\IOptions;
use deflou\interfaces\stages\resolvers\http\IStageRequestHeaders;
use extas\components\plugins\Plugin;

class PluginRequestHeaders extends Plugin implements IStageRequestHeaders
{
    public function __invoke(array &$requestHeaders, IOptions $destinationOptions): void
    {
        $tokenField = Telegram::TOKEN->value;
        $requestHeaders['X-DF-' . strtoupper(str_replace('_', '-', $tokenField))] = $destinationOptions->buildOne($tokenField)->getValue();
    }
}
