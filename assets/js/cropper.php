<?php

namespace Cropper;

class Model_Cropper extends \Orm\Model
{
    public static $_table_name = 'medias';
    protected static $_properties = array(
        'id',
        'module_id',
        'directory',
        'type',
        'extension',
        'module_name',
        'title',
        'status'=>array('default'=>1),
        'created_at',
        'updated_at'
    );

    protected static $_observers = array(
            'Orm\Observer_CreatedAt' => array(
                'events' => array('before_insert'),
                'mysql_timestamp' => false,
            ),
            'Orm\Observer_UpdatedAt' => array(
                'events' => array('before_save'),
                'mysql_timestamp' => false,
            ),
        );

    public function getImage($type=null){
        $gallery = self::find($this->id);
        if($gallery){
            $url = \Uri::create('/').'cropper/get_image/'.$type.$gallery->title.'/'.$gallery->id;
            return $url;
        }else{
            $url = \Uri::create('/').'cropper/get_image/logo.png/';
            return $url;
        }
    }

    static function get_mime_type($file) {
        $mime_types = array(
            "pdf" => "application/pdf"
            , "exe" => "application/octet-stream"
            , "zip" => "application/zip"
            // ,"docx"=>"application/msword"
            , "docx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
            , "doc" => "application/msword"
            , "rtf" => "text/rtf"
            , "txt" => "text/plain"
            , "xls" => "application/vnd.ms-excel"
            , "ppt" => "application/vnd.ms-powerpoint"
            , "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation"
            , "gif" => "image/gif"
            , "png" => "image/png"
            , "jpeg" => "image/jpg"
            , "jpg" => "image/jpg"
            , "mp3" => "audio/mpeg"
            , "wav" => "audio/x-wav"
            , "mpeg" => "video/mpeg"
            , "mpg" => "video/mpeg"
            , "mpe" => "video/mpeg"
            , "mov" => "video/quicktime"
            , "avi" => "video/x-msvideo"
            , "3gp" => "video/3gpp"
            , "css" => "text/css"
            , "jsc" => "application/javascript"
            , "js" => "application/javascript"
            , "php" => "text/html"
            , "htm" => "text/html"
            , "html" => "text/html"
            , "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            , "xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template"
            , "potx" => "application/vnd.openxmlformats-officedocument.presentationml.template"
            , "ppsx" => "application/vnd.openxmlformats-officedocument.presentationml.slideshow"
            , "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation"
            , "sldx" => "application/vnd.openxmlformats-officedocument.presentationml.slide"
            , "docx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
            , "dotx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.template"
            , "xlam" => "application/vnd.ms-excel.addin.macroEnabled.12"
            , "xlsb" => "application/vnd.ms-excel.sheet.binary.macroEnabled.12"
        );
        $extention = explode('.', $file);
        $extension = end($extention);
        $extension = strtolower($extension);
        return $mime_types[$extension];
    }

}?>