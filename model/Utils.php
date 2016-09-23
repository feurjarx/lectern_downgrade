<?php

/**
 * Created by PhpStorm.
 * Date => 21.05.2016
 * Time => 13:10
 */

use Entity\Cv;
use Entity\Person;

class Utils
{
    /**
     * @param array $list
     * @param array $data
     * @param array $prevData
     * @return array
     */
    public static function arraySerialization(array $list, array $data, array $prevData = array()) {

        $result = array();
        
        if ($data && is_array($data) && $list && is_array($list)) {
            foreach ($list as $item) {
                $result[$item] = isset($data[$item]) ? (($data[$item] === '0' || $data[$item] === 0 || $data[$item]) ? $data[$item] : null) : null;
            }
        }

        return array_merge($prevData, $result);
    }

    /**
     * @return string
     */
    public static function getHttpHost(){
        return 'http://' . $_SERVER['HTTP_HOST'];
    }

    /**
     * @return bool
     */
    public static function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * @return array
     */
    public static function getSpheresTitles()
    {
        return array(
            'programmer'       => 'программист',
            'system_admin'     => 'системный администратор',
            'security_admin'   => 'администратор ИБ',
            'web_designer'     => 'веб дизайнер',
            'project_manager'  => 'проект менеджер',
            'software_testing' => 'тестировщик ПО',
            'web_developer'    => 'веб-разработчик',
        );
    }

    /**
     * @return array
     */
    public static function getWorkExperiencesTitles()
    {
        return array(
            'nope' => 'без опыта',
            '<1'   => 'менее года',
            '1-3'  => '1-3 года',
            '3-5'  => '3-5 лет',
            '5>'   => 'более 5 лет'
        );
    }

    /**
     * @return array
     */
    public static function getEducationsTitles()
    {
        return array(
            '<middle'          => 'неполное среднее',
            'middle'           => 'среднее',
            'middle>'          => 'среднее профессиональное',
            '>high'            => 'высшее (бакалавриат)',
            'high'             => 'высшее (магистратура)',
            'many_high'        => 'два высших',
            'fulltime_student' => 'студент-очник',
            'distance_student' => 'студент-заочник',
        );
    }

    /**
     * @return array
     */
    public static function getSchedulesTitles()
    {
        return array(
            'full'    => 'полный рабочий день',
            'remote'  => 'удаленная работа',
            'elastic' => 'гибкий',
            'shift'   => 'сменный'
        );
    }

    /**
     * @param array $params
     * @return Cv
     */
    public static function fillCv(array $params, Cv $cv)
    {
        foreach ($params as $key => $value) {
            switch ($key) {
                case 'sphere': $cv->setSphere($value); break;
                case 'access_type': $cv->setAccessType($value); break;
                case 'hobbies': $cv->setHobbies($value); break;
                case 'skills': $cv->setSkills($value); break;
                case 'work_experience': $cv->setWorkExperience($value); break;
                case 'education': $cv->setEducation($value); break;
                case 'ext_education': $cv->setExtEducation($value); break;
                case 'desire_salary': $cv->setDesireSalary($value); break;
                case 'schedule': $cv->setSchedule($value); break;
                case 'foreign_languages': $cv->setForeignLanguages($value); break;
                case 'is_drivers_license': $cv->setIsDriversLicense($value); break;
                case 'is_smoking': $cv->setIsSmoking($value); break;
                case 'is_married': $cv->setIsMarried($value); break;
                case 'about': $cv->setAbout($value); break;
            }
        }

        return $cv;
    }

    /**
     * @param Person $person
     * @return array
     */
    public static function personInformationToArray(Person $person)
    {
        return array(
            'full_name'        => $person->getFullName(),
            'date_birth'       => $person->getDateBirth()->format('Y-m-d'),
            'organisation'     => $person->getOrganisation(),
            'email'            => $person->getUser()->getEmail(),
            'phone'            => $person->getContact()->getPhone(),
            'websites'         => $person->getContact()->getWebsites(),
            'city'             => $person->getContact()->getAddress()->getCity(),
            'street'           => $person->getContact()->getAddress()->getStreet(),
            'house_number'     => $person->getContact()->getAddress()->getHouseNumber(),
            'apartment_number' => $person->getContact()->getAddress()->getApartmentNumber(),
        );
    }

    /**
     * @param $sphere
     * @return array|string
     */
    public static function getSpheresString($sphere) {
        $spheres = array_filter(explode(',', $sphere));

        $result = '';
        if ($spheres) {

            $result = array();
            foreach ($spheres as $item) {
		$temp = Utils::getSpheresTitles();
                $result[] = $temp[$item];
            }
            $result = implode(',', $result);
        }

        return $result;
    }
}