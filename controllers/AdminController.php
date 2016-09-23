<?php

/**
 * Created by PhpStorm.
 * Date: 02.05.2016
 * Time: 22:11
 */

use Entity\Ad;
use Entity\Cv;
use Entity\User;
use Handlebars\Handlebars;

class AdminController extends BaseController
{
    private $templatePath = './templates/home.php';
    
    /**
     * AdminController constructor.
     * @param $options
     */
    function __construct($options)
    {
        parent::__construct($options);
        if (Constants::ADMIN_ROLE !== $this->getRole()) {

            header('Location: ' . Utils::getHttpHost() . '/' . 'access/denied');
            exit(0);
        }
    }

    /**
     * @param $post
     * @throws Exception
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function adProcessingAction($post)
    {
        $params = Utils::arraySerialization(array(
            'id',
            'type'

        ), $post);

        if (!in_array(null, $params)) {

            /** @var Ad $ad */
            $em = $this->em;

            if ($ad = $em->find('Entity\Ad', $params['id'])) {

                switch ($params['type']) {
                    case 'accept':

                        $ad->setIsConfirmed(1);

                        $message = 'Объявление успешно опубликовано';
                        break;

                    case 'remove':

                        $em->remove($ad);

                        $message = 'Объявление успешно удалено';
                        break;

                    default:
                        throw new Exception('Unknown type action for ad');
                }

                try {

                    $em->flush();

                    $result = array(
                        'type' => 'success',
                        'message' => $message
                    );

                } catch (Exception $exc) {

                    $result = array(
                        'type' => 'error',
                        'message' => 'Ошибка сервера №' . $exc->getCode() . '. Сообщение: ' . $exc->getMessage()
                    );
                }

            } else {

                $result = array(
                    'type' => 'warning',
                    'message' => 'Объявление не найдено'
                );
            }

        } else {

            $result = array(
                'type' => 'error',
                'message' => 'Неверные данные'
            );
        }

        echo json_encode($result);
    }
}