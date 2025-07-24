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
 * Represents country in phone number.
 *
 * @author Toha <tohenk@yahoo.com>
 */
class Country
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var \NTLAB\Lib\PhoneNumber\Area[]
     */
    protected $area = null;

    /**
     * @var \NTLAB\Lib\PhoneNumber\Area[]
     */
    protected $sortedArea = null;

    /**
     * Constructor.
     *
     * @param string $id  Country ISO code
     * @param string $name  Country name
     * @param string $code  International Calling Code
     */
    public function __construct($id, $name, $code)
    {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
    }

    /**
     * Get country ISO code.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get country name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get country International Calling Code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get phone number area.
     *
     * @return \NTLAB\Lib\PhoneNumber\Area[]
     */
    public function getArea()
    {
        if (null === $this->area) {
            $this->area = [];
            if (is_readable($filename = sprintf('%s/area/%s.json', __DIR__, $this->id)) && $area = json_decode(file_get_contents($filename), true)) {
                $this->area = array_map(fn ($a) => Area::from(array_merge(['country' => $this], $a)), $area);
            }
        }

        return $this->area;
    }

    /**
     * Returns area filtered by the query.
     *
     * @param array $query  The query
     * @return \NTLAB\Lib\PhoneNumber\Area[]
     */
    public function getAreaFor($query = [])
    {
        if (null === $this->sortedArea) {
            $this->sortedArea = $this->getArea();
            usort($this->sortedArea, function ($a, $b) {
                $lenA = strlen($a->getCode());
                $lenB = strlen($b->getCode());
                if ($lenA === $lenB) {
                    return strcmp($a->getCode(), $b->getCode());
                }

                return $lenB - $lenA;
            });
        }
        $area = $this->sortedArea;
        if (isset($query['type'])) {
            $type = Area::areaType($query['type']);
            $area = array_filter($area, fn ($a) => $a->getType() === $type);
        }
        if (isset($query['number'])) {
            $len = null;
            $area = array_filter($area, function ($a) use ($query, &$len) {
                $sz = strlen($a->getCode());
                // only matched area code with same length
                if (null !== $len && $sz !== $len) {
                    return false;
                }
                // compare prefix
                if (substr($query['number'], 0, $sz) !== $a->getCode()) {
                    return false;
                }
                // set len if needed
                if (null === $len) {
                    $len = $sz;
                }

                return true;
            });
        }

        return $area;
    }

    /**
     * Get country object from its ISO code.
     *
     * @param string $countryIsoCode  Country ISO code
     * @return \NTLAB\Lib\PhoneNumber\Country|null
     */
    public static function get($countryIsoCode)
    {
        if (count($countries = array_values(array_filter(ICC::getCountries(), fn ($a) => $a->getId() === $countryIsoCode)))) {
            return $countries[0];
        }
    }

    /**
     * Create country from array. The array must be contains an associative key
     * of id, name, and code.
     *
     * @param array $array  Country data
     * @return \NTLAB\Lib\PhoneNumber\Country|null
     */
    public static function from($array)
    {
        if (is_array($array)) {
            $id = isset($array['id']) ? $array['id'] : null;
            $name = isset($array['country']) ? $array['country'] : null;
            $code = isset($array['code']) ? $array['code'] : null;
            if (null !== $id && null !== $name && null !== $code) {
                return new self($id, $name, $code);
            }
        }
    }
}
