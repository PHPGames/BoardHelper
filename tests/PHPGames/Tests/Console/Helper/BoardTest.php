<?php
/**
 * BoardTest.php
 *
 * Ariel Ferrandini <arielferrandini@gmail.com>
 * 27/09/14
 */
namespace PHPGames\Tests\Console\Helper;

use PHPGames\Console\Helper\Board;
use Symfony\Component\Console\Output\StreamOutput;

class BoardTest extends \PHPUnit_Framework_TestCase
{
    public function testDisplay()
    {
        $ticTacToe = new Board($output = $this->getOutputStream(false), array(10, 10), 3, false);

        rewind($output->getStream());

        $this->assertEquals(
            $this->generateOutput('').
            $this->generateOutput('-------------').
            $this->generateOutput('|   |   |   |').
            $this->generateOutput('-------------').
            $this->generateOutput('|   |   |   |').
            $this->generateOutput('-------------').
            $this->generateOutput('|   |   |   |').
            $this->generateOutput('-------------').
            $this->generateOutput('X Player 1    Player 2 O').
            $this->generateOutput('').
            $this->generateOutput(''),
            stream_get_contents($output->getStream())
        );
    }

    public function testDisplayCentered()
    {
        $ticTacToe = new Board($output = $this->getOutputStream(false), array(40, 40), 3, false);

        rewind($output->getStream());

        $this->assertEquals(
            $this->generateOutput('').
            $this->generateOutput('              -------------').
            $this->generateOutput('              |   |   |   |').
            $this->generateOutput('              -------------').
            $this->generateOutput('              |   |   |   |').
            $this->generateOutput('              -------------').
            $this->generateOutput('              |   |   |   |').
            $this->generateOutput('              -------------').
            $this->generateOutput('              X Player 1    Player 2 O').
            $this->generateOutput('              ').
            $this->generateOutput('              '),
            stream_get_contents($output->getStream())
        );
    }

    public function testDisplayCenteredBigSize()
    {
        $ticTacToe = new Board($output = $this->getOutputStream(false), array(100, 100), 10, false);

        rewind($output->getStream());

        $this->assertEquals(
            $this->generateOutput('').
            $this->generateOutput('                              -----------------------------------------').
            $this->generateOutput('                              |   |   |   |   |   |   |   |   |   |   |').
            $this->generateOutput('                              -----------------------------------------').
            $this->generateOutput('                              |   |   |   |   |   |   |   |   |   |   |').
            $this->generateOutput('                              -----------------------------------------').
            $this->generateOutput('                              |   |   |   |   |   |   |   |   |   |   |').
            $this->generateOutput('                              -----------------------------------------').
            $this->generateOutput('                              |   |   |   |   |   |   |   |   |   |   |').
            $this->generateOutput('                              -----------------------------------------').
            $this->generateOutput('                              |   |   |   |   |   |   |   |   |   |   |').
            $this->generateOutput('                              -----------------------------------------').
            $this->generateOutput('                              |   |   |   |   |   |   |   |   |   |   |').
            $this->generateOutput('                              -----------------------------------------').
            $this->generateOutput('                              |   |   |   |   |   |   |   |   |   |   |').
            $this->generateOutput('                              -----------------------------------------').
            $this->generateOutput('                              |   |   |   |   |   |   |   |   |   |   |').
            $this->generateOutput('                              -----------------------------------------').
            $this->generateOutput('                              |   |   |   |   |   |   |   |   |   |   |').
            $this->generateOutput('                              -----------------------------------------').
            $this->generateOutput('                              |   |   |   |   |   |   |   |   |   |   |').
            $this->generateOutput('                              -----------------------------------------').
            $this->generateOutput('                              X Player 1                     Player 2 O').
            $this->generateOutput('                              ').
            $this->generateOutput('                              '),
            stream_get_contents($output->getStream())
        );
    }

    public function testDisplayOtherSize()
    {
        $ticTacToe = new Board($output = $this->getOutputStream(false), array(10, 10), 5, false);

        rewind($output->getStream());

        $this->assertEquals(
            $this->generateOutput('').
            $this->generateOutput('---------------------').
            $this->generateOutput('|   |   |   |   |   |').
            $this->generateOutput('---------------------').
            $this->generateOutput('|   |   |   |   |   |').
            $this->generateOutput('---------------------').
            $this->generateOutput('|   |   |   |   |   |').
            $this->generateOutput('---------------------').
            $this->generateOutput('|   |   |   |   |   |').
            $this->generateOutput('---------------------').
            $this->generateOutput('|   |   |   |   |   |').
            $this->generateOutput('---------------------').
            $this->generateOutput('X Player 1    Player 2 O').
            $this->generateOutput('').
            $this->generateOutput(''),
            stream_get_contents($output->getStream())
        );
    }

    public function testUpdateGame()
    {
        $ticTacToe = new Board($output = $this->getOutputStream(false), array(10, 10), 3, false);
        $ticTacToe->updateGame(1, 1, 1);
        $ticTacToe->updateGame(0, 0, 2);

        rewind($output->getStream());

        $this->assertEquals(
            $this->generateOutput('').
            $this->generateOutput('-------------').
            $this->generateOutput('|   |   |   |').
            $this->generateOutput('-------------').
            $this->generateOutput('|   |   |   |').
            $this->generateOutput('-------------').
            $this->generateOutput('|   |   |   |').
            $this->generateOutput('-------------').
            $this->generateOutput('X Player 1    Player 2 O').
            $this->generateOutput('').
            $this->generateOutput('').
            $this->generateOutput('').
            $this->generateOutput('-------------').
            $this->generateOutput('|   |   |   |').
            $this->generateOutput('-------------').
            $this->generateOutput('|   | X |   |').
            $this->generateOutput('-------------').
            $this->generateOutput('|   |   |   |').
            $this->generateOutput('-------------').
            $this->generateOutput('X Player 1    Player 2 O').
            $this->generateOutput('Last move by player: X').
            $this->generateOutput('').
            $this->generateOutput('').
            $this->generateOutput('-------------').
            $this->generateOutput('| O |   |   |').
            $this->generateOutput('-------------').
            $this->generateOutput('|   | X |   |').
            $this->generateOutput('-------------').
            $this->generateOutput('|   |   |   |').
            $this->generateOutput('-------------').
            $this->generateOutput('X Player 1    Player 2 O').
            $this->generateOutput('Last move by player: O').
            $this->generateOutput(''),
            stream_get_contents($output->getStream())
        );
    }

    public function testInitGame()
    {
        $ticTacToe = new Board($output = $this->getOutputStream(false), array(10, 10), 3, false);
        $ticTacToe->updateGame(1, 1, 1);
        $ticTacToe->initGame();

        rewind($output->getStream());

        $this->assertEquals(
            $this->generateOutput('').
            $this->generateOutput('-------------').
            $this->generateOutput('|   |   |   |').
            $this->generateOutput('-------------').
            $this->generateOutput('|   |   |   |').
            $this->generateOutput('-------------').
            $this->generateOutput('|   |   |   |').
            $this->generateOutput('-------------').
            $this->generateOutput('X Player 1    Player 2 O').
            $this->generateOutput('').
            $this->generateOutput('').
            $this->generateOutput('').
            $this->generateOutput('-------------').
            $this->generateOutput('|   |   |   |').
            $this->generateOutput('-------------').
            $this->generateOutput('|   | X |   |').
            $this->generateOutput('-------------').
            $this->generateOutput('|   |   |   |').
            $this->generateOutput('-------------').
            $this->generateOutput('X Player 1    Player 2 O').
            $this->generateOutput('Last move by player: X').
            $this->generateOutput('').
            $this->generateOutput('').
            $this->generateOutput('-------------').
            $this->generateOutput('|   |   |   |').
            $this->generateOutput('-------------').
            $this->generateOutput('|   |   |   |').
            $this->generateOutput('-------------').
            $this->generateOutput('|   |   |   |').
            $this->generateOutput('-------------').
            $this->generateOutput('X Player 1    Player 2 O').
            $this->generateOutput('').
            $this->generateOutput(''),
            stream_get_contents($output->getStream())
        );
    }

    /**
     * @expectedException   PHPGames\Console\Exception\PlayerNotFoundException
     */
    public function testPlayerNotFoundException()
    {
        $ticTacToe = new Board($output = $this->getOutputStream(false), array(10, 10));
        $ticTacToe->updateGame(1, 1, 3);
    }

    /**
     * @expectedException   PHPGames\Console\Exception\PlayerRepeatGameException
     */
    public function testLastPlayerGameException()
    {
        $ticTacToe = new Board($output = $this->getOutputStream(false), array(10, 10));
        $ticTacToe->updateGame(1, 1, 1);
        $ticTacToe->updateGame(0, 0, 1);
    }

    /**
     * @expectedException   PHPGames\Console\Exception\MoveAlreadyDoneException
     */
    public function testMoveAlreadyPlayedException()
    {
        $ticTacToe = new Board($output = $this->getOutputStream(false), array(10, 10));
        $ticTacToe->updateGame(1, 1, 1);
        $ticTacToe->updateGame(1, 1, 2);
    }

    protected function getOutputStream($decorated = true, $verbosity = StreamOutput::VERBOSITY_NORMAL)
    {
        return new StreamOutput(fopen('php://memory', 'r+', false), $verbosity, $decorated);
    }

    protected function generateOutput($expected)
    {
        $count = substr_count($expected, "\n");

        return $expected . ($count ? "" : "\n");
    }
}
