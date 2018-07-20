<?php

namespace DShepherd\BitStreamIterator;

/**
 * A class for iterating through a stream of bits
 *
 * (c) Dan Shepherd <dan@yayfor.me.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class BitStreamIterator implements \Iterator, \Countable, \ArrayAccess
{
    /**
     * @var array
     */
    private $bitArray = [];

    /**
     * @var int
     */
    private $position = 0;

    public function __construct(array $inputArray = [])
    {
        /**
         * Convert each input byte into bits
         */
        foreach ($inputArray as $byte) {
            $bits = str_split(sprintf("%08d", decbin($byte)), 1);
            $this->bitArray = array_merge($this->bitArray, $bits);
        }

        $this->position = 0;
    }

    /**
     * Read $length bits but don't advance the cursor
     *
     * @param int $length
     * @return array
     */
    public function peek(int $length = 1): array
    {
        return $result = array_slice($this->bitArray, $this->position, $length);
    }

    /**
     * Read $length bits and advance the cursor
     *
     * @param int $length
     * @return array
     */
    public function take(int $length = 1): array
    {
        $result = $this->peek($length);
        $this->position += $length;

        return $result;
    }

    public function current(): int
    {
        return $this->bitArray[$this->position];
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return $this->offsetExists($this->position);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function count(): int
    {
        return count($this->bitArray);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->bitArray[$offset]);
    }

    public function offsetGet($offset): int
    {
        return $this->bitArray[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->bitArray[] = $value;
        } else {
            $this->bitArray[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->bitArray[$offset]);
    }
}
