<?php

namespace App\Controller;

use App\Domain\Service\Announcement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/announcements")
 *
 * Class AnnouncementController
 * @package App\Controller
 */
class AnnouncementController extends AbstractController
{
    public const CATEGORIES = 'announcement.categories';
    public const RECENTLY_ADDED = 'announcement.recently-added';

    /**
     * @Route("/categories", name="announcement.categories")
     *
     * @param Announcement $announcementService
     *
     * @return JsonResponse
     */
    public function getCategories(Announcement $announcementService): JsonResponse
    {
        return $this->json($announcementService->getCategories());
    }

    /**
     * @Route("/add", name="announcement.add", methods={"POST"})
     *
     * @param Announcement $announcementService
     *
     * @return Response
     */
    public function addAnnouncement(Announcement $announcementService): Response
    {
        $announcementService->addAnnouncement();

        return new Response(null, 204);
    }

    /**
     * @Route("/recently-added", name="announcement.recently-added")
     *
     * @param Announcement $announcementService
     *
     * @return JsonResponse
     */
    public function getRecentlyAdded(Announcement $announcementService): JsonResponse
    {
        return $this->json($announcementService->getRecentlyAdded());
    }
}
