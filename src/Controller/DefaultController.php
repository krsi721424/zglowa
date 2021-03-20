<?php
declare(strict_types=1);

namespace App\Controller;

use App\Domain\Service\Announcement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     *
     * @return Response
     */
    public function index(Announcement $announcementService): Response
    {
        return $this->render(
            'base.html.twig',
            [
                'categories' => $announcementService->getCategories(),
                'recentlyAddedAnnouncements' => $announcementService->getRecentlyAdded(),
                'user' => $this->getUser(),
            ]
        );
    }
}
