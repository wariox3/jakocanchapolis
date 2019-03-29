<?php

namespace App\Controller;

use App\Entity\Llamada;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class InicioController extends Controller
{
    const URL = 'http://localhost/jakoservicio/public/index.php';

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

    /**
     * @Route("/ver/{id}", name="ver")
     */
    public function verAction(Request $request, $id)
    {
        $arReservas = null;
        $fecha = new \DateTime('now');
        $fecha = $fecha->format('Y-m-d');
        $form = $this->createFormBuilder()
            ->add('fecha', DateType::class, ['widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => ['class' => 'date form-control',], 'data' => new \DateTime('now'), 'required' => true])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-secondary']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $fecha = $form->get('fecha')->getData()->format('Y-m-d');
            }
        }
        $arReservas = $this->listaReserva($fecha, $id);
        return $this->render('ver.html.twig', [
            'arReservas' => $arReservas,
            'form' => $form->createView()
        ]);
    }

    private function listaReserva ($fecha, $escenario) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_URL => self::URL . "/v1/reserva/escenario",
            CURLOPT_POSTFIELDS => json_encode([
                'escenario' => $escenario,
                'fecha' => $fecha
            ])
        ));
        $arNegocios = json_decode(curl_exec($curl), true);
        return $arNegocios;
    }

    private function listaNegocio () {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_URL => self::URL . "/v1/negocio/buscar",
            CURLOPT_POSTFIELDS => json_encode([
                'negocio' => ''
            ])
        ));
        $arNegocios = json_decode(curl_exec($curl), true);
        return $arNegocios;
    }


}