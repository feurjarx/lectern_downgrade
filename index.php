<?php
//phpinfo(); die();
include 'requires.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$options = array(
    'em'    => $em,
    'conf'  => array(
        'root_dir' => $_SERVER['DOCUMENT_ROOT']
    ),
    'route' => $uri
);

switch (true) {

    // INDEX
    case (in_array($uri, array('/index.php', '/')) !== FALSE):
        $c = new HomeController($options);
        $c->indexAction();
        break;
    case ('/about' === $uri):
        $c = new HomeController($options);
        $c->aboutAction();
        break;

    // SIGNUP
    case ('/signup' === $uri):
        $c = new SignUpController($options);
        $c->signUpAction(array(
            'POST'  => $_POST,
            'FILES' => $_FILES
        ));
        break;
    case ('/signup/confirm' === $uri && isset($_GET['id']) && isset($_POST['password']) && isset($_POST['new_pass_session'])):
        $c = new SignUpController($options);
        $c->signUpFinallyAction($_REQUEST);
        break;
    case ('/signup/confirm' === $uri && isset($_GET['id']) && isset($_GET['hash'])):
        $c = new SignUpController($options);
        $c->signUpConfirmAction($_GET);
        break;
    case ('/auth' === $uri && isset($_POST['login']) && isset($_POST['password'])):
        $c = new AuthController($options);
        $c->signInAction($_POST);
        break;
    case ('/logout' === $uri && isset($_POST['flash'])):
        $c = new AuthController($options);
        $c->logoutAction($_POST);
        break;


    // UPLOAD
    case ('/upload' === $uri && isset($_POST) && isset($_FILES)):
        $c = new UploadAjaxContoller($options);
        $c->uploadAction(array(
            'POST'  => $_POST,
            'FILES' => $_FILES
        ));
        break;

    // CABINET
    case ('/cabinet' === $uri):
        $c = new CabinetController($options);
        $c->indexAction();
        break;

    // AD
    case ('/employer/ad/plus' === $uri && isset($_POST) && Utils::isAjax()):
        $c = new CabinetController($options);
        $c->createAdAjaxAction($_POST);
        break;
    case ('/employer/ad/remove' === $uri && isset($_POST) && Utils::isAjax()):
        $c = new CabinetController($options);
        $c->removeAdAjaxAction($_POST);
        break;
    case ('/get/ads' === $uri && Utils::isAjax() && $_POST):
        $c = new HomeController($options);
        $c->getAdsAjaxAction($_POST);
        break;
    case (isset($_SESSION['flash']) && ('/ad/accept/' . $_SESSION['flash']) === $uri && Utils::isAjax() && $_POST):
        $c = new AdminController($options);
        $c->adProcessingAction($_POST);
        break;
        

    // CV
    case ('/student/cv/save' === $uri && isset($_POST) && Utils::isAjax()):
        $c = new CabinetController($options);
        $c->saveCvAjaxAction($_POST);
        break;
    case ('/get/cvs' === $uri && Utils::isAjax() && $_POST):
        $c = new HomeController($options);
        $c->getCvsAjaxAction($_POST);
        break;

    case ('/student/cv/send' === $uri && isset($_POST) && Utils::isAjax()):
        $c = new HomeController($options);
        $c->cvSendingAjaxAction($_POST);
        break;

    // VACANCIES
    case ('/vacancies' === $uri):
        $c = new VacanciesController($options);
        $c->indexAction();
        break;
    
    // REVIEWS
    case ('/reviews' === $uri):
        $c = new ReviewsController($options);
        $c->indexAction();
        break;
    case ('/review/new' === $uri && Utils::isAjax() && $_POST):
        $c = new ReviewsController($options);
        $c->createReviewAction($_POST);
        break;
    

    // ERRORS
    case ('/access/denied' === $uri):
        $c = new ErrorController($options);
        $c->errorRenderAction(Constants::ERROR_ACCESS_DENIED);
        break;

    // IFRAME ANIMATION
    case ('/animation' === $uri):

        $options['is_flash'] = false;
        $c = new HomeController($options);
        $c->animationAction();
        break;
    
    default:
        header('Status: 404 Not Found');
        $c = new ErrorController($options);
        $c->errorRenderAction(Constants::ERROR_NOT_FOUND);
}