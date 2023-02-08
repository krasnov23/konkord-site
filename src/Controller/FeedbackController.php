<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Form\FeedbackType;
use App\Repository\FeedbackRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class FeedbackController extends AbstractController
{

    #[Route('/show-feedbacks', name: 'app_feedbacks', priority: 2)]
    public function allFeedbacks(FeedbackRepository $feedBacks): Response
    {
        return $this->render('feedback/all-feedbacks.html.twig',[
            'feedbacks' => $feedBacks
        ]);
    }


    #[Route('/feedback', name: 'app_feedback', priority: 2)]
    public function index(Request $request,FeedbackRepository $feedBacks,SluggerInterface $slugger, MailerInterface $mailer ): Response
    {
        $feedBack = new Feedback();

        $form = $this->createForm(FeedbackType::class,$feedBack);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid())
        {
            $feedBack->setDate(new DateTime());

            $feedBackImage = $form->get('photo')->getData();

            if ($feedBackImage)
            {
                // Получение оригинального имени (только конечного названия)
                $originalNameImage = pathinfo($feedBackImage->getClientOriginalName(), PATHINFO_FILENAME);

                // Получение имени без подчеркиваний и пробелов ( Для корректного дальнейшего отображения в HTML)
                $safeFilename = $slugger->slug($originalNameImage);

                // Добавление уникального айди и расширения например JPG
                $newFileName = $safeFilename . '-' . uniqid() . '.' . $feedBackImage->guessExtension();

                try{
                    $feedBackImage->move($this->getParameter('feedback_images_directory'),$newFileName);
                }catch (FileException $e){

                }

                $feedBack->setPhoto($newFileName);
            }

            $feedBack = $form->getData();

            $email = (new Email())
                ->from('krasnovb88@gmail.com')
                ->to('krasnovb88@gmail.com')
                ->subject("Новый заказ")
                ->text("{$feedBack->getClientName()} с номером/ почтой {$feedBack->getCommunicationData()}
                 написал вам {$feedBack->getDescription()}");
//                ->text("{$feedBack->get('clientName')->getData()} с номером/почтой
//                {$feedBack->get('communicationData')->getData()} написал вам {$feedBack->get('description')->getData()}");


            $mailer->send($email);

            $feedBacks->save($feedBack,true);

            $this->addFlash('success','Ваш заявка была отправлена, мы свяжемся с вами в ближайшее время');

            return $this->redirectToRoute('app_main_page');

        }

        return $this->render('feedback/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }





}
