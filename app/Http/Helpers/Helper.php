<?php

namespace App\Http\Helpers;

class Helper {

	public static function changeCharset($argv, $isImport = false)
    {
        $tmp = [];
        foreach ($argv as $value) {
            if (!$isImport) {
                $value = mb_convert_encoding($value, "Shift-JIS", "UTF-8");
            } else {
                $value = mb_convert_encoding($value, "UTF-8", "Shift-JIS");
            }
            array_push($tmp, $value);
        }
        return $tmp;
    }

	public static function setFileName($fileName,$time = "")
    {
        $data = [];

        $path = storage_path('csv/');

        if (!is_dir($path)) {
            try {
                File::makeDirectory($path, $mode = 0777, true, true);
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        $data['pathFileName'] = $path . $fileName . $time . '.csv';
        $data['fileName'] = $fileName . $time . '.csv';
        return $data;
    }
    
    public static function setColorOfArticleClassName($ArticleClassName = '')
    {
    	$listArticleClassColors = AppData::listArticleClassColor;
    	foreach($listArticleClassColors as $key => $item)
    	{
    		if(in_array($ArticleClassName, $item)) return $key;
    	}

    	return 1;
    }

    public static function getHashPassword($pw, $seq)
    {
        $salt = $seq . 'SAAJSALT';
        return \Hash::make($pw, [
            'memory' => 1024,
            'time' => 25,
            'threads' => 2,
            'salt' => $salt
        ]);
    }
}