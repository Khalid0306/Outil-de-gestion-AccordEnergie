<?php

namespace App\Date;


class Month
{

   public $days = [
      'Lundi',
      'Mardi',
      'Mercredi',
      'Jeudi',
      'Vendredi',
      'Samedi',
      'Dimanche',
  ];
   private $months = [
      1 => 'Janvier',
      2 => 'Février',
      3 => 'Mars',
      4 => 'Avril',
      5 => 'Mai',
      6 => 'Juin',
      7 => 'Juillet',
      8 => 'Août', 
      9 => 'Septembre',
      10 => 'Octobre',
      11 => 'Novembre', 
      12 => 'Décembre'];
   private $year;

   private $month;

   public function __construct(?int $month = null, ?int $year = null)
   {
      if ($month === null){
         $month = intval(date('m'));
      }

      if ($year === null){
         $year = intval(date('Y'));
      }

      $month = $month % 12;

      if ($year < 1970) {
         throw new \Exception("L'année $year n'est pas valide");
      }

      $this->month = $month;
      $this->year = $year;
   }

   public function getStartingDay (): \DateTime {
      return new \DateTime("{$this->year}-{$this->month}-01");
   }

   public function toString (): string {
      return $this->months[$this->month]. ' ' .$this->year;
   }

   public function getWeeks (): int {
      $start = $this->getStartingDay();
      $end = (clone $start)->modify('+1 month -1 day');
      $weeks = intval($end->format('W')) - intval($start->format('W')) + 1;
      if ($weeks < 0) {
         $weeks = intval($end->format('W'));
      }
      return $weeks;
   }

}
