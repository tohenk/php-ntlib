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

namespace NTLAB\Lib\Identity\Validator;

use NTLAB\Lib\Identity\Ids\Nik as NikIdentity;

/**
 * NIK identity validator.
 *
 * @author Toha
 */
class Nik extends Validator
{
    protected $keyId = 'id';
    protected $keyDob = 'dob';
    protected $keyGender = 'gender';

    /**
     *
     * {@inheritdoc}
     * @see \NTLAB\Lib\Identity\Validator\Validator::initialize()
     */
    protected function initialize()
    {
        $this->id = 'NIK';
        $this->title = 'Validasi ID dengan Nomor Induk Kependudukan (NIK)';
        $this->label = 'Nomor Induk Kependudukan (NIK)';
        $this->identityClass = NikIdentity::class;
    }

    protected function getIdComparable($values)
    {
        return $this->createComparable([
            $this->keyDob => $values[$this->keyDob],
            $this->keyGender => $values[$this->keyGender],
        ]);
    }

    protected function compareIdUsingProvider($id, $comparable)
    {
        if (($provider = $this->getProvider()) && null !== ($info = $provider->query($id))) {
            $this->data = $info;
            if (is_array($info) && ($comparable2 = $this->createComparableUsingKeys([$this->keyDob, $this->keyGender], $info))) {
                return $this->cmpId($comparable, $comparable2);
            }
            return false;
        }
    }

    /**
     * Compare identity.
     *
     * @param \NTLAB\Lib\Identity\Ids\Nik $nik
     * @param \stdClass $comparable
     * @return bool
     */
    protected function compareIdUsingIdentity($nik, $comparable)
    {
        $comparable2 = $this->getIdComparable([
            $this->keyDob => $nik->getTglLahir(),
            $this->keyGender => $nik->getGender(),
        ]);
        return $this->cmpId($comparable, $comparable2);
    }

    /**
     * {@inheritDoc}
     * @see \NTLAB\Lib\Identity\Validator\Validator::doValidate()
     */
    protected function doValidate($values)
    {
        if (isset($values[$this->keyId]) && isset($values[$this->keyDob]) && isset($values[$this->keyGender])) {
            $id = $values[$this->keyId];
            $comparable = $this->getIdComparable($values);
            // validate using nik provider if applicable
            if (null !== ($result = $this->compareIdUsingProvider($id, $comparable))) {
                return $result;
            }
            // validate using decoded dob and gender
            return $this->compareIdUsingIdentity($this->createIdentity($id), $comparable);
        }
    }
}
