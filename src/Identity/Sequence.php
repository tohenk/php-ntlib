<?php

/*
 * The MIT License
 *
 * Copyright (c) 2021-2025 Toha <tohenk@yahoo.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
 * of the Software, and to permit persons to whom the Software is furnished to do
 * so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace NTLAB\Lib\Identity;

/**
 * An identity sequence provide decode or encode functionality.
 *
 * @author Toha <tohenk@yahoo.com>
 */
class Sequence
{
    /**
     * @var int
     */
    protected $size;

    /**
     * @var array
     */
    protected $keys;

    /**
     * @var string
     */
    protected $raw;

    /**
     * @var array
     */
    protected $values;

    /**
     * Constructor.
     *
     * @param int $size
     * @param array $keys
     */
    public function __construct($size, $keys)
    {
        $this->size = $size;
        $this->keys = is_array($keys) ? $keys : [$keys];
    }

    /**
     * Get size.
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Get keys.
     *
     * @return array
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
     * Is key exist.
     *
     * @param string $key
     * @return bool
     */
    public function hasKey($key)
    {
        return in_array($key, $this->keys);
    }

    /**
     * Get raw.
     *
     * @return string
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * Get decoded value.
     *
     * @param string $key
     * @return mixed
     */
    public function getValue($key = null)
    {
        if (null == $key && count($this->keys)) {
            $key = $this->keys[0];
        }
        return $this->values[$key];
    }

    /**
     * Set decoded value.
     *
     * @param mixed $value
     * @param string $key
     * @return Sequence
     */
    public function setValue($value, $key = null)
    {
        if (null == $key && count($this->keys)) {
            $key = $this->keys[0];
        }
        $this->values[$key] = $value;
        return $this;
    }

    /**
     * Decode raw value.
     *
     * @param string $raw
     * @return Sequence
     */
    public function decode($raw)
    {
        if (strlen($raw) != $this->size) {
            throw new \Exception(sprintf('%s expects size of %d, got "%s"!', get_class($this), $this->size, $raw));
        }
        $this->raw = $raw;
        $this->doDecode();
        return $this;
    }

    /**
     * Decode raw value.
     */
    protected function doDecode()
    {
        $this->setValue($this->raw);
    }

    /**
     * Encode values.
     *
     * @return Sequence
     */
    public function encode()
    {
        $this->doEncode();
        return $this;
    }

    /**
     * Encode value.
     */
    protected function doEncode()
    {
        $this->raw = $this->getValue();
    }

    /**
     * Reset values.
     *
     * @return Sequence
     */
    public function reset()
    {
        $this->values = [];
        return $this;
    }

    /**
     * Is all values exist.
     *
     * @return bool
     */
    public function hasValues()
    {
        foreach ($this->keys as $key) {
            if (!isset($this->values[$key])) {
                return false;
            }
        }
        return true;
    }
}
