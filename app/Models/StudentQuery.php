<?php

namespace App\Models;

use App\Models\Base\StudentQuery as BaseStudentQuery;

/**
 * Skeleton subclass for performing query and update operations on the 'student' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class StudentQuery extends BaseStudentQuery
{
    public static function retrieveByPhoneNumber($phone_number){
        return self::create()->where('Student.phone_number = ?', $phone_number)->findOne();
    }
}
