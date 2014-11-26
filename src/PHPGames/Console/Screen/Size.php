<?php
/**
 * Size.php
 *
 * Ariel Ferrandini <arielferrandini@gmail.com>
 * 29/09/14
 */

namespace PHPGames\Console\Screen;

use PHPGames\Console\Exception\InvalidScreenSizeException;

final class Size
{
    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @param int $width
     * @param int $height
     */
    public function __construct($width, $height)
    {
        if (0 >= $width || 0 >= $height) {
            throw new InvalidScreenSizeException($width, $height);
        }

        $this->setWidth($width);
        $this->setHeight($height);
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     *
     * @return self
     */
    public function setHeight($height)
    {
        $height = (int) $height;

        if ($height>0) {
            $this->height = $height;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     *
     * @return self
     */
    public function setWidth($width)
    {
        $width = (int) $width;

        if ($width>0) {
            $this->width = $width;
        }

        return $this;
    }

    public function isValid()
    {
        return ($this->getWidth()>0 && $this->getHeight()>0);
    }
}
