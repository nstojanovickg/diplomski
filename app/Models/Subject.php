<?php

namespace App\Models;

use App\Models\Base\Subject as BaseSubject;

/**
 * Skeleton subclass for representing a row from the 'subject' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Subject extends BaseSubject
{
    public function __toString(){
        return $this->getName();
    }
}
