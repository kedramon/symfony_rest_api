<?php

namespace App\Controller;

use App\Entity\League;
use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/api")
 *
 * Class TeamController
 */
class TeamController extends Controller
{
    /**
     * @Route("/team", name="team_add", methods={"POST"}, defaults={"_format": "json"})
     *
     * @param Request                $request
     * @param EntityManagerInterface $entityManager
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $content = json_decode($request->getContent());

        $team = new Team();
        $team->setName($content->name);
        if (isset($content->address)) {
            $team->setAddress($content->address);
        }
        if (isset($content->plays)) {
            $team->setPlays($content->plays);
        }
        if (isset($content->strip)) {
            $team->setStrip($content->strip);
        }
        if (isset($content->league)) {
            $league = $entityManager->getRepository(League::class)->findOneBy(['id' => $content->league]);
            $team->setLeague($league);
        }

        $entityManager->persist($team);
        $entityManager->flush();

        return new JsonResponse($team->toArray(), JsonResponse::HTTP_CREATED);
    }

    /**
     * @Route("/team/{id}", name="team_update", methods={"PUT", "PATCH"}, requirements={"id" = "\d+"})
     *
     * @param int                    $id
     * @param Request                $request
     * @param EntityManagerInterface $entityManager
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $content = json_decode($request->getContent());

        if (empty($content)) {
            $response = [
                'id' => $id,
                'status' => 'no changes',
            ];
            new JsonResponse($response, JsonResponse::HTTP_NO_CONTENT);
        }

        $team = $entityManager->getRepository(Team::class)->findOneBy(['id' => $id]);
        if (!$team) {
            $error = [
                'code' => Response::HTTP_NOT_FOUND,
                'message' => sprintf('Team not found for ID %d', $id),
            ];

            return new JsonResponse($error);
        }

        if (!empty($content->name)) {
            $team->setName($content->name);
        }
        if (isset($content->address)) {
            $team->setAddress($content->address);
        }
        if (isset($content->plays)) {
            $team->setPlays($content->plays);
        }
        if (isset($content->strip)) {
            $team->setStrip($content->strip);
        }
        if (isset($content->league)) {
            $league = $entityManager->getRepository(League::class)->findOneBy(['id' => $content->league]);
            $team->setLeague($league);
        }

        $entityManager->persist($team);
        $entityManager->flush();

        return new JsonResponse($team->toArray());
    }

    /**
     * @Route("/team/{id}", name="team_delete", methods={"DELETE"}, requirements={"id" = "\d+"})
     *
     * @param int                    $id
     * @param EntityManagerInterface $entityManager
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete($id, EntityManagerInterface $entityManager): Response
    {
        $team = $entityManager->getRepository(Team::class)->findOneBy(['id' => $id]);
        if (!$team) {
            $error = [
                'code' => Response::HTTP_NOT_FOUND,
                'message' => sprintf('Team not found for ID %d', $id),
            ];

            return new JsonResponse($error);
        }
        $entityManager->remove($team);
        $entityManager->flush();
        $response = [
            'id' => $id,
            'status' => 'deleted',
        ];

        return new JsonResponse($response);
    }

    /**
     * @Route("/teams", name="team_list", methods={"GET"})
     *
     * @param EntityManagerInterface $entityManager
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list(EntityManagerInterface $entityManager): Response
    {
        $data = [];
        $teams = $entityManager->getRepository(Team::class)->findAll();

        foreach ($teams as $team) {
            $data[] = $team->toArray();
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/teams/league/{id}", name="team_in_league_list", methods={"GET"}, requirements={"id" = "\d+"})
     *
     * @param int                    $id
     * @param EntityManagerInterface $entityManager
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filter($id, EntityManagerInterface $entityManager): Response
    {
        $data = [];
        $teams = $entityManager->getRepository(Team::class)->findBy(['league' => $id]);

        foreach ($teams as $team) {
            $data[] = $team->toArray();
        }

        return new JsonResponse($data);
    }

}
