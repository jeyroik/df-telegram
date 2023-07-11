<?php
namespace deflou\components\exceptions\telegram;

use Throwable;

class MissedBotToken extends \Exception
{
    /**
     * Missed constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Missed bot token', $code, $previous);
    }
}
