<?php

/**
 * Created by PhpStorm.
 * Date: 02.05.2016
 * Time: 22:15
 */
class UploadAjaxContoller extends BaseController
{
    /**
     * ErrorController constructor.
     * @param $options
     */
    function __construct($options)
    {
        parent::__construct($options);
        header('Content-Type: application/json');
    }

    public function uploadAction($request)
    {
        $filename = md5(basename($request['POST']['name'])) . '.' . $request['POST']['ext'];
        $uploadFile = Constants::UPLOAD_PHOTOS_DIR . $filename;

        if (move_uploaded_file($request['FILES']['data']['tmp_name'], $uploadFile)) {

            $result = array(
                'type' => 'success',
                'name' => $filename
            );

        } else {

            $result = array(
                'type' => 'error'
            );
        }

        echo json_encode($result);
    }
}