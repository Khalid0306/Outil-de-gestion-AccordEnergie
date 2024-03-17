<?php

namespace Date;


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
      12 => 'Décembre'
   ];
   public $year;

   public $month;

   public function __construct(?string $month = null, ?int $year = null)
   {
      if ($month === null || $month < 1 || $month > 12) {
         $month = date('m');
      }

      if ($year === null) {
         $year = intval(date('Y'));
      }

      if ($year < 1970) {
         throw new \Exception("L'année $year n'est pas valide");
      }

      if ($month == 0) {
         $this->month = '0';
     } elseif (strlen($month) == 1) {
         $this->month = '0' . $month;
     } else {
         $this->month = $month;
     }

      $this->year = $year;
   }

   //Retourne le premier jour du mois
   public function getStartingDay(): \DateTime
   {
      return new \DateTime("{$this->year}-{$this->month}-01");
   }

   //Met le mois sous format String
   public function toString(): string
   {
      $month = intval($this->month);
      return $this->months[$month] . ' ' . $this->year;
   }

   // Renvoie le nombre de semaine dans le mois 
   public function getWeeks(): int
   {
      $start = $this->getStartingDay();
      $end = (clone $start)->modify('+1 month -1 day');
      $weeks = intval($end->format('W')) - intval($start->format('W')) + 1;
      if ($weeks < 0) {
         $weeks = intval($end->format('W'));
      }
      return $weeks;
   }

   //Renvoie les jours du mois actuelle
   public function withinMonth(\DateTime $date): bool
   {
      $test = $this->year . '-' . $this->month;

      if ($test == $date->format('Y-m')) {
         $return = true;
      } else {
         $return = false;
      }

      return $return;
   }

   //Renvoie le mois suivant
   public function nextMonth(): Month
   {
      $monthInt = intval($this->month) + 1;
      $year = $this->year;

      if ($monthInt > 12) {
         $monthInt = 1;
         $year += 1;
      }

      return new Month($monthInt, $year);
   }

   // Renvoie le mois précedent 
   public function previousMonth(): Month
   {
      $monthInt = intval($this->month) - 1;
      $year = $this->year;

      if ($monthInt < 1) {
         $monthInt = 12;
         $year -= 1;
      }

      return new Month($monthInt, $year);
   }

}
