<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\DBAL\Connection;

use PDO;
use PDOException;

class LuckyController extends AbstractController
{
    #[Route('/lucky/number')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);
    }

    #[Route('/usuarios', name: 'usuarios_list')]
    public function index(Connection $connection): JsonResponse
    {
        // Ejecutar consulta SQL directa sin Repository
        $sql = "SELECT * FROM usuarios";
        $usuarios = $connection->fetchAllAssociative($sql);

        return $this->json($usuarios);
    }
}