<?php

namespace App\Models;

use App\Models\Base\Professor as BaseProfessor;

/**
 * Skeleton subclass for representing a row from the 'professor' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Professor extends BaseProfessor
{
    public function toString($oposite = false){
        if(!$oposite)
            return $this->getFirstName(). " " .$this->getLastName();
        else
            return $this->getLastName(). " " .$this->getFirstName();
    }
}
