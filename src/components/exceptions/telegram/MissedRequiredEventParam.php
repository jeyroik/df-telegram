<?php
namespace deflou\components\exceptions\telegram;

use Throwable;

class MissedRequiredEventParam extends \Exception
{
    /**
     * Missed constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($param = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Missed required event parameter "' . $param . '"', $code, $previous);
    }
}
