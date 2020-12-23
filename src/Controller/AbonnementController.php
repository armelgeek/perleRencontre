<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Entity\MonProfil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Entity\Utilisateur;
use DateTime;
use Symfony\Component\HttpFoundation\Request;

class AbonnementController extends AbstractController
{
    /**
     * @Route("/utulisateur/abonnement", name="abonnement")
     */
    public function index(Security $security): Response
    {
        $user = $security->getUser();
        if ($user != null && $user instanceof Utilisateur) {
            $profile = $this->getDoctrine()->getRepository(MonProfil::class)->findOneBy(array('user' => $user));
            $moncoffre =  $this->getDoctrine()->getRepository(MonCoffre::class)->findOneBy(array('profil' => $profile));
            $abonnement = $this->getDoctrine()->getRepository(Abonnement::class)->findAll();
            return $this->render('abonnement/index.html.twig', [
                'abonnement' => $abonnement,
                'profile' => $profile,
                'moncoffre' => $moncoffre
            ]);
        }
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/utulisateur/abonnement/payement/{id}", name="ab_payement",requirements={"id"="\d+"})
     */
    public function payement($id,Request $request, Security $security)
    {
        $user = $security->getUser();
        if ($user != null && $user instanceof Utilisateur) {
            $error = array();
            if ($request->request->has('price') && $request->request->has('validation_number') && $request->request->has('description')) {

                $abonnement = $this->getDoctrine()->getRepository(Abonnement::class)->findOneBy(array('id' => $id));
                $profile = $this->getDoctrine()->getRepository(MonProfil::class)->findOneBy(array('user' => $user));
                $moncoffre =  $this->getDoctrine()->getRepository(MonCoffre::class)->findOneBy(array('profil' => $profile));

                $validation_number =(int) $request->request->get('validation_number') ?? 1;
                $description = $request->request->get('description');
                $price = intval($request->request->get('price'));
                $token = $request->request->get('stripeToken');

                // Payement processing
                $stripe = new  \Stripe\StripeClient($_ENV['STRIPE_TOKEN']);
                try {
                    $customer = \Stripe\Customer::create([
                        'source' =>  $token,
                        'email' => $user->getEmail(),
                    ]);
                    // save customer for next payement
                    $charge = $stripe->charges->create(
                        array(
                            'amount' => $price,
                            'currency' => 'euro',
                            'description' => $description,
                            'customer' =>  $customer->id,
                        )
                    );
                    // get charge information
                    $capture = $stripe->charges->capture(
                        $charge['id'],
                        [],
                    );
                    // Set mon coffre customer id for next payement
                    if ($validation_number > 0) {
                        $moncoffre->setCustomerId($customer->id);
                    }

                    // Update abonnement
                    $moncoffre->setAbonnement($abonnement);
                    $moncoffre->setValidationNumber($validation_number);
                    $moncoffre->setIsExpired(false);
                    $moncoffre->setExpiredAt(new DateTime('now + 30 days'));
                    $moncoffre->setTranscation(array($capture));

                    $profile->setPerle($abonnement->getPerle());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($profile);
                    $em->persist($moncoffre);
                    $em->flush();
                    return $this->redirectToRoute('/utilisateur/profil');
                } catch (\Stripe\Exception\CardException $e) {
                    $error = $this->setError($e);
                } catch (\Stripe\Exception\RateLimitException $e) {
                    $error = $this->setError($e);
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    $error = $this->setError($e);
                } catch (\Stripe\Exception\AuthenticationException $e) {
                    $error = $this->setError($e);
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    $error = $this->setError($e);
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    $error = $this->setError($e);
                }
            }

            return $this->render('abonnement/payement.html.twig', ['error'=>$error,'api_key' => $_ENV['STRIPE_TOKEN'],]);
        }
        return $this->redirectToRoute('app_login');
    }

    public function setError($e){
        $error = array();
        $error['status'] = $e->getHttpStatus();
        $error['type'] = $e->getError()->type;
        $error['code'] = $e->getError()->code;
        $error['message'] = $e->getError()->message;
        return $error;
    }

}