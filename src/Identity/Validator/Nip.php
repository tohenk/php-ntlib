<?php

/*
 * The MIT License
 *
 * Copyright (c) 2021-2025 Toha <tohenk@yahoo.com>
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

use NTLAB\Lib\Identity\Ids\Nip as NipIdentity;

/**
 * NIP identity validator.
 *
 * @author Toha <tohenk@yahoo.com>
 */
class Nip extends Validator
{
    protected $keyId = 'id';
    protected $keyDob = 'dob';
    protected $keyGender = 'gender';
    protected $keyType = 'type';

    /**
     *
     * {@inheritdoc}
     * @see \NTLAB\Lib\Identity\Validator\Validator::initialize()
     */
    protected function initialize()
    {
        $this->id = 'NIP';
        $this->title = 'Validasi ID dengan Nomor Induk Pegawai (NIP)';
        $this->label = 'Nomor Induk Pegawai (NIP)';
        $this->identityClass = NipIdentity::class;
    }

    protected function getIdComparable($values)
    {
        return $this->createComparable([
            $this->keyDob => $values[$this->keyDob],
            $this->keyGender => $values[$this->keyGender],
            $this->keyType => $values[$this->keyType],
        ]);
    }

    protected function compareIdUsingProvider($id, $comparable)
    {
        if (($provider = $this->getProvider()) && null !== ($info = $provider->query($id))) {
            $this->data = $info;
            if (is_array($info) && ($comparable2 = $this->createComparableUsingKeys([$this->keyDob, $this->keyGender, $this->keyType], $info))) {
                return $this->cmpId($comparable, $comparable2);
            }
            return false;
        }
    }

    /**
     * Compare identity.
     *
     * @param \NTLAB\Lib\Identity\Ids\Nip $nip
     * @param \stdClass $comparable
     * @return bool
     */
    protected function compareIdUsingIdentity($nip, $comparable)
    {
        $comparable2 = $this->getIdComparable([
            $this->keyDob => $nip->getTglLahir(),
            $this->keyGender => $nip->getGender(),
            $this->keyType => $nip->getType(),
        ]);
        return $this->cmpId($comparable, $comparable2);
    }

    /**
     * {@inheritDoc}
     * @see \NTLAB\Lib\Identity\Validator\Validator::doValidate()
     */
    protected function doValidate($values)
    {
        if (isset($values[$this->keyId]) && isset($values[$this->keyDob]) && isset($values[$this->keyGender]) && isset($values[$this->keyType])) {
            $id = $values[$this->keyId];
            $comparable = $this->getIdComparable($values);
            // validate using nip provider if applicable
            if (null !== ($result = $this->compareIdUsingProvider($id, $comparable))) {
                return $result;
            }
            // validate using decoded dob and gender
            return $this->compareIdUsingIdentity($this->createIdentity($id), $comparable);
        }
    }
}
