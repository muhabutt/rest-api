<?php

namespace App\Core\Response;

use const PHP_SAPI;

/**
 * Class Response
 * @package App\Core\Response
 */
class Response
{
    /**
     * @var
     */
    protected $content;

    /**function return json response with contents, and status code
     * @param int $statusCode
     * @param $content
     */
    public static function jsonResponse(int $statusCode, array $content)
    {
        http_response_code($statusCode);
        header("Content-type", "application/json");

        echo json_encode($content);

        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        } elseif (!in_array(PHP_SAPI, ['cli', 'phpdbg'], true)) {
            static::closeOutputBuffers(0, true);
        }
    }

    /**
     * Cleans or flushes output buffers up to target levels.
     * symphony response class function
     * Resulting level can be greater than target level if a non-removable buffer has been encountered.
     *
     * @final
     * @param int $targetLevel
     * @param bool $flush
     */
    public static function closeOutputBuffers(int $targetLevel, bool $flush): void
    {
        $status = ob_get_status(true);
        $level = count($status);
        $flags = PHP_OUTPUT_HANDLER_REMOVABLE | ($flush ? PHP_OUTPUT_HANDLER_FLUSHABLE : PHP_OUTPUT_HANDLER_CLEANABLE);

        while ($level-- > $targetLevel && ($s = $status[$level]) && (!isset($s['del']) ? !isset($s['flags']) || ($s['flags'] & $flags) === $flags : $s['del'])) {
            if ($flush) {
                ob_end_flush();
            } else {
                ob_end_clean();
            }
        }
    }
}
