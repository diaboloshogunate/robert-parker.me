<?php require_once '../vendor/autoload.php';

use Sonata\Sonata;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$sonata = new Sonata();
$sonata->apply($sonata->load('../config/live.yaml', false));

$sonata->get('/', function(Application $app){
    $response = new Response($app['twig']->render('@app/home.html.twig', ['title' => 'Web Design and Development in Portland OR']));
    $response->setTtl(300);
    return $response;
});

$sonata->post('/', function(Request $request, Application $app)
{
    // get values
    $name = $request->request->get('name');
    $company = $request->request->get('company');
    $email = $request->request->get('email');
    $message = $request->request->get('message');
    // error handle
    $errors = [];
    // check for required
    foreach(['email' => $email, 'name' => $name, 'message' => $message] as $field => $value)
    {
        if(!$value)
        {
            $errors[$field] = sprintf('%s is required', $field);
        }
    }
    if(!array_key_exists('email', $errors) && !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = 'a valid email is required';
    }
    if(!$errors)
    {
        $swift = \Swift_Message::newInstance()
            ->setSubject('Website Contact Request')
            ->setFrom([$email])
            ->setTo(['rparker@yamiko.ninja'])
            ->setBody($app['twig']->render('@app/contact.html.twig', [
                'email' => $email,
                'name' => $name,
                'company' => $company,
                'message' => $message
        ]));

        if($app['mailer']->send($swift))
        {
            $app['session']->getFlashBag()->add('success', 'The message was sent successfully. I will get back to you shortly.');
        }
        else
        {
            $app['session']->getFlashBag()->add('alert', 'The message failed to send. Please try again later or email me at rparker@yamiko.ninja.');
        }
    }
    else
    {
        foreach($errors as $field => $error)
        {
            $app['session']->getFlashBag()->add('alert', $error);
        }
    }

    return $app->render('@app/home.html.twig', [
        'title' => 'Web Design and Development in Portland OR',
        'form_email' => $email,
        'form_name' => $name,
        'form_company' => $company,
        'form_message' => $message
    ]);
});

$sonata->run();