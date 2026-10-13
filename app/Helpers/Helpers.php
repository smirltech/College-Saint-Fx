<?php

namespace App\Helpers;

use App\Enums\InscriptionStatus;
use Illuminate\Support\Str;
use Pharaonic\Laravel\Readable\Readable;


class Helpers
{
    public static $appVersion = "0.0.1";

    public static function error()
    {
        return abort(404);
    }

    // remove spaces and special characters from a string
    public static function removeSpaceBetween($string): array|string|null
    {
        return preg_replace('/\s+/', '', $string);
    }

    public static function humanPermission($permission)
    {
        return $permission;
    }

    public static function balanceColor(float $reste): string
    {
        if ($reste < 0) {
            return 'danger';
        } else if ($reste == 0) {
            return 'success';
        } else {
            return 'primary';
        }
    }

    // formatBytes
    public static function formatBytes($bytes, $precision = 1): string
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public static function fakxePicsum($user_id, $width = 50, $height = 50): string
    {
        /*$req = Http::get("https://picsum.photos/id/{$user_id}/info");
        return json_decode($req->body())->download_url;*/

        return "https://picsum.photos/id/{$user_id}/{$width}/{$height}";

    }

    public static function admissionStatusColor($admissionStatus): string
    {

        switch ($admissionStatus) {
            case InscriptionStatus::pending:
                return "info";
            case InscriptionStatus::approved:
                return "success";
            case InscriptionStatus::rejected:
                return "danger";
            case InscriptionStatus::canceled:
                return "secondary";
            default :
                return "primary";
        }
    }

    public static function padStart($value, $length, $pad_string = '0'): string
    {
        return str_pad("$value", $length, $pad_string, STR_PAD_LEFT);
    }

    public static function currencyFormat($amount, $decimal = 0, $symbol = ''): string
    {

        if ($amount >= 1000000) {
            return Readable::getHumanNumber($amount) . ' ' . $symbol;
        }

        return number_format($amount, $decimal,',',' ') . ' ' . $symbol;

    }

    public static function fakePicsum($user_id, $width = 50, $height = 50): string
    {
        /*$req = Http::get("https://picsum.photos/id/{$user_id}/info");
        return json_decode($req->body())->download_url;*/

        return "https://picsum.photos/id/{$user_id}/{$width}/{$height}";

    }


    // fetchAvatar
    public static function fetchAvatar($name, $width = 50, $height = 50): string
    {
        $name = str_replace(' ', '+', $name);
        return "https://ui-avatars.com/api/?name={$name}&background=random&size={$width}x{$height}&color=random";
    }

    // pad
    public static function pad($number, $length = 2): string
    {
        return Str::padLeft($number, $length, '0');
    }

    public static function colorAlert($percent): string
    {
        if ($percent < 10) {
            return 'danger';
        } else if ($percent < 30) {
            return 'warning';
        } else if ($percent < 50) {
            return 'alert';
        } else if ($percent < 70) {
            return 'success';
        } else {
            return '';
        }
    }

    public static function textAlert($percent): string
    {
        if ($percent < 10) {
            return "Très bas";
        } else if ($percent < 30) {
            return 'Bas';
        } else if ($percent < 50) {
            return 'Attention';
        } else if ($percent < 70) {
            return 'Bon';
        } else if ($percent < 90) {
            return 'Très Bon';
        } else {
            return 'Excellent';
        }
    }
}
