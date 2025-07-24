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

use InvalidArgumentException;

/**
 * Represents phone number area.
 *
 * @author Toha <tohenk@yahoo.com>
 */
class Area
{
    public const FIXED = 1;
    public const CELLULAR = 2;

    /**
     * @var int
     */
    protected $type;

    /**
     * @var \NTLAB\Lib\PhoneNumber\Country
     */
    protected $country;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $remark;

    /**
     * Constructor.
     *
     * @param int|string $type  Area type, fixed or cellular
     * @param \NTLAB\Lib\PhoneNumber\Country|string $country  Country ISO code or country object
     * @param string $code  Area code
     * @param string $name  Area name
     * @param string $remark  Area remark
     */
    public function __construct($type, $country, $code, $name, $remark = null)
    {
        if (is_string($country)) {
            if (null === ($cObj = Country::get($country))) {
                throw new InvalidArgumentException(sprintf('Unable to find country code %s!', $country));
            }
            $country = $cObj;
        }
        $this->type = static::areaType($type);
        $this->country = $country;
        $this->code = $code;
        $this->name = $name;
        $this->remark = $remark;
    }

    /**
     * Get area type.
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get country ISO code.
     *
     * @return \NTLAB\Lib\PhoneNumber\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Get area code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get area name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get area remark.
     *
     * @return string
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Get area type mapping.
     *
     * @param string $type  Area type, fixed or cellular
     * @return int|mixed
     */
    public static function areaType($type)
    {
        if (is_string($type)) {
            switch ($type) {
                case 'fixed':
                    $type = static::FIXED;
                    break;
                case 'cellular':
                    $type = static::CELLULAR;
                    break;
            }
        }

        return $type;
    }

    /**
     * Create area from array. The array must be contains an associative key
     * of type, country, code, name, and an optional remark.
     *
     * @param array $array  Area data
     * @return \NTLAB\Lib\PhoneNumber\Area|null
     */
    public static function from($array)
    {
        if (is_array($array)) {
            $type = isset($array['type']) ? $array['type'] : null;
            $country = isset($array['country']) ? $array['country'] : null;
            $code = isset($array['code']) ? $array['code'] : null;
            $name = isset($array['name']) ? $array['name'] : null;
            $remark = isset($array['remark']) ? $array['remark'] : null;
            if (null !== $type  && null !== $country && null !== $code && null !== $name) {
                return new self($type, $country, $code, $name, $remark);
            }
        }
    }
}
