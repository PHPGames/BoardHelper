<?php
/**
 * PlayerRepeatGameException.php
 *
 * Ariel Ferrandini <arielferrandini@gmail.com>
 * 27/09/14
 */
namespace PHPGames\Console\Exception;

class PlayerRepeatGameException extends \RuntimeException
{
    public function __construct($player)
    {
        parent::__construct(sprintf('The last game was player by player "%s".', $player));
    }
}
