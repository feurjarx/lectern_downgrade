<?php

/**
 * Created by PhpStorm.
 * Date: 02.05.2016
 * Time: 22:11
 */

use Entity\Ad;
use Entity\Review;

class ReviewsController extends BaseController
{
    private $templatePath = './templates/reviews.php';

    /**
     * ReviewsController constructor.
     * @param $options
     */
    function __construct($options)
    {
        parent::__construct($options);
        /*if (!$this->getCurrentUser()) {

            header('Location: ' . Utils::getHttpHost() . '/' . 'access/denied');
            exit(0);
        }*/
    }

    public function indexAction()
    {
        $em = $this->em;

        $qb = $em->createQueryBuilder();

        $qb
            ->select('review')
            ->from('Entity\Review', 'review')
            ->orderBy('review.publishedAt', 'DESC')
            ->setMaxResults(10)
        ;

        /** @var Ad[] $ads */
        $reviews = $qb->getQuery()->getResult();

        $active_item = 'reviews';
        require $this->templatePath;
    }

    /**
     * @param $post
     */
    public function createReviewAction($post)
    {
        if (!$this->getRole()) {
            header('Location: ' . Utils::getHttpHost() . '/' . 'access/denied');
            exit(0);
        }

        $params = Utils::arraySerialization(array(
            'title',
            'description',
            'rating',
            'g-recaptcha-response'

        ), $post);

        if (!in_array(null, $params)) {

            if ($curl = curl_init()) {

                curl_setopt($curl, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_POSTFIELDS, 'secret=6LcxfSETAAAAAEr08L9lKOfy3sVzktStWqoHMxOx&response=' . $params['g-recaptcha-response'] . '&remoteip=' . $_SERVER['REMOTE_ADDR']);
                curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);

                $data = curl_exec($curl);

                curl_close($curl);

		$j = json_decode($data, true);
                if ($j['success']) {
                    
                    $em = $this->em;
                    
                    $review = new Review();
                    
                    $review
                        ->setUser($em->getReference('Entity\Review', $this->getCurrentUser()->getId()))
                        ->setTitle($params['title'])
                        ->setDescription($params['description'])
                        ->setRating($params['rating'])
                    ;

                    try {

                        $em->persist($review);
                        $em->flush();

                        $result = array(
                            'type' => 'success',
                            'message' => 'Успешно! Отзыв размещен'
                        );

                    } catch (Exception $exc) {

                        $result = array(
                            'type' => 'error',
                            'message' => 'Ошибка сервера №' . $exc->getCode()
                        );
                    }

                } else {

                    $result = array(
                        'type' => 'error',
                        'message' => 'Ошибка сервера (grecaptcha error)'
                    );
                }

            } else {

                $result = array(
                    'type' => 'error',
                    'message' => 'Ошибка сервера'
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