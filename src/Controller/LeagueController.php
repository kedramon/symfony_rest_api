<?php

namespace App\Controller;

use App\Entity\League;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/api")
 * Class LeagueController
 */
class LeagueController extends Controller
{
    /**
     * @Route("/league", name="league_add", methods={"POST"}, defaults={"_format": "json"})
     *
     * @param Request                $request
     * @param EntityManagerInterface $entityManager
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $content = json_decode($request->getContent());

        $league = new League();
        $league->setName($content->name);

        if (isset($content->sponsor)) {
            $league->setSponsor($content->sponsor);
        }

        $entityManager->persist($league);
        $entityManager->flush();

        return new JsonResponse($league->toArray(), JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("/leagues", name="league_list", methods={"GET"})
     *
     * @param EntityManagerInterface $entityManager
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list(EntityManagerInterface $entityManager): Response
    {
        $data = [];
        $leagues = $entityManager->getRepository(League::class)->findAll();

        foreach ($leagues as $league) {
            $data[] = $league->toArray();
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/league/{id}", name="league_delete", methods={"DELETE"}, requirements={"id" = "\d+"})
     *
     * @param int                    $id
     * @param EntityManagerInterface $entityManager
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete($id, EntityManagerInterface $entityManager): Response
    {
        $league = $entityManager->getRepository(League::class)->findOneBy(['id' => $id]);
        if (!$league) {
            throw new NotFoundHttpException(sprintf('League not found for ID %d', $id));
        }
        $entityManager->remove($league);
        $entityManager->flush();
        $response = [
            'id' => $id,
            'status' => 'deleted',
        ];

        return new JsonResponse($response);
    }

}
