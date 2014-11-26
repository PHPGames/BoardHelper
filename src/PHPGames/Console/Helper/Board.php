<?php
/**
 * Board.php
 *
 * Ariel Ferrandini <arielferrandini@gmail.com>
 * 27/09/14
 */

namespace PHPGames\Console\Helper;

use PHPGames\Console\Exception\InvalidSizeException;
use PHPGames\Console\Exception\MoveAlreadyDoneException;
use PHPGames\Console\Exception\PlayerNotFoundException;
use PHPGames\Console\Exception\PlayerRepeatGameException;
use PHPGames\Console\Screen\Size;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Output\OutputInterface;

class Board
{
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * Board size
     * @var int
     */
    private $size;

    /**
     * @var string
     */
    private $player1_char;

    /**
     * @var string
     */
    private $player2_char;

    /**
     * @var string
     */
    private $player1_color;

    /**
     * @var string
     */
    private $player2_color;

    /**
     * @var int
     */
    private $last_player;

    /**
     * @var Size
     */
    private $screenSize;

    /**
     * @var array
     */
    private $board;

    /**
     * @var bool
     */
    private $overwrite;

    /**
     * @var bool
     */
    private $background;

    /**
     * @var string
     */
    private $background_color;

    /**
     * @var int
     */
    private $spacesBeforeStart = 0;

    /**
     * @param OutputInterface $output
     * @param array           $screenSize
     * @param int             $size
     * @param bool            $overwrite
     * @param bool            $background
     * @param string          $background_color
     * @param string          $player1_char
     * @param string          $player2_char
     * @param string          $player1_color
     * @param string          $player2_color
     */
    public function __construct
    (
        OutputInterface $output,
        array $screenSize,
        $size = 3,
        $overwrite = true,
        $background = false,
        $background_color = 'red',
        $player1_char = 'X',
        $player2_char = 'O',
        $player1_color = 'green',
        $player2_color = 'yellow'
    ) {
        $this->output = $output;

        $screenWidth  = 0;
        $screenHeight = 0;
        if (is_array($screenSize)) {
            if (!empty($screenSize[0])) {
                $screenWidth = $screenSize[0];
            }

            if (!empty($screenSize[1])) {
                $screenHeight = $screenSize[1];
            }
        }
        $this->screenSize = new Size($screenWidth, $screenHeight);
        if ($this->screenSize->getWidth() < $this->size) {
            throw new InvalidSizeException($size);
        }
        $this->size = $size;

        // Center table in screen
        if ($this->screenSize->isValid()) {
            $this->spacesBeforeStart = (int) round(($this->screenSize->getWidth()-($this->size*4))/2);
        }

        $this->overwrite = $overwrite ? true : false;
        $this->background = $background ? true : false;
        $this->background_color = $background_color;
        $this->player1_char = $player1_char;
        $this->player2_char = $player2_char;
        $this->player1_color = $player1_color;
        $this->player2_color = $player2_color;

        $this->initGame();
    }

    /**
     * Restarts the board and the game vars
     */
    public function initGame()
    {
        $this->board = array();
        $this->last_player = null;

        for ($x=0; $x<$this->size; $x++) {
            $row = array();

            for ($y=0; $y<$this->size; $y++) {
                $row[] = null;
            }

            $this->board[] = $row;
        }

        $this->display();
    }

    /**
     * Draws the board
     */
    public function display()
    {
        $message = '';

        $message .= $this->getLineSeparator();
        foreach ($this->board as $i => $row) {
            $message .= $this->getRow($i, $row);
        }

        $message .= $this->getPlayers();
        $message .= $this->getLastMove();

        $this->writeOutput($message);
    }

    private function getLastMove()
    {
        $message = '';
        if ($this->last_player) {
            $message = "Last move by player: {$this->getPlayerChar($this->last_player, false)}";
        }

        return $message . "\n";
    }

    private function getPlayers()
    {
        $player1 = "<fg={$this->player1_color}>{$this->player1_char}</fg={$this->player1_color}> Player 1";
        $player2 = "Player 2 <fg={$this->player2_color}>{$this->player2_char}</fg={$this->player2_color}>";

        $table_length   = ($this->size*4)+1;
        $player1_length = Helper::strlenWithoutDecoration($this->output->getFormatter(), $player1);
        $player2_length = Helper::strlenWithoutDecoration($this->output->getFormatter(), $player2);

        $spaces = $table_length - $player1_length - $player2_length;
        if ($spaces < 4) {
            $spaces = 4;
        }

        return $player1 . str_repeat("\x20", $spaces) . $player2 . "\n";
    }

    /**
     * Returns the row text that should be write
     *
     * @param  int    $row_number
     * @param  array  $row
     * @return string
     */
    private function getRow($row_number, array $row)
    {
        $message = '';
        foreach ($row as $cell_number => $player) {
            $withBackground = $this->drawCellBackground($row_number, $cell_number);
            $message .= ($withBackground ? "|<bg={$this->background_color}> " : '| ')
                        . $this->getPlayerChar($player, $withBackground)
                        . ($withBackground ? " </bg={$this->background_color}>" : ' ')
            ;
        }
        $message .= "|\n";
        $message .= $this->getLineSeparator();

        return $message;
    }

    /**
     * Returns if the background cell should be drawn
     *
     * @param  int  $row_number
     * @param  int  $cell_number
     * @return bool
     */
    private function drawCellBackground($row_number, $cell_number)
    {
        if ($this->size%2) {
            return $this->background && (($row_number%2 && $cell_number%2) || (!($row_number%2) && !($cell_number%2)));
        }

        return $this->background && (($row_number%2 && !($cell_number%2)) || (!($row_number%2) && $cell_number%2));
    }

    /**
     * Returns the board line separator
     *
     * @return string
     */
    private function getLineSeparator()
    {
        return str_repeat('-', ($this->size*4)+1) . "\n";
    }

    /**
     * Update the board status and repaint the board
     *
     * @param int $x
     * @param int $y
     * @param int $player
     */
    public function updateGame($x, $y, $player)
    {
        if (!in_array($player, array(1,2))) {
            throw new PlayerNotFoundException($player);
        }

        if ($this->last_player === $player) {
            throw new PlayerRepeatGameException($player);
        }

        if (!is_null($this->board[$x][$y])) {
            throw new MoveAlreadyDoneException($x, $y, $this->board[$x][$y]);
        }

        $this->last_player = $player;
        $this->board[$x][$y] = $player;

        $this->display();
    }

    /**
     * Overwrites a previous message to the output.
     *
     * @param string $message The message
     */
    private function writeOutput($message)
    {
        $lines = explode("\n", $message);

        if ($this->overwrite) {
            // clear the screen
            $this->clear();
        } else {
            // move to new line
            $this->output->writeln('');
        }

        // append whitespace to center the board
        foreach ($lines as $i => $line) {
            $this->output->writeln(str_pad($line, $this->spacesBeforeStart + strlen($line), "\x20", STR_PAD_LEFT));
        }
    }

    /**
     * Clears the output buffer
     */
    private function clear()
    {
        $this->output->write("\e[2J");
    }

    /**
     * Returns the player board cell
     *
     * @param  int    $player
     * @param  bool   $withBackground
     * @return string
     */
    private function getPlayerChar($player, $withBackground)
    {
        switch ($player) {
            case 1:
                return "<fg={$this->player1_color}".($withBackground ? ";bg={$this->background_color}" : '').">{$this->player1_char}</fg={$this->player1_color}".($withBackground ? ";bg={$this->background_color}" : '').">";

            case 2:
                return "<fg={$this->player2_color}".($withBackground ? ";bg={$this->background_color}" : '').">{$this->player2_char}</fg={$this->player2_color}".($withBackground ? ";bg={$this->background_color}" : '').">";

            default:
                return ' ';
        }
    }
}
