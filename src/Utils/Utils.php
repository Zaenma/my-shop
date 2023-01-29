<?php

namespace src\Utils;

class Utils
{
    public function previwpdf(string $path)
    {
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename=' . $path);
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        return readfile($path);
    }
}