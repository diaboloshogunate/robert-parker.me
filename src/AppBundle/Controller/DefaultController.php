<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type;

use Symfony\Component\Validator\Constraints as Assert;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $form = $this->quoteForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $form_data = $form->getData();
            $file = $form_data['attachment'];
            $message = \Swift_Message::newInstance()
                ->setSubject('Quote Request from '.htmlentities($form_data['name']).($form_data['company']?' @ '.htmlentities($form_data['company']):''))
                ->setFrom('noreply@robert-parker.me')
                ->setTo('rparker@yamiko.ninja')
                ->setBody(
                    $this->renderView(
                        'emails/estimate.html.twig',
                        [
                            'name' => $form_data['name'],
                            'company' => $form_data['company'],
                            'email' => $form_data['email'],
                            'phone' => $form_data['phone'],
                            'service' => $form_data['service'],
                            'timeline' => $form_data['timeline'],
                            'budget' => $form_data['budget'],
                            'details' => $form_data['details'],
                        ]
                    ),
                    'text/html'
                )
            ;
            if($file) {
                $filename = date('Y-m-d-U') . '-' . $file->getClientOriginalName();
                $attachment = $file->move('uploads', $filename);
                $message->attach(\Swift_Attachment::fromPath('uploads/'.$filename));
            }
            $this->get('mailer')->send($message);
            return $this->render('default/confirmation.html.twig');
        }

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/privacy-policy", name="privacy")
     */
    public function privacyAction(Request $request)
    {
        return $this->render('default/privacy.html.twig', []);
    }

    /**
     * @Route("/confirmation", name="confirmation")
     */
    public function confirmationAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/confirmation.html.twig');
    }

    private function quoteForm()
    {
        return $this->createFormBuilder()
            ->add('name', Type\TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'max' => 64,
                    ]),
                ]
            ])
            ->add('company', Type\TextType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'max' => 64,
                    ]),
                ],
            ])
            ->add('email', Type\EmailType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'max' => 128,
                    ]),
                ]
            ])
            ->add('phone', Type\TextType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'max' => 64,
                    ]),
                ],
            ])
            ->add('service', Type\ChoiceType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'choices' => [
                    'Web Development' => 'web',
                    'Application Development' => 'app',
                    'API Integration' => 'api',
                    'Consulting' => 'consult',
                ]
            ])
            ->add('timeline', Type\DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'attr' => ['class' => 'datepicker'],
            ])
            ->add('budget', Type\ChoiceType::class, [
                'constraints' => [
                    new Assert\NotBlank()
                ],
                'choices' => [
                    '$2,000 or less' => '2k',
                    '$2,000 - $5,000' => '2-5k',
                    '$5,000 - $10,000' => '5-10k',
                    '$10,000 - $25,000' => '10-25k',
                    '$25,000 - $50,000' => '25-50k',
                    '$50,000 or more' => '50k+'
                ]
            ])
            ->add('attachment', Type\FileType::class, [
                'required' => false,
            ])
            ->add('details', Type\TextareaType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'max' => 5000,
                    ]),
                ],
            ])
            ->getForm();
    }
}
