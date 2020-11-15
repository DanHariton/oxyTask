<?php

namespace App\Controller\Rest;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserRestController extends AbstractController
{
    /**
     * @Route("/rest/user", name="user_rest_create", methods={"PUT"}, defaults={"_format": "json"}, options={"expose"=true})
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function createAction(Request $request, ValidatorInterface $validator, EntityManagerInterface $em)
    {
        $data = json_decode($request->getContent());

        $user = new User();
        $user->setName($data->name);
        $user->setEmail($data->email);
        $user->setPassword($data->password);
        $user->setRole($data->role);

        $errors = $validator->validate($user);

        if (count($errors) > 0) {

            $errorMessages = [];

            foreach ($errors as $error) {
                /** @var ConstraintViolationInterface $error */
                $errorMessages[] = $error->getPropertyPath() . ': ' . $error->getMessage();
            }

            return new JsonResponse(['errors' => $errorMessages], Response::HTTP_NOT_ACCEPTABLE);
        }

        $user->setPassword(password_hash($data->password, PASSWORD_DEFAULT));

        $em->persist($user);
        $em->flush();

        return new JsonResponse([
            'status' => 'OK',
            'id' => $user->getId()
        ]);
    }

    /**
     * @Route("/rest/user/{user}", name="user_rest_get", methods={"GET"}, defaults={"_format": "json"})
     * @param User $user
     * @return JsonResponse
     */
    public function getAction(User $user)
    {
        return new JsonResponse($user->toArray());
    }

    /**
     * @Route("/rest/user", name="user_rest_list", methods={"GET"}, defaults={"_format": "json"})
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function listAction(UserRepository $userRepository)
    {
        return new JsonResponse(array_map(function (User $user) {
            return $user->toArray();
        }, $userRepository->findAll()));
    }
}