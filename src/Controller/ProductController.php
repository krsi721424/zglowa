<?php

namespace App\Controller;

use App\Service\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products")
 *
 * Class ProductController
 * @package App\Controller
 */
class ProductController extends AbstractController
{
    private Product $productService;

    public function __construct(Product $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @Route("/categories", name="product.categories")
     */
    public function getCategories(): JsonResponse
    {
        return $this->json($this->productService->getCategories());
    }
}
