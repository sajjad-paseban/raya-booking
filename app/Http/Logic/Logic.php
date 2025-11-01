<?php

namespace App\Http\Logic;

use Illuminate\Support\Facades\Response;

abstract class Logic{
    private static int $status_code = 200;
    private static $data = [];
    private static string $message = '';
    
    public static function status($status_code = 200): static{
        self::$status_code = $status_code;
        
        return new static();
    }

    public static function message($msg = ''): static{
        self::$message = $msg;

        return new static();
    }

    public static function data($dtl): static{
        self::$data = $dtl;

        return new static();
    }
    
    public static function response(){
        $format = [
            'result' => self::$data,
            'message' => self::$message,
            'status_code' => self::$status_code
        ];

        return Response::json($format, self::$status_code);
    }
}