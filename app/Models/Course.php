<?php

namespace App\Models;

use App\Models\Base\Course as BaseCourse;

/**
 * Skeleton subclass for representing a row from the 'course' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Course extends BaseCourse
{
    public function __toString(){
        return $this->getName();
    }
}
