<?php

/**
 * Created by PhpStorm.
 * Date: 02.05.2016
 * Time: 22:11
 */

use Entity\Ad;
use Entity\Cv;
use Entity\Request;
use Handlebars\Handlebars;

class HomeController extends BaseController
{
    private $templatePath = './templates/home.php';
    
    /**
     * HomeController constructor.
     * @param $options
     */
    function __construct($options)
    {
        parent::__construct($options);
    }
    
    /**
     * get ads which already sending
     * 
     * @param $ads
     * @return array
     */
    private function getNotSendableAdsIds($ads) {
        
        $em = $this->em;
        
        $adsIds = array_map(function($it) {
            /** @var Ad $it */
            return $it->getId();
            
        }, $ads);

        $qb = $em->createQueryBuilder();
        $expr = $qb->expr();

        $qb
            ->select('request')
            ->from('Entity\Request', 'request')
            ->join('request.cv', 'cv')
            ->join('request.ad', 'ad')
            ->join('cv.person', 'person')
            ->where($expr->eq('person', $this->currentUser->getPerson()->getId()))
            ->andWhere($expr->in('ad', $adsIds))
        ;

        $sql = $qb->getQuery()->getSQL();

        $requests = $qb->getQuery()->getResult();

        $notSendableAdsIds = array();
        
        if ($requests) {

            $notSendableAdsIds = array_map(function($it) {
                /** @var Request $it */
                return $it->getAd()->getId();

            }, $requests);
        }
        
        return $notSendableAdsIds;
    }

    public function indexAction()
    {
        $role = $this->getRole();

        $em = $this->em;

        $qbuilder = function($limit, $type) use($em) {

            $qb = $em->createQueryBuilder();

            switch ($type) {

                case 'Ad':

                    $qb
                        ->select('ad')
                        ->from('Entity\Ad', 'ad')
                        ->where($qb->expr()->eq('ad.isConfirmed', 1))
                        ->orderBy('ad.publishedAt', 'DESC')
                        ->setMaxResults($limit)
                    ;

                    break;

                case 'Cv':

                    $qb
                        ->select('cv')
                        ->from('Entity\Cv', 'cv')
                        ->orderBy('cv.createdAt', 'DESC')
                        ->setMaxResults($limit)
                    ;

                    break;

                default:
                    $qb = null;
            }

            return $qb;
        };

        switch (true){

            case Constants::STUDENT_ROLE === $role:
                /** @var Ad[] $ads */
                $ads = $qbuilder(10, 'Ad')->getQuery()->getResult();

                $notSendableAdsIds = array();
                if ($this->getRole() && $ads && count($ads)) {
                    $notSendableAdsIds = $this->getNotSendableAdsIds($ads);
                }
                
                break;

            case Constants::EMPLOYER_ROLE === $role:
                /** @var Cv[] $cvs */
                $cvs = $qbuilder(10, 'Cv')->getQuery()->getResult();
                break;

            case Constants::ADMIN_ROLE === $role:
                /** @var \Doctrine\ORM\QueryBuilder $qb */
                $qb = $qbuilder(10, 'Ad');
                $qb->resetDQLPart('where');
                $qb->where($qb->expr()->eq('ad.isConfirmed', 0));
                $ads = $qb->getQuery()->getResult();
                break;

            default:

                $cvs = $qbuilder(3, 'Cv')->getQuery()->getResult();
                $ads = $qbuilder(3, 'Ad')->getQuery()->getResult();
        }

        $active_item = 'home';
        require $this->templatePath;
    }

    /**
     * About
     */
    public function aboutAction()
    {
        $active_item = 'about';

        $offContent = true;

        require __DIR__ . '/../templates/about.php';
    }

    /**
     * @param $request
     */
    public function getAdsAjaxAction($request)
    {
        $params = Utils::arraySerialization(array('offset'), $request);

        if (!in_array(null, $params)) {

            $params = Utils::arraySerialization(array(
                'limit',
                'filters'

            ), $request, $params);

            $em = $this->em;

            $qb = $em->createQueryBuilder();
            $expr = $qb->expr();

            $qb
                ->select('ad')
                ->from('Entity\Ad', 'ad')
                ->where($qb->expr()->eq('ad.isConfirmed', $this->getRole() === Constants::ADMIN_ROLE ? 0 : 1));


            if ($params['filters']) {
                
                foreach ($params['filters'] as $filter => $v) {

                    switch (true) {
                        case ('sphere' === $filter):

                            if (is_array($v)) {

                                $orX = $expr->orX();

                                foreach ($v as $item) {
                                    $orX->add($expr->eq('ad.sphere', $expr->literal($item)));
                                }

                                $qb->andWhere($orX);
                            }

                            break;
                        case ('salary_range' === $filter && $v !== '*'):

                            if ($v[0] === '>') {
                                $qb->andWhere($expr->gt('ad.salary', substr($v, 1)));
                            }

                            if ($v[0] === '<') {
                                $qb->andWhere($expr->lte('ad.salary', substr($v, 1)));
                            }

                            break;
                    }
                }
            }

            $qb
                ->orderBy('ad.publishedAt', 'DESC')
                ->setFirstResult($params['offset'])
                ->setMaxResults($params['limit'] ? $params['limit'] : 10)
            ;

            /** @var Ad[] $ads */
            $ads = $qb->getQuery()->getResult();

            $isCvSendAble = ($user = $this->currentUser) && $user->getRole() === Constants::STUDENT_ROLE && $user->getPerson()->getCvs()->count();

            $rootActionsBlockHtml = null;
            if (Constants::ADMIN_ROLE === $this->getRole()) {

                /** @var Handlebars $engine */
                $engine = new Handlebars;
                $rootActionsBlockHtml = $engine->render(file_get_contents(__DIR__ . '/../templates/hbs/rootActionsBlock.hbs'), array());
            }

            $result = array();

            $notSendableAdsIds = array();
            if ($this->getRole() && $ads && count($ads)) {
                $notSendableAdsIds = $this->getNotSendableAdsIds($ads);
            }

            foreach ($ads as $ad) {

                $person = $ad->getPerson();

                $result[] = array(
                    'id'              => $ad->getId(),
                    'name'            => ucfirst($ad->getName()),
                    'details'         => strip_tags($ad->getDetails()),
                    'salary'          => $ad->getSalary(),
                    'published_at'    => date('d/m/Y H:i:s', $ad->getPublishedAt()),
                    'user_img_url'    => $person->getUser()->getImgUrl(),
                    'sphere'          => Utils::getSpheresString( $ad->getSphere() ),
                    'person'          => array(
                        'last_name'    => $person->getLastName(),
                        'full_name'    => $person->getFullName(),
                        'organisation' => $person->getOrganisation()
                    ),
                    'is_cv_send_able' => $isCvSendAble && !in_array($ad->getId(), $notSendableAdsIds),
                    'html'            => $rootActionsBlockHtml
                );
            }

        } else {

            $result = array(
                'error' => 1,
                'message' => 'Неверные данные'
            );
        }
        
        echo json_encode($result);
    }

    /**
     * @param $request
     * @throws Exception
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function cvSendingAjaxAction($request)
    {
        if (!($user = $this->currentUser)) {
            throw new Exception('Access denied');
        }

        if ($user->getRole() !== Constants::STUDENT_ROLE || !$user->getPerson()->getCvs()->count()) {
            throw new Exception('Access denied');
        }

        $params = Utils::arraySerialization(array(
            'ad_id',
            'flash'

        ), $request);

        if (!in_array(null, $params)) {

            if ($params['flash'] === $_SESSION['previos_flash']) {

                /** @var Ad $ad */
                if ($ad = $this->em->find('Entity\Ad', $params['ad_id'])) {
                    /** @var Cv $cv */
			$temp = $user->getPerson()->getCvs();
                    $cv = $temp[0];

                    /** @var Handlebars $engine */
                    $engine = new Handlebars;

                    try {

                        $cvPerson = $cv->getPerson();

$wets = Utils::getWorkExperiencesTitles();
$sts =  Utils::getSchedulesTitles();

                        $html = $engine->render(file_get_contents('./templates/hbs/cvEmail.hbs'), array(
                            'fullname'           => $cvPerson->getFullName(),
                            'city'               => $cvPerson->getContact()->getAddress()->getCity(),
                            'organisation'       => $cvPerson->getOrganisation(),
                            'education'          => $cv->getEducation(),
                            'email'              => $cvPerson->getUser()->getEmail(),
                            'phone'              => $cvPerson->getContact()->getPhone(),
                            'website'            => $cvPerson->getContact()->getWebsites(),
                            'sphere'             => Utils::getSpheresString( $cv->getSphere()),
                            'skills'             => $cv->getSkills(),
                            'work_experience'    => $wets[ $cv->getWorkExperience() ],
                            'schedule'           => $sts[ $cv->getSchedule() ],
                            'ext_education'      => $cv->getExtEducation(),
                            'hobbies'            => $cv->getHobbies(),
                            'foreign_languages'  => $cv->getForeignLanguages(),
                            'about'              => $cv->getAbout(),
                            'is_married'         => $cv->getIsMarried(),
                            'is_drivers_license' => $cv->getIsDriversLicense(),
                            'is_smoking'         => $cv->getIsSmoking(),
                            'img_url'            => $cvPerson->getUser()->getImgUrl()
                        ));

			$letter =  new Letter();
                        $letter
                            ->setTo(array( $ad->getPerson()->getUser()->getEmail() => '' ))
                            ->setFrom("yakoann03@gmail.com", "Резюме от студента с сайта lectern")
                            ->setSubject("Резюме")
                            ->setBody($html)
                            ->send()
                        ;

                        $em = $this->em;

                        $request = new Request();
                        $request
                            ->setAd($em->getReference('Entity\Ad', $ad->getId()))
                            ->setCv($em->getReference('Entity\Cv', $cv->getId()))
                        ;

                        $em->persist($request);
                        $em->flush();

                        $result = array(
                            'type' => 'success',
                            'message' => 'Ваше резюме успешно отправлено работодателю!'
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
                        'message' => 'Выбранное объявление не существует'
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


    /**
     * @param $request
     */
    public function getCvsAjaxAction($request)
    {
        $params = Utils::arraySerialization(array('offset'), $request);

        if (!in_array(null, $params)) {

            $params = Utils::arraySerialization(array('limit', 'filters'), $request, $params);

            $em = $this->em;

            $qb = $em->createQueryBuilder();
            $expr = $qb->expr();

            $qb
                ->select('cv')
                ->from('Entity\Cv', 'cv')
                ->where($expr->eq('cv.accessType', $expr->literal(Constants::ACCESS_TYPE_PUBLIC)))
                ->orderBy('cv.createdAt', 'DESC')
                ->setFirstResult($params['offset'])
                ->setMaxResults($params['limit'] ? $params['limit'] : 10)
            ;

            if ($params['filters']) {

                foreach ($params['filters'] as $filter => $v) {

                    switch (true) {
                        case ('sphere' === $filter):

                            if (is_array($v)) {

                                $orX = $expr->orX();

                                foreach ($v as $item) {
                                    $orX->add($expr->eq('cv.sphere', $expr->literal($item)));
                                }

                                $qb->andWhere($orX);
                            }

                            break;
                    }
                }
            }

            /** @var Cv[] $cvs */
            $cvs = $qb->getQuery()->getResult();

            $result = array();
            foreach ($cvs as $cv) {

                $person = $cv->getPerson();
		$wets = Utils::getWorkExperiencesTitles();

                $result[] = array(
                    'id'              => $cv->getId(),
                    'sphere'          => Utils::getSpheresString( $cv->getSphere()),
                    'education'       => $cv->getEducation(),
                    'skills'          => $cv->getSkills(),
                    'work_experience' => $wets[ $cv->getWorkExperience() ],
                    'hobbies'         => $cv->getHobbies(),
                    'about'           => $cv->getAbout(),
                    'user_img_url'    => $cv->getPerson()->getUser()->getImgUrl(),
                    'created_at'      => date('d/m/Y', $cv->getCreatedAt()),
                    'person'          => array(
                        'last_name'    => $person->getLastName(),
                        'full_name'    => $person->getFullName(),
                        'organisation' => $person->getOrganisation()
                    ),
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

    /**
     * IFRAME LOAD
     */
    public function animationAction()
    {
        require __DIR__ . '/../templates/blocks/animation.php';
    }
}