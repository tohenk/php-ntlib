<?php

/*
 * The MIT License
 *
 * Copyright (c) 2025 Toha <tohenk@yahoo.com>
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

namespace NTLAB\Lib\PhoneNumber;

/**
 * Phone number utility.
 *
 * @author Toha <tohenk@yahoo.com>
 */
class Util
{
    /**
     * @var \NTLAB\Lib\PhoneNumber\Country
     */
    protected $country = null;

    /**
     * Constructor.
     *
     * @param string $country ISO country code, e.g. `id` for Indonesia
     */
    public function __construct($country)
    {
        if ($country) {
            $this->country = Country::get($country);
        }
    }

    /**
     * Get default country.
     *
     * @return \NTLAB\Lib\PhoneNumber\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Get ICC from country ISO code.
     *
     * @param string $iso Country ISO code, e.g. id for Indonesia
     * @return string
     */
    public function iccFromIso($iso)
    {
        if ($country = Country::get($iso)) {
            return $country->getCode();
        }
    }

    /**
     * Check if the number is in international code.
     *
     * @param string $number  Phone number
     * @return boolean
     */
    public function isIntl($number)
    {
        return '+' === substr($number, 0, 1);
    }

    /**
     * Normalize phone number into international number.
     *
     * @param string $number  Phone number
     * @param string $country  Country ISO code
     * @param bool $mask  Wheter normalized number should be masked with * or not
     * @return string
     */
    public function normalize($number, $country = null, $mask = null)
    {
        $number = trim((string) $number);
        if (null === $country && null !== $this->country) {
            $country = $this->country->getId();
        }
        if (null !== $country && strlen($country) && !$this->isIntl($number) &&
            null !== ($code = $this->iccFromIso($country)) && strlen($code)) {
            while (substr($number, 0, 1) === '0') {
                $number = substr($number, 1);
            }
            if ($mask) {
                $count = 4;
                $number = str_repeat('*', strlen($number) - $count).substr($number, -$count);
            }
            $number = '+'.$code.$number;
        }

        return $this->cleanNumber($number);
    }

    /**
     * Localize international number as local number.
     *
     * @param string $number  International phone number
     * @param bool $withCountry  Return country code as well
     * @return string|array
     */
    public function localize($number, $withCountry = false)
    {
        $cc = null;
        $number = trim((string) $number);
        if ($this->isIntl($number)) {
            $number = substr($number, 1);
            foreach (ICC::getCountriesSortedByCode() as $country) {
                $len = strlen((string) $country->getCode());
                if (substr($number, 0, $len) === (string) $country->getCode()) {
                    $cc = $country->getId();
                    $number = substr($number, $len);
                    break;
                }
            }
            $number = '0'.$number;
        }

        return $withCountry ? [$number, $cc] : $number;
    }

    /**
     * Mask a phone number by only showing certain first digit and end.
     *
     * @param string $number
     * @param int $start
     * @param int $end
     * @return string
     */
    public function maskNumber($number, $start = 3, $end = 4)
    {
        return substr($number, 0, $start).str_repeat('x', strlen($number) - $start - $end).substr($number, -$end);
    }

    /**
     * Clean phone number for invalid digits.
     *
     * @param string $number  Phone number
     * @return string
     */
    public static function cleanNumber($number)
    {
        return strtr($number, ['-' => '', ' ' => '']);
    }
}
