<?php


namespace App\Controller;

use App\Exception\FormException;
use App\Http\ApiResponse;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\InscriptionType;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints as Assert;
class PasswordResetController extends AbstractController
{
    /**
     * @Route("/account/recovery_password", name="password_recovery", methods={"GET","POST"})
     */
    public function index(Request $request,ValidatorInterface $validator)
    {

        $form = $this->createForm(InscriptionType::class);
        if ($request->getMethod() == 'POST') {
            $constraints = new Assert\Collection([
                "username"  => [new Assert\NotBlank(),new Assert\Email()]
            ]);
               $form->handleRequest($request);
           
                if (!$form->isValid()) {
                    $errors=$validator->validate($request->request->all(),$constraints);
                   
                    $messages=[];
                    foreach ($errors as $error) {
                        $property= trim(trim($error->getPropertyPath(),']'),'[');
                        $messages[$property] = $error->getMessage();
                    }
                    return new JsonResponse($messages);
                 }else{
                    dd($form->getData());
                 }
        }else{
             return $this->render('recovery.html.twig', ['form' => $form->createView()]);
        }  
    }

  
    
    /**
     * @param Request $request
     *
     * @return mixed
     *
     * @throws HttpException
     */
    private function getJson(Request $request)
    {

        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new HttpException(400, 'Invalid json');
        }

        return $data;
    }
}