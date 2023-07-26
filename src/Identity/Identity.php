<?php

/*
 * The MIT License
 *
 * Copyright (c) 2021-2023 Toha <tohenk@yahoo.com>
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
 * An identity is formed from sequences or series of encoded data such as date,
 * serial and others.
 *
 * @author Toha
 */
abstract class Identity
{
    /**
     * @var string
     */
    protected $raw;

    /**
     * @var Sequence[]
     */
    protected $sequences = [];

    /**
     * Add id sequence processor.
     *
     * @param Sequence $seq
     * @return Identity
     */
    protected function addSeq($seq)
    {
        $this->sequences[] = $seq;
        return $this;
    }

    /**
     * Get identity length.
     *
     * @return int
     */
    public function getLength()
    {
        $len = 0;
        foreach ($this->sequences as $seq) {
            $len += $seq->getSize();
        }
        return $len;
    }

    /**
     * Decode value.
     *
     * @param string $value
     * @return bool
     */
    public function decode($value)
    {
        if (null !== $value) {
            $this->raw = $value;
            $pos = 0;
            $len = strlen($value);
            foreach ($this->sequences as $seq) {
                $seq->reset();
                $sz = $seq->getSize();
                if ($pos + $sz <= $len) {
                    $seq->decode(substr($value, $pos, $sz));
                    $pos += $sz;
                }
            }
            return $this->isValid();
        }
    }

    /**
     * Encode value.
     *
     * Each value to encode must be passed using setValue(). Once success,
     * encoded value can be retrieved using getRaw().
     *
     * @return bool
     */
    public function encode()
    {
        $raws = [];
        $count = 0;
        foreach ($this->sequences as $seq) {
            if (!$seq->hasValues()) {
                break;
            }
            $raws[] = $seq->encode()->getRaw();
            $count ++;
        }
        if ($count === count($this->sequences)) {
            $this->raw = implode('', $raws);
            return true;
        }
    }

    /**
     * Get decoded value.
     *
     * @param string $name
     * @return mixed
     */
    public function getValue($key)
    {
        foreach ($this->sequences as $seq) {
            if ($seq->hasKey($key)) {
                return $seq->getValue($key);
            }
        }
    }

    /**
     * Set value for encoding.
     *
     * @param string $key
     * @param mixed $value
     * @return Identity
     */
    public function setValue($key, $value)
    {
        foreach ($this->sequences as $seq) {
            if ($seq->hasKey($key)) {
                $seq->setValue($value, $key);
                break;
            }
        }
        return $this;
    }

    /**
     * Is decoded value valid?
     *
     * @return bool
     */
    public function isValid()
    {
        foreach ($this->sequences as $seq) {
            if (!$seq->hasValues()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Is identity length satisfied?
     *
     * @return bool
     */
    public function isLenValid()
    {
        if (null !== $this->raw) {
            return $this->checkLength($this->raw);
        }
        return false;
    }

    protected function checkLength($value)
    {
        return strlen($value) === $this->getLength();
    }

    /**
     * Get original value.
     *
     * @return string
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * Format each raw sequence using a separator.
     *
     * @param string $separator
     * @return string
     */
    public function formatRaw($separator = null)
    {
        $raws = [];
        foreach ($this->sequences as $seq) {
            $raws[] = $seq->getRaw();
        }
        return implode((string) $separator, $raws);
    }

    public function __toString()
    {
        return $this->getRaw();
    }
}
