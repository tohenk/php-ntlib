<?php

/*
 * The MIT License
 *
 * Copyright (c) 2016-2025 Toha <tohenk@yahoo.com>
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
        return static::getInstance()
            ->doStrip($name);
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
     * @return string
     */
    protected function stripPrefix($name)
    {
      while (true) {
          if (false === ($p = strpos($name, '.'))) {
              break;
          }
          $title = substr($name, 0, $p);
          if (!in_array($title, $this->titles)) {
              break;
          }
          $name = trim(substr($name, $p + 1));
      }

      return $name;
    }

    /**
     * Strip suffix title.
     *
     * @param string $name  Name with titles
     * @return string
     */
    protected function stripSuffix($name)
    {
        if (false != ($p = strpos($name, ','))) {
            $name = trim(substr($name, 0, $p));
        }

        return $name;
    }

    /**
     * Strip both prefix and suffix titles.
     *
     * @param string $name  Name with titles
     * @return string
     */
    public function doStrip($name)
    {
        return $this->stripSuffix($this->stripPrefix(trim($name)));
    }
}