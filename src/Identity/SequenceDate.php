<?php

/*
 * The MIT License
 *
 * Copyright (c) 2021-2024 Toha <tohenk@yahoo.com>
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
 * A date sequence encoder/decoder.
 *
 * @author Toha
 */
class SequenceDate extends Sequence
{
    /**
     * @var string
     */
    protected $format;

    /**
     * Constructor.
     *
     * @param int $size
     * @param array $keys
     * @param string $format
     */
    public function __construct($size, $keys, $format = 'Ymd')
    {
        parent::__construct($size, $keys);
        $this->format = $format;
    }

    /**
     * Extract date parts for decode processing.
     *
     * @param string $str
     * @param string $format
     * @param int $yr
     * @param int $mo
     * @param int $dy
     */
    protected function extractDate($str, $format, &$yr, &$mo, &$dy)
    {
        $pos = 0;
        for ($i = 0; $i < strlen($format); $i ++) {
            switch (substr($format, $i, 1)) {
                case 'Y': // four digit year
                    $value = substr($str, $pos, 4);
                    $yr = (int) $value;
                    $pos += 4;
                    break;
                case 'y': // two digit year
                    $value = substr($str, $pos, 2);
                    $yr = (int) $value;
                    // fix year
                    $cyr = date('Y');
                    $cyrh = (int) substr($cyr, 0, 2);
                    if (($cyrh * 100) + $yr > (int) $cyr) {
                        $cyrh --;
                    }
                    $yr = ($cyrh * 100) + $yr;
                    $pos += 2;
                    break;
                case 'm':
                    $value = substr($str, $pos, 2);
                    $mo = (int) $value;
                    $pos += 2;
                    break;
                case 'd':
                    $value = substr($str, $pos, 2);
                    $dy = (int) $value;
                    $pos += 2;
                    break;
            }
        }
    }

    /**
     * Decode a date string.
     *
     * @param string $str
     * @param \DateTime $date
     * @param string $format
     * @throws \Exception
     * @return bool
     */
    protected function decodeDate($str, &$date, $format)
    {
        $retval = true;
        try {
            $yr = null;
            $mo = null;
            $dy = null;
            $this->extractDate($str, $format, $yr, $mo, $dy);
            // @TODO: default values
            if (null === $yr)
                $yr = (int) date('Y');
            if (null === $dy)
                $dy = 1;
            if (!checkdate($mo, $dy, $yr)) {
                throw new \Exception(sprintf('Invalid date yr=%s, mo=%s, dy=%s!', $yr, $mo, $dy));
            }
            $date = new \DateTime();
            $date->setTimestamp(mktime(0, 0, 0, $mo, $dy, $yr));
        } catch (\Exception $e) {
            $retval = false;
            error_log($e->getMessage());
        }
        return $retval;
    }

    /**
     * {@inheritDoc}
     * @see \NTLAB\Lib\Identity\Sequence::doDecode()
     */
    protected function doDecode()
    {
        $date = null;
        if ($this->decodeDate($this->raw, $date, $this->format)) {
            $this->setValue($date);
        }
    }

    /**
     * {@inheritDoc}
     * @see \NTLAB\Lib\Identity\Sequence::doEncode()
     */
    protected function doEncode()
    {
        if ($date = $this->getValue()) {
            $this->raw = $date->format($this->format);
        }
    }
}
