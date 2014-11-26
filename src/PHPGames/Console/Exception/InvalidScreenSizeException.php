<?php
/**
 * InvalidScreenSizeException.php
 *
 * Ariel Ferrandini <arielferrandini@gmail.com>
 * 27/09/14
 */

namespace PHPGames\Console\Exception;

class InvalidScreenSizeException extends \RuntimeException
{
    public function __construct($width, $height)
    {
        parent::__construct(sprintf('Invalid screen size %sx%s.', $width, $height));
    }

}
