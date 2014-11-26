<?php
/**
 * MoveAlreadyDoneException.php
 *
 * Ariel Ferrandini <arielferrandini@gmail.com>
 * 27/09/14
 */

namespace PHPGames\Console\Exception;

class MoveAlreadyDoneException extends \RuntimeException
{
    public function __construct($x, $y, $player)
    {
        parent::__construct(sprintf('Move [%s, %s] already done by player %s.', $x, $y, $player));
    }

}
