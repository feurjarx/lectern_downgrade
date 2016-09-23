<?php

/**
 * Created by PhpStorm.
 * Date: 02.05.2016
 * Time: 22:11
 */

use Entity\Ad;

class VacanciesController extends BaseController
{
    private $templatePath = './templates/vacancies.php';

    /**
     * VacanciesController constructor.
     * @param $options
     */
    function __construct($options)
    {
        parent::__construct($options);
        if (
            !$this->getCurrentUser()
            ||
            (
                $this->getCurrentUser()
                &&
                Constants::EMPLOYER_ROLE !== $this->getCurrentUser()->getRole()
            )
        ) {

            header('Location: ' . Utils::getHttpHost() . '/' . 'access/denied');
            exit(0);
        }
    }

    public function indexAction()
    {
        $em = $this->em;

        $qb = $em->createQueryBuilder();

        $qb
            ->select('ad')
            ->from('Entity\Ad', 'ad')
            ->where($qb->expr()->eq('ad.isConfirmed', 1))
            ->orderBy('ad.publishedAt', 'DESC')
            ->setMaxResults(10)
        ;

        /** @var Ad[] $ads */
        $ads = $qb->getQuery()->getResult();

        $role = Constants::EMPLOYER_ROLE;

        $active_item = 'vacancies';
        require $this->templatePath;
    }
}