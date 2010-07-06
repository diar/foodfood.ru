<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.1
 * Модель для управления лицами foodfood
 */
class MD_Person extends Model {

    /**
     * Инициализация модели
     * @return null
     */
    public static function initModel () {
        self::setModelTable('persons');
    }

    /**
     * Получить все лица foodfood
     * @return int
     */
    public static function getPersons () {
        $persons=self::getAll(null,'id DESC');
        return $persons;
    }
    /**
     * Получить лицо фудфуда
     * @return int
     */
    public static function getPerson ($id=null) {
        if (empty($id)) {
            $person=self::get(null,'id DESC');
        } else {
            $person=self::get('id='.DB::quote($id));
        }
        if (empty($person)) return null;
        preg_match_all("|<q>(.*)</q>|Uis", $person['person_questions'],$person_q);
        preg_match_all("|<a>(.*)</a>|Uis", $person['person_questions'],$person_a);
        $questions = Array ();
        $counter = 0;
        foreach ($person_q[1] as $q) {
            $question['q']=$q;
            $question['a']=$person_a[1][$counter];
            $question['class']=$counter%2==1 ? 'second' : '' ;
            array_push($questions, $question);
            $counter++;
        }
        $person['person_questions']=$questions;
        return $person;
    }
    /**
     * Получить лицо фудфуда, которому нравится ресторан
     * @return int
     */
    public static function getLikePerson ($rest_id) {
        $person=self::get('show_on LIKE "%'.DB::escape($rest_id).'%"', 'RAND()');
        if (empty($person)) return null;
        preg_match_all("|<q>(.*)</q>|Uis", $person['person_questions'],$person_q);
        preg_match_all("|<a>(.*)</a>|Uis", $person['person_questions'],$person_a);
        $questions = Array ();
        $counter = 0;
        foreach ($person_q[1] as $q) {
            $question['q']=$q;
            $question['a']=$person_a[1][$counter];
            $question['class']=$counter%2==1 ? 'second' : '' ;
            array_push($questions, $question);
            $counter++;
        }
        $person['person_questions']=$questions;
        return $person;
    }
    /**
     * Получить случайное лицо фудфуда
     * @return int
     */
    public static function getPersonRand () {
        $person=self::get(null, 'RAND()');
        preg_match_all("|<q>(.*)</q>|Uis", $person['person_questions'],$person_q);
        preg_match_all("|<a>(.*)</a>|Uis", $person['person_questions'],$person_a);
        $questions = Array ();
        $counter = 0;
        foreach ($person_q[1] as $q) {
            $question['q']=$q;
            $question['a']=$person_a[1][$counter];
            $question['class']=$counter%2==1 ? 'second' : '' ;
            array_push($questions, $question);
            $counter++;
        }
        $person['person_questions']=$questions;
        return $person;
    }
}