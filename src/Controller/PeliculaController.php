<?php

namespace App\Controller;

// CORE
use App\Entity\Pelicula;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

// FORM
use App\Form\PeliculasFilterType;

// REPOSITORY
use App\Repository\PeliculaRepository;


final class PeliculaController extends AbstractController
{
    #[Route('/peliculas', name: 'app_peliculas')]
    public function index(EntityManagerInterface $entityManager, PeliculaRepository $peliculaRepository, Request $request): Response
    {
        // Crear el formulario
        $form = $this->createForm(PeliculasFilterType::class);
        $form->handleRequest($request);

        $peliculas = [];

        if ($form->isSubmitted() && $form->isValid()) {
            // Obtener los datos del formulario
            $data = $form->getData();

            // Llamar al repositorio con los valores filtrados
            $peliculas = $peliculaRepository->findByFilters($data);
        }else{
            $peliculas = $entityManager->getRepository(Pelicula::class)->findAll();
        }

        return $this->render('pelicula/index.html.twig', [
            'form' => $form->createView(),
            'peliculas' => $peliculas,
        ]);
    }
}
