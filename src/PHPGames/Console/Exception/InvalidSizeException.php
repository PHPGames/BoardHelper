<?php
/**
 * InvalidSizeException.php
 *
 * Ariel Ferrandini <arielferrandini@gmail.com>
 * 27/09/14
 */

namespace PHPGames\Console\Exception;

class InvalidSizeException extends \RuntimeException
{
    public function __construct($size)
    {
        parent::__construct(sprintf('Invalid size %s.', $size));
    }

}
