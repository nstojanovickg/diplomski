
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- admin_credential
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `admin_credential`;

CREATE TABLE `admin_credential`
(
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `group_id` int(11) unsigned NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `title` VARCHAR(30) NOT NULL,
    `sequence` int(4) unsigned DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `uk_adcd_nm` (`name`),
    INDEX `fk_adcd_adcdgp` (`group_id`),
    CONSTRAINT `fk_adcd_adcdgp`
        FOREIGN KEY (`group_id`)
        REFERENCES `admin_credential_group` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- admin_credential_group
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `admin_credential_group`;

CREATE TABLE `admin_credential_group`
(
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `title` VARCHAR(30),
    `sequence` int(11) unsigned,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `uk_adcdgp_nm` (`name`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- admin_user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `admin_user`;

CREATE TABLE `admin_user`
(
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `language_id` int(11) unsigned NOT NULL,
    `professor_id` int(11) unsigned,
    `student_id` int(11) unsigned,
    `name` VARCHAR(100) NOT NULL,
    `login` VARCHAR(32) NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `status` enum('NEW','super_admin','admin','professor','student') DEFAULT 'NEW' NOT NULL,
    `remember_token` VARCHAR(100),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `uk_adus_lg` (`login`),
    INDEX `fk_adus_trln` (`language_id`),
    INDEX `fk_adus_pf` (`professor_id`),
    INDEX `fk_adus_st` (`student_id`),
    CONSTRAINT `fk_adus_pf`
        FOREIGN KEY (`professor_id`)
        REFERENCES `professor` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_adus_st`
        FOREIGN KEY (`student_id`)
        REFERENCES `student` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_adus_trln`
        FOREIGN KEY (`language_id`)
        REFERENCES `translation_language` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- admin_user_credential
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `admin_user_credential`;

CREATE TABLE `admin_user_credential`
(
    `admin_user_id` int(11) unsigned NOT NULL,
    `admin_credential_id` int(11) unsigned NOT NULL,
    `perm_read` int(4) unsigned DEFAULT 0,
    `perm_write` int(4) unsigned DEFAULT 0,
    `perm_exec` int(4) unsigned DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`admin_user_id`,`admin_credential_id`),
    INDEX `fk_aduscd_adus` (`admin_user_id`),
    INDEX `fk_aduscd_adcd` (`admin_credential_id`),
    CONSTRAINT `fk_aduscd_adcd`
        FOREIGN KEY (`admin_credential_id`)
        REFERENCES `admin_credential` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_aduscd_adus`
        FOREIGN KEY (`admin_user_id`)
        REFERENCES `admin_user` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- application
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `application`;

CREATE TABLE `application`
(
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `student_id` int(11) unsigned NOT NULL,
    `subject_id` int(11) unsigned NOT NULL,
    `period_id` int(11) unsigned NOT NULL,
    `school_year_id` int(11) unsigned NOT NULL,
    `application_date` DATE NOT NULL,
    `exam_date` DATE,
    `exam_time` TIME DEFAULT '09:00:00',
    `exam_score` int(2) unsigned,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `fk_app_st` (`student_id`),
    INDEX `fk_app_sb` (`subject_id`),
    INDEX `fk_app_pe` (`period_id`),
    INDEX `fk_app_sy` (`school_year_id`),
    CONSTRAINT `fk_app_pe`
        FOREIGN KEY (`period_id`)
        REFERENCES `period` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_app_sb`
        FOREIGN KEY (`subject_id`)
        REFERENCES `subject` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_app_st`
        FOREIGN KEY (`student_id`)
        REFERENCES `student` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_app_sy`
        FOREIGN KEY (`school_year_id`)
        REFERENCES `school_year` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- application_request
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `application_request`;

CREATE TABLE `application_request`
(
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `application_id` int(11) unsigned,
    `description` TEXT NOT NULL,
    `response` VARCHAR(255),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `fk_apprq_app` (`application_id`),
    CONSTRAINT `fk_apprq_app`
        FOREIGN KEY (`application_id`)
        REFERENCES `application` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- course
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `course`;

CREATE TABLE `course`
(
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `uk_co_nm` (`name`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- engagement
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `engagement`;

CREATE TABLE `engagement`
(
    `professor_id` int(11) unsigned NOT NULL,
    `subject_id` int(11) unsigned NOT NULL,
    `course_id` int(11) unsigned NOT NULL,
    `school_year_id` int(11) unsigned NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`subject_id`,`course_id`,`school_year_id`),
    INDEX `fk_en_pf` (`professor_id`),
    INDEX `fk_en_sb` (`subject_id`),
    INDEX `fk_en_co` (`course_id`),
    INDEX `fk_en_sy` (`school_year_id`),
    CONSTRAINT `fk_en_co`
        FOREIGN KEY (`course_id`)
        REFERENCES `course` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_en_pf`
        FOREIGN KEY (`professor_id`)
        REFERENCES `professor` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_en_sb`
        FOREIGN KEY (`subject_id`)
        REFERENCES `subject` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_en_sy`
        FOREIGN KEY (`school_year_id`)
        REFERENCES `school_year` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- period
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `period`;

CREATE TABLE `period`
(
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `sequence` int(4) unsigned,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `uk_pe_nm` (`name`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- period_school_year
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `period_school_year`;

CREATE TABLE `period_school_year`
(
    `period_id` int(11) unsigned NOT NULL,
    `school_year_id` int(11) unsigned NOT NULL,
    `date_start` DATE NOT NULL,
    `date_end` DATE NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`period_id`,`school_year_id`),
    INDEX `fk_psy_pd` (`period_id`),
    INDEX `fk_psy_sy` (`school_year_id`),
    CONSTRAINT `fk_psy_pd`
        FOREIGN KEY (`period_id`)
        REFERENCES `period` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_psy_sy`
        FOREIGN KEY (`school_year_id`)
        REFERENCES `school_year` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- professor
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `professor`;

CREATE TABLE `professor`
(
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(100) NOT NULL,
    `last_name` VARCHAR(100) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- school_year
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `school_year`;

CREATE TABLE `school_year`
(
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `year` int(4) unsigned NOT NULL,
    `date_start` DATE,
    `date_end` DATE,
    `description` VARCHAR(255),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- student
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `student`;

CREATE TABLE `student`
(
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `identification_number` int(11) unsigned NOT NULL,
    `school_year_id` int(11) unsigned NOT NULL,
    `course_id` int(11) unsigned NOT NULL,
    `first_name` VARCHAR(100) NOT NULL,
    `last_name` VARCHAR(100) NOT NULL,
    `birth_place` VARCHAR(100) NOT NULL,
    `birthday` DATE,
    `phone_number` VARCHAR(20),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `uk_st_idney` (`identification_number`, `school_year_id`),
    INDEX `fk_st_co` (`course_id`),
    INDEX `fk_st_sy` (`school_year_id`),
    CONSTRAINT `fk_st_co`
        FOREIGN KEY (`course_id`)
        REFERENCES `course` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_st_sy`
        FOREIGN KEY (`school_year_id`)
        REFERENCES `school_year` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- study_program
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `study_program`;

CREATE TABLE `study_program`
(
    `subject_id` int(11) unsigned NOT NULL,
    `course_id` int(11) unsigned NOT NULL,
    `year` int(1) unsigned NOT NULL,
    `semester` int(1) unsigned NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`subject_id`,`course_id`),
    INDEX `fk_sp_su` (`subject_id`),
    INDEX `fk_sp_co` (`course_id`),
    CONSTRAINT `fk_sp_co`
        FOREIGN KEY (`course_id`)
        REFERENCES `course` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_sp_su`
        FOREIGN KEY (`subject_id`)
        REFERENCES `subject` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- subject
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `subject`;

CREATE TABLE `subject`
(
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `code` VARCHAR(10) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `uk_sb_nm` (`name`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- translation_application
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `translation_application`;

CREATE TABLE `translation_application`
(
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- translation_catalog
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `translation_catalog`;

CREATE TABLE `translation_catalog`
(
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `application_id` int(11) unsigned NOT NULL,
    `name` VARCHAR(255) DEFAULT 'messages' NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `uk_tnct_an` (`application_id`, `name`),
    INDEX `fk_tnct_tnap` (`application_id`),
    CONSTRAINT `fk_tnct_tnap`
        FOREIGN KEY (`application_id`)
        REFERENCES `translation_application` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- translation_keyword
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `translation_keyword`;

CREATE TABLE `translation_keyword`
(
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `catalog_id` int(11) unsigned NOT NULL,
    `keyword` TEXT NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `fk_tnkw_tnct` (`catalog_id`),
    CONSTRAINT `fk_tnkw_tnct`
        FOREIGN KEY (`catalog_id`)
        REFERENCES `translation_catalog` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- translation_language
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `translation_language`;

CREATE TABLE `translation_language`
(
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `culture` VARCHAR(7) NOT NULL,
    `locale` VARCHAR(7) NOT NULL,
    `is_active` int(4) unsigned DEFAULT 0,
    `is_default` int(4) unsigned DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- translation_language_keyword
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `translation_language_keyword`;

CREATE TABLE `translation_language_keyword`
(
    `language_id` int(11) unsigned NOT NULL,
    `keyword_id` int(11) unsigned NOT NULL,
    `translation` TEXT NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`language_id`,`keyword_id`),
    INDEX `fk_tnlnkw_tnln` (`language_id`),
    INDEX `fk_tnlnkw_tnkw` (`keyword_id`),
    CONSTRAINT `fk_tnlnkw_tnkw`
        FOREIGN KEY (`language_id`)
        REFERENCES `translation_language` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `fk_tnlnkw_tnln`
        FOREIGN KEY (`keyword_id`)
        REFERENCES `translation_keyword` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
