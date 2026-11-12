<?php

/*
 * The MIT License
 *
 * Copyright (c) 2014-2026 Toha <tohenk@yahoo.com>
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

namespace NTLAB\Lib\Common;

/**
 * Title stripper.
 *
 * @author Toha <tohenk@yahoo.com>
 */
class Gelar
{
    /** @var string[] */
    protected $titles = ['Ir', 'Drs', 'Dra', 'Dr', 'Ec', 'dr', 'drg', 'drh', 'Hj', 'H'];

    /**
     * Get instance.
     *
     * @return \NTLAB\Lib\Common\Gelar
     */
    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Strip both prefix and suffix titles.
     *
     * @param string $name  Name with titles
     * @return string
     */
    public static function strip($name)
    {
        $titles = null;

        return static::getInstance()
            ->doStrip($name, $titles);
    }

    /**
     * Split titled name into name, prefix, and suffix.
     *
     * @param string $name  Name with titles
     * @return array
     */
    public static function split($name)
    {
        return static::getInstance()
            ->doSplit($name);
    }

    /**
     * Add prefix title to strip.
     *
     * @param string $title  Prefix title
     * @return \NTLAB\Lib\Common\Gelar
     */
    public function add($title)
    {
        if (!in_array($title, $this->titles)) {
            $this->titles[] = $title;
        }

        return $this;
    }

    /**
     * Strip prefix title.
     *
     * @param string $name  Name with titles
     * @param string $prefix  Stripped prefix
     * @return string
     */
    protected function stripPrefix($name, &$prefix)
    {
        $prefix = null;
        while (true) {
            if (false === ($p = strpos($name, '.'))) {
                break;
            }
            $title = substr($name, 0, $p);
            if (!in_array($title, $this->titles)) {
                break;
            }
            $prefix = trim(substr($name, 0, $p + 1));
            $name = trim(substr($name, $p + 1));
        }

        return $name;
    }

    /**
     * Strip suffix title.
     *
     * @param string $name  Name with titles
     * @param string $suffix  Stripped suffix
     * @return string
     */
    protected function stripSuffix($name, &$suffix)
    {
        $suffix = null;
        if (false != ($p = strpos($name, ','))) {
            $suffix = trim(substr($name, $p + 1));
            $name = trim(substr($name, 0, $p));
        }

        return $name;
    }

    /**
     * Strip both prefix and suffix titles.
     *
     * @param string $name  Name with titles
     * @param array $titles  Stripped titles
     * @return string
     */
    public function doStrip($name, &$titles)
    {
        $titles = [null, null];

        return $this->stripSuffix($this->stripPrefix(trim($name), $titles[0]), $titles[1]);
    }

    /**
     * Split titled name into name, prefix, and suffix.
     *
     * @param string $name  Name with titles
     * @return array
     */
    public function doSplit($name)
    {
        $result = [null, null, null];
        $result[0] = $this->stripSuffix($this->stripPrefix(trim($name), $result[1]), $result[2]);

        return $result;
    }
}