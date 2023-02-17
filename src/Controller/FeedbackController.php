<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Form\FeedbackType;
use App\Repository\FeedbackRepository;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
    #[IsGranted('ROLE_ADMIN')]
    public function allFeedbacks(FeedbackRepository $feedBacks): Response
    {
        return $this->render('feedback/all-feedbacks.html.twig',[
            'feedbacks' => $feedBacks->orderByDate()
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

                $s3 = new S3Client([
                    'version'  => 'latest',
                    'region'   => 'us-east-1',
                ]);

                // Получает значение корзины куда будет выгружен файл
                $bucket = getenv('S3_BUCKET_NAME')?: die('No "S3_BUCKET" config var in found in env!');
                
                // Переменную filepath я получил введя команду dd($_FILES)
                $filePath = $_FILES['feedback']['tmp_name']['photo'];

                try{
                    $upload = $s3->putObject([
                        'Bucket' => $bucket,
                        'Key'    => $newFileName,
                        'SourceFile'   => $filePath,
                        'ACL'    => 'public-read'
                    ]);


                }catch (S3Exception $e){
                    echo $e->getMessage();
                }

//                try{
//                    $feedBackImage->move($this->getParameter('feedback_images_directory'),$newFileName);
//                }catch (FileException $e){
//
//                }

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
