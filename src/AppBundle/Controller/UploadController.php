<?php
/**
 * Created by PhpStorm.
 * User: grzes
 * Date: 07.10.2018
 * Time: 18:59
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Upload;
use AppBundle\Form\UploadType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UploadController extends Controller
{
    /**
     * @Route("/", name="upload_index")
     * @param Request $request
     * @return Response
     */
    public function uploadAction(Request $request)
    {
        if ($this->isGranted("ROLE_USER"))
        {
            return $this->redirectToRoute('upload_show');
        }

        $upload = new Upload();

        $form = $this->createForm(UploadType::class, $upload);
        $form->handleRequest($request);

        if ( $form->isSubmitted()){
            if ( $form->isValid() ){
                /**
                 * @var UploadedFile $file
                 */
                $file = $upload->getFile();
                $fileName = md5(uniqid()).'.'.$file->guessExtension();

                $file->move(
                    $this->getParameter('image_directory'), $fileName
                );
                $upload->setFile($fileName);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($upload);
                $entityManager->flush();

                $this->addFlash("success", "Dodanie pliku przebiegło pomyślnie ");

                return $this->redirectToRoute("upload_index", array('upload' => $upload));
            }
            $this->addFlash("error", "Ups. Coś poszło nie tak!");
        }

        return $this->render("Upload/index.html.twig", ["form" => $form->createView()]);

    }

    /**
     * @Route("/show", name="upload_show")
     *
     * @return Response
     */
    public function showAction()
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $entityManager = $this->getDoctrine()->getManager();
        $upload = $entityManager->getRepository(Upload::class)->findAll();

        return $this->render("Upload/show.html.twig", ["upload" => $upload]);




    }

}