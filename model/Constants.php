<?php

/**
 * Created by PhpStorm.
 * Date: 29.04.2016
 * Time: 21:43
 */
class Constants
{
    const
        ERROR_NOT_FOUND = 404,
        ERROR_ACCESS_DENIED = 403,


        STUDENT_ROLE = 'student',
        EMPLOYER_ROLE = 'employer',
        ADMIN_ROLE = 'root',

        UPLOAD_PHOTOS_DIR = './uploads/photos/',
        UPLOAD_PHOTOS_URL = '/uploads/photos/',
        DEFAULT_PHOTO_URL = '/assets/img/default-avatar.png',

        ACCESS_TYPE_PUBLIC = 'public',
        ACCESS_TYPE_PRIVATE = 'private';
}