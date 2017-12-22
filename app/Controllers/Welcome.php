<?php

namespace App\Controllers;

use Core\View;
use Core\Controller;
use Helpers\Session;


class Welcome extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->language->load('Welcome');
    }

    public function index()
    {
        $data['title'] = "Gerador de gráficos";

        View::renderTemplate('header', $data);
        View::render('Welcome/Welcome', $data);
        View::renderTemplate('footer', $data);
    }

    public function resultado()
    {
        $data['title'] = "Gráfico(s) para ".$_POST['binary'];
        $string = preg_replace("/[^0-1]/", "",preg_replace('/\s+/', '', $_POST['binary']));
        $array_binary = str_split($string);
        if(!empty($_POST['tipo'])) {
            foreach ($_POST['tipo'] as $t) {
                switch ($t) {
                    case 0:
                        // NRZ-L
                        $data['resultado']['nome'][] = "NRZ-L";
                        $data['resultado']['retorno'][] = self::nrzl($array_binary);
                        break;
                    case 1:
                        // NRZI
                        $data['resultado']['nome'][] = "NRZI";
                        $data['resultado']['retorno'][] = self::nrzi($array_binary);
                        break;
                    case 2:
                        // BIPOLAR-AMI
                        $data['resultado']['nome'][] = "BIPOLAR-AMI";
                        $data['resultado']['retorno'][] = self::bipolar($array_binary);
                        break;
                    case 3:
                        // PSEUDOTERNARY
                        $data['resultado']['nome'][] = "PSEUDOTERNARY";
                        $data['resultado']['retorno'][] = self::pseudoternary($array_binary);
                        break;
                    case 4:
                        // MANCHESTER
                        $data['resultado']['nome'][] = "MANCHESTER";
                        $data['resultado']['retorno'][] = self::manchester($array_binary);
                        break;
                    case 5:
                        // DIFERENTIAL MANCHESTER
                        $data['resultado']['nome'][] = "DIFERENTIAL MANCHESTER";
                        $data['resultado']['retorno'][] = self::diferential_manchester($array_binary);
                        break;
                    default:
                        $data['resultado']['nome'][] = "NRZ-L";
                        $data['resultado']['retorno'][] = self::nrzl($array_binary);
                        break;
                }
            }
        } else {
            $data['resultado']['nome'][] = "NRZ-L";
            $data['resultado']['retorno'][] = self::nrzl($array_binary);
        }

        View::renderTemplate('header', $data);
        View::render('Welcome/Resultado', $data);
        View::renderTemplate('footer', $data);
    }
    
    public function nrzl($array_binary){
        $clock = $array_bit = 0;
        $array_returno = array();
        foreach($array_binary as $bit){
            $clock = $clock + 10;
            if($bit == 1)
                $array_bit = -1;
            else
                $array_bit = 1;
            $array_returno[$clock] = $array_bit;
        }
        $array_returno[$clock+10] = $array_bit;
        return $array_returno;
    }

    private function nrzi($array_binary){
        $clock = $array_bit = 0;
        $array_returno = array();
        foreach($array_binary as $bit){
            $clock = $clock + 10;
            if($bit == 1)
                $array_bit = ($array_bit == 1 ? -1 : 1);
            //else
                //$array_bit = $array_bit;
            $array_returno[$clock] = $array_bit;
        }
        $array_returno[$clock+10] = $array_bit;
        return $array_returno;
    }

    private function bipolar($array_binary){
        $clock = $array_bit = 0;
        $array_returno = array();
        $last = -1;
        foreach($array_binary as $bit){
            $clock = $clock + 10;
            if($bit == 0)
                $array_bit = 0;
            else
                $array_bit = $last = ($last == -1 ? 1 : -1);
            $array_returno[$clock] = $array_bit;
        }
        $array_returno[$clock+10] = $array_bit;
        return $array_returno;
    }

    private function pseudoternary($array_binary){
        $clock = $array_bit = 0;
        $array_returno = array();
        $last = -1;
        foreach($array_binary as $bit){
            $clock = $clock + 10;
            if($bit == 1)
                $array_bit = 0;
            else
                $array_bit = $last = ($last == -1 ? 1 : -1);
            $array_returno[$clock] = $array_bit;
        }
        $array_returno[$clock+10] = $array_bit;
        return $array_returno;
    }

    private function manchester($array_binary){
        $clock = 0;
        $array_returno = array();
        foreach($array_binary as $bit){
            $clock = $clock + 10;
            if($bit == 0) {
                $array_returno[$clock] = 1;
                $array_returno[$clock+5] = -1;
            } else {
                $array_returno[$clock] = -1;
                $array_returno[$clock+5] = 1;
            }
        }
        $array_returno[$clock+10] = $array_returno[$clock+5];
        return $array_returno;
    }

    private function diferential_manchester($array_binary){
        $clock = 0;
        $sync = false;
        $array_returno = array();
        foreach($array_binary as $bit){
            $clock = $clock + 10;
            $sync = ($bit == 1 ? $sync ? false : true : $sync);
            if($sync) {
                $array_returno[$clock] = 1;
                $array_returno[$clock + 5] = -1;
            } else {
                $array_returno[$clock] = -1;
                $array_returno[$clock + 5] = 1;
            }
        }
        $array_returno[$clock+10] = $array_returno[$clock+5];
        return $array_returno;
    }

}
