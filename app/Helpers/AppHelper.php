<?php
namespace App\Helpers;

class AppHelper
{
    public static function addHttp($url) {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }
        return $url;
    }
    
    public static function mesPort($mes) {
        $mes = $mes == "January" ? "Janeiro" : $mes;
        $mes = $mes == "February" ? "Fevereiro" : $mes;
        $mes = $mes == "March" ? "Março" : $mes;
        $mes = $mes == "April" ? "Abril" : $mes;
        $mes = $mes == "May" ? "Maio" : $mes;
        $mes = $mes == "June" ? "Junho" : $mes;
        $mes = $mes == "July" ? "Julho" : $mes;
        $mes = $mes == "August" ? "Agosto" : $mes;
        $mes = $mes == "September" ? "Setembro" : $mes;
        $mes = $mes == "October" ? "Outubro" : $mes;
        $mes = $mes == "November" ? "Novembro" : $mes;
        $mes = $mes == "December" ? "Dezembro" : $mes;
        //
        $mes = $mes == "Jan" ? "Jan" : $mes;
        $mes = $mes == "Feb" ? "Fev" : $mes;
        $mes = $mes == "Mar" ? "Mar" : $mes;
        $mes = $mes == "Apr" ? "Abr" : $mes;
        $mes = $mes == "May" ? "Mai" : $mes;
        $mes = $mes == "Jun" ? "Jun" : $mes;
        $mes = $mes == "Jul" ? "Jul" : $mes;
        $mes = $mes == "Aug" ? "Ago" : $mes;
        $mes = $mes == "Sep" ? "Set" : $mes;
        $mes = $mes == "Oct" ? "Out" : $mes;
        $mes = $mes == "Nov" ? "Nov" : $mes;
        $mes = $mes == "Dec" ? "Dez" : $mes;
        //
        return $mes;
    }

    public static function formataDataExtenso($data){
        $data_format = '';
        if(!empty($data['dia']) && !empty($data['mes']) && empty($data['ano']))
            $data_format = "{$data['dia']} de {$data['mes']}";
        if(empty($data['dia']) && !empty($data['mes']) && !empty($data['ano']))
            $data_format = "{$data['mes']} de {$data['ano']}";
        if(!empty($data['dia']) && !empty($data['mes']) && !empty($data['ano']))
            $data_format = "{$data['dia']} de {$data['mes']} de {$data['ano']}";
        if(empty($data['dia']) && empty($data['mes']) && !empty($data['ano']))
            $data_format = "{$data['ano']}";

        return $data_format;
    }

    public static function formataDataCurta($data){
        $data_format = '';
        if(!empty($data['dia']) && !empty($data['mes']) && empty($data['ano']))
            $data_format = "{$data['dia']}/{$data['mes']}";
        if(empty($data['dia']) && !empty($data['mes']) && !empty($data['ano']))
            $data_format = "{$data['mes']}/{$data['ano']}";
        if(!empty($data['dia']) && !empty($data['mes']) && !empty($data['ano']))
            $data_format = "{$data['dia']}/{$data['mes']}/{$data['ano']}";
        if(empty($data['dia']) && empty($data['mes']) && !empty($data['ano']))
            $data_format = "{$data['ano']}";

        return $data_format;
    }

}