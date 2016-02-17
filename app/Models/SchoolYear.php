<?php

namespace App\Models;

use App\Models\Base\SchoolYear as BaseSchoolYear;

/**
 * Skeleton subclass for representing a row from the 'school_year' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class SchoolYear extends BaseSchoolYear
{
    public function __toString(){
        return $this->getYear();
    }
}
