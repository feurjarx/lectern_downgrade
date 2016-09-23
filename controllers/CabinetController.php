<?php
/**
 * Created by PhpStorm.
 * Date: 05.05.2016
 * Time: 22:17
 */

use Entity\User;
use Entity\Ad;
use Entity\Cv;
use Entity\Person;

class CabinetController extends BaseController
{
    /**
     * CabinetController constructor.
     * @param $options
     */
    function __construct($options)
    {
        parent::__construct($options);

        if (is_null($this->currentUser)) {
            header('Location: ' . Utils::getHttpHost() . '/' . 'access/denied');
            exit();
        }
    }

    /**
     * @var string
     */
    private $templatePath = './templates/cabinet.php';

    /**
     * index Cabinet
     */
    function indexAction() {

        switch ($this->getCurrentUser()->getRole()) {
            case Constants::STUDENT_ROLE:
                break;
            case Constants::EMPLOYER_ROLE:

                /** @var Ad[] $ads */
                $ads = $this->currentUser->getPerson()->getAds();

                $em = $this->em;

                $qb = $em->createQueryBuilder();
                $expr = $qb->expr();

                $qb
                    ->select('cv')
                    ->from('Entity\Cv', 'cv')
                    ->innerJoin('Entity\Request', 'request', 'WITH', 'cv = request.cv')
                    ->join('request.ad', 'ad')
                    ->join('ad.person', 'person')
                    ->where($expr->eq('person', $this->currentUser->getPerson()->getId()))
                ;

                /** @var Cv[] $recievedCvs */
                $recievedCvs = $qb->getQuery()->getResult();

                break;
        }

        require_once $this->templatePath;
    }

    /**
     * @param $request
     * @throws \Doctrine\ORM\ORMException
     */
    public function createAdAjaxAction($request)
    {
        $params = Utils::arraySerialization(array(
            'name',
            'details',
            'sphere'

        ), $request);

        if (!in_array(null, $params)) {

            $params = Utils::arraySerialization(array('salary'), $request, $params);

	    $temp = new Ad();
            $ad = $temp
		->setName($params['name'])
                ->setDetails($params['details'])
                ->setPerson($this->em->getReference('Entity\Person', $this->currentUser->getPerson()->getId()))
                ->setSalary($params['salary'])
                ->setSphere($params['sphere'])
            ;

            $this->em->persist($ad);
            $this->em->flush();

            $result = array(
                'complete_id' => $ad->getId(),
                'type' => 'success',
                'message' => 'Успешно! Объявление подано на рассмотрение'
            );

        } else {

            $result = array(
                'type' => 'error',
                'message' => 'Неверные данные'
            );
        }
        
        echo json_encode($result);
    }

    /**
     * @param $request
     * @throws \Doctrine\ORM\ORMException
     */
    public function removeAdAjaxAction($request)
    {
        if (isset($request['ids']) && $request['ids']) {

            /** @var Ad[] $ads */
            $em = $this->em;

            $ads = $em->getRepository('Entity\Ad')->findBy(array(
                'id' => $request['ids']
            ));

            $badAdsIds = array();
            foreach ($ads as $ad) {

                try {

                    $em->remove($ad);
                    $em->flush();

                } catch (Exception $e) {

                    $badAdsIds[] = $ad->getId();
                    continue;
                }
            }

            switch(true) {
                case (count($request['ids']) == count($badAdsIds)):

                    $result = array(
                        'type' => 'error',
                        'message' => 'Внимание! Ни одно объявление не удалено. Обратитесь в тех. поддержку'
                    );
                    break;

                case (count($badAdsIds) > 0):

                    $result = array(
                        'type' => 'warning',
                        'message' => 'Внимание! Некоторые объявление не были удалены. Обратитесь в тех. поддержку',
                        'complete_ids' => array_diff($request['ids'], $badAdsIds)
                    );
                    break;

                case (count($badAdsIds) == 0):

                    $result = array(
                        'type' => 'success',
                        'message' => 'Успешно! Отмеченные объявления были удалены',
                        'complete_ids' => $request['ids']
                    );
                    break;

                default:

                    $result = array(
                        'type' => 'error',
                        'message' => 'Серверная ошибка!'
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

    public function saveCvAjaxAction($request)
    {
        $params = Utils::arraySerialization(array(
            'flash',
            'access_type',
            'skills',
            'work_experience'
            
        ), $request);

        if (!in_array(null, $params)) {

            if ($params['flash'] === $_SESSION['previos_flash']) {

                $params = Utils::arraySerialization(array(
                    'id',
                    'sphere',
                    'hobbies',
                    'education',
                    'desire_salary',
                    'schedule',
                    'foreign_languages',
                    'is_drivers_license',
                    'is_smoking',
                    'is_married',
                    'about',

                ), $request, $params);

                try {

                    $em = $this->em;

                    $cv = (($cvId = $params['id']) && is_numeric($cvId)) ? $em->find('Entity\Cv', $cvId) : new Cv();

                    $cv = Utils::fillCv($params, $cv);
                    $cv->setPerson($em->getReference('Entity\Person', $this->currentUser->getPerson()->getId()));

                    $em->persist($cv);
                    $em->flush($cv);

                    $result = array(
                        'complete_id' => $cv->getId(),
                        'type'        => 'success',
                        'message'     => 'Резюме успешно сохранено!'
                    );

                } catch (Exception $exp) {

                    $result = array(
                        'type' => 'error',
                        'message' => 'Ошибка на сервере'
                    );
                }

            } else {

                $result = array(
                    'type' => 'error',
                    'message' => 'Ошибка доступа'
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