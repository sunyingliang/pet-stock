<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

use AppBundle\Entity\Author;
use AppBundle\Service\RequestDataManager;
use AppBundle\Exception\InvalidParameterException;

class ArticleController extends Controller
{
    private $responseArr = ['status' => 'success'];

    /**
    * @Route("/api/author/create")
    */
    public function createAction(EntityManagerInterface $em, RequestDataManager $requestDataManager, Request $request)
    {
        try {
            $data = $requestDataManager->getData($request);

            if (!($validation = $requestDataManager->required($data, ['name'], true))['valid']) {
                throw new InvalidParameterException($validation['message']);
            }

            $author = new Author();

            $author->setName($data['name']);

            $em->persist($author);
            $em->flush();

            $this->responseArr['data'] = ['id' => $author->getId()];
        } catch (\Exception $e) {
            $this->responseArr['status']  = 'error';
            $this->responseArr['message'] = $e->getMessage();
        }

        return $this->json($this->responseArr);
    }
}
