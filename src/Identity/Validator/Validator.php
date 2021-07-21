<?php

/*
 * The MIT License
 *
 * Copyright (c) 2021 Toha <tohenk@yahoo.com>
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

namespace NTLAB\Lib\Identity\Validator;

use NTLAB\Lib\Identity\Provider\ProviderInterface;

/**
 * Validator ensures the validity of an identity by comparing it with
 * identity provider.
 *
 * @author Toha
 */
abstract class Validator
{
    /**
     * @var string
     */
    protected $id = null;

    /**
     * @var string
     */
    protected $title = null;

    /**
     * @var string
     */
    protected $label = null;

    /**
     * @var array
     */
    protected $data = null;

    /**
     * @var \NTLAB\Lib\Identity\Provider\ProviderInterface
     */
    protected $provider = null;

    /**
     * Constructor.
     *
     * @param ProviderInterface $provider
     */
    public function __construct($provider = null)
    {
        $this->provider = $provider;
        $this->initialize();
    }

    protected function initialize()
    {
    }

    /**
     * Get identity provider.
     *
     * @return \NTLAB\Lib\Identity\Provider\ProviderInterface
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Get Id validator id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get id validator title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get id validator label.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Get validation data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Validate an id.
     *
     * @param array $values
     * @return boolean
     */
    public function validate($values)
    {
        $this->data = null;
        return $this->doValidate($values);
    }

    /**
     * Internal handler for validation.
     *
     * @param array $values
     * @return boolean
     */
    protected function doValidate($values)
    {
    }

    /**
     * Create a comparable as stdClass.
     *
     * @param array $data
     * @return \stdClass
     */
    public function createComparable($data)
    {
        $result = new \stdClass();
        foreach ($data as $k => $v) {
            if (!is_int($k)) {
                $result->$k = $v;
            }
        }
        return $result;
    }

    /**
     * Create a comparable from array with specified keys.
     *
     * @param array $keys
     * @param array $values
     * @return \stdClass
     */
    public function createComparableUsingKeys($keys, $values)
    {
        $data = [];
        $valueKeys = array_keys($values);
        $normalizedKeys = array_map('strtolower', $valueKeys);
        foreach ($keys as $key)  {
            if (isset($values[$key])) {
                $data[$key] = $values[$key];
            } else if (false !== ($pos = array_search($key, $normalizedKeys))) {
                $data[$key] = $values[$valueKeys[$pos]];
            }
        }
        if ($data) {
            return $this->createComparable($data);
        }
    }

    /**
     * Compare value.
     *
     * @param mixed $value1
     * @param mixed $value2
     * @return boolean
     */
    protected function cmpVal($value1, $value2)
    {
        if ($value1 instanceof \DateTime) {
            $value1 = $value1->getTimestamp();
        }
        if ($value2 instanceof \DateTime) {
            $value2 = $value2->getTimestamp();
        }
        if ($value1 !== $value2) {
            return false;
        }
        return true;
    }

    /**
     * Compare an identity.
     *
     * @param \stdClass $id1
     * @param \stdClass $id2
     * @return boolean
     */
    public function cmpId(\stdClass $id1, \stdClass $id2)
    {
        $values1 = get_object_vars($id1);
        $values2 = get_object_vars($id2);
        error_log(var_export($values1, true));
        error_log(var_export($values2, true));
        if (count(array_diff_key($values1, $values2))) {
            return false;
        }
        foreach ($values1 as $k => $v) {
            if (!$this->cmpVal($v, $values2[$k])) {
                return false;
            }
        }
        return true;
    }

    public function __toString()
    {
        return $this->title;
    }
}
