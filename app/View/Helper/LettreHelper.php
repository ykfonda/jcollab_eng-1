<?php

App::uses('AppHelper', 'View/Helper');
class LettreHelper extends AppHelper
{
    public $v1 = false;

    public function NumberToLetter($a)
    {
        if ($a == 0) {
            return '0.00 DHS';
        }
        $convert = explode('.', $a);

        if (isset($convert[1]) && $convert[1] != '' and intval($convert[1]) != 0) {
            return $this->NumberToLetter($convert[0]).' '.$this->NumberToLetter($convert[1]).' Centimes';
        } elseif (!isset($convert[1])/*  and intval($convert[1]) == 0 */ and $this->v1 == false) {
            //var_dump("ok");die();
            $this->v1 = true;

            return $this->NumberToLetter($convert[0]).' Dhs';
        }

        if ($a < 0) {
            return 'moins '.$this->NumberToLetter(-$a);
        }
        if ($a < 17) {
            switch ($a) {
                //case 0: return 'zero';
                case 1: return 'un';
                case 2: return 'deux';
                case 3: return 'trois';
                case 4: return 'quatre';
                case 5: return 'cinq';
                case 6: return 'six';
                case 7: return 'sept';
                case 8: return 'huit';
                case 9: return 'neuf';
                case 10: return 'dix';
                case 11: return 'onze';
                case 12: return 'douze';
                case 13: return 'treize';
                case 14: return 'quatorze';
                case 15: return 'quinze';
                case 16: return 'seize';
            }
        } elseif ($a < 20) {
            return 'dix-'.$this->NumberToLetter($a - 10);
        } elseif ($a < 100) {
            if ($a % 10 == 0) {
                switch ($a) {
                    case 20: return 'vingt';
                    case 30: return 'trente';
                    case 40: return 'quarante';
                    case 50: return 'cinquante';
                    case 60: return 'soixante';
                    case 70: return 'soixante-dix';
                    case 80: return 'quatre-vingt';
                    case 90: return 'quatre-vingt-dix';
                }
            } elseif (substr($a, -1) == 1) {
                if (((int) ($a / 10) * 10) < 70) {
                    return $this->NumberToLetter((int) ($a / 10) * 10).'-et-un';
                } elseif ($a == 71) {
                    return 'soixante-et-onze';
                } elseif ($a == 81) {
                    return 'quatre-vingt-un';
                } elseif ($a == 91) {
                    return 'quatre-vingt-onze';
                }
            } elseif ($a < 70) {
                return $this->NumberToLetter($a - $a % 10).'-'.$this->NumberToLetter($a % 10);
            } elseif ($a < 80) {
                return $this->NumberToLetter(60).'-'.$this->NumberToLetter($a % 20);
            } else {
                return $this->NumberToLetter(80).'-'.$this->NumberToLetter($a % 20);
            }
        } elseif ($a == 100) {
            return 'cent';
        } elseif ($a < 200) {
            return $this->NumberToLetter(100).' '.$this->NumberToLetter($a % 100);
        } elseif ($a < 1000) {
            return $this->NumberToLetter((int) ($a / 100)).' '.$this->NumberToLetter(100).' '.$this->NumberToLetter($a % 100);
        } elseif ($a == 1000) {
            return 'mille';
        } elseif ($a < 2000) {
            return $this->NumberToLetter(1000).' '.$this->NumberToLetter($a % 1000).' ';
        } elseif ($a < 1000000) {
            return $this->NumberToLetter((int) ($a / 1000)).' '.$this->NumberToLetter(1000).' '.$this->NumberToLetter($a % 1000);
        } elseif ($a == 1000000) {
            return 'millions';
        } elseif ($a < 2000000) {
            return $this->NumberToLetter(1000000).' '.$this->NumberToLetter($a % 1000000).' ';
        } elseif ($a < 1000000000) {
            return $this->NumberToLetter((int) ($a / 1000000)).' '.$this->NumberToLetter(1000000).' '.$this->NumberToLetter($a % 1000000);
        }
    }
}
