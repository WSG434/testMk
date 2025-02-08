<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TmpController extends AbstractController
{
    #[Route('/', name: 'app_tmp')]
    public function index(): Response
    {
        $test = 1;
//        dump(1);
        $test++;
        $test++;

        return $this->render('tmp/index.html.twig', [
            'controller_name' => 'TmpController',
        ]);
    }
}
