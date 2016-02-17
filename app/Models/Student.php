<?php

namespace App\Models;

use App\Models\Base\Student as BaseStudent;

/**
 * Skeleton subclass for representing a row from the 'student' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Student extends BaseStudent
{
    public function __toString(){
        return $this->getIdentificationNumber()."/".$this->getSchoolYear()->__toString()." ".$this->getLastName()." ".$this->getFirstName();
    }
}
