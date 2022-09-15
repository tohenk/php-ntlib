<?php

/*
 * The MIT License
 *
 * Copyright (c) 2016-2022 Toha <tohenk@yahoo.com>
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

class Gelar
{
    protected static $gelars = ['Ir', 'Drs', 'Dra', 'Dr', 'Ec', 'dr', 'Hj', 'H'];

    /**
     * Strip gelar depan.
     *
     * @param string $nama  Nama dengan gelar
     * @return string
     */
    protected static function stripDepan($nama)
    {
      while (true) {
          if (false === ($p = strpos($nama, '.'))) {
              break;
          }
          $gelar = substr($nama, 0, $p);
          if (!in_array($gelar, self::$gelars)) {
              break;
          }
          $nama = trim(substr($nama, $p + 1));
      }

      return $nama;
    }

    /**
     * Strip gelar belakang.
     *
     * @param string $nama  Nama dengan gelar
     * @return string
     */
    protected static function stripBelakang($nama)
    {
        if (false != ($p = strpos($nama, ','))) {
            $nama = trim(substr($nama, 0, $p));
        }

        return $nama;
    }

    /**
     * Strip gelar depan dan belakang.
     *
     * @param string $nama  Nama dengan gelar
     * @return string
     */
    public static function strip($nama)
    {
        $nama = trim($nama);
        $nama = self::stripDepan($nama);
        $nama = self::stripBelakang($nama);

        return $nama;
    }

    /**
     * Add gelar depan to strip.
     *
     * @param string $gelar  Gelar depan
     */
    public static function add($gelar)
    {
        if (!in_array(self::$gelars)) {
            self::$gelars[] = $gelar;
        }
    }
}