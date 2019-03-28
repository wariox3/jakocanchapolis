<?php

namespace App\Controller;

use App\Entity\Llamada;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class InicioController extends Controller
{


    /**
     * @Route("/", name="inicio")
     */

    public function inicioAction(Request $request)
    {
        $arNegocios = $this->listaNegocio();
        $form = $this->createFormBuilder()
            ->add('txtBuscar', TextType::class)
            ->add('btnBuscar', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnBuscar')->isClicked()) {

            }
        }
        return $this->render('inicio.html.twig', [
            'arNegocios' => $arNegocios,
            'form' => $form->createView()
        ]);
    }

    private function listaNegocio () {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_URL => 'http://localhost/jakoservicio/public/index.php/v1/negocio/buscar',
            CURLOPT_POSTFIELDS => json_encode([
                'negocio' => ''
            ])
        ));
        $arNegocios = json_decode(curl_exec($curl), true);
        return $arNegocios;
    }
}