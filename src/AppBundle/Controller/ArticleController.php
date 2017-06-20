<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

use AppBundle\Entity\Article;
use AppBundle\Service\RequestDataManager;
use AppBundle\Exception\InvalidParameterException;

class ArticleController extends Controller
{
    private $responseArr = ['status' => 'success'];

    /**
    * @Route("/api/article/create")
    */
    public function createAction(EntityManagerInterface $em, RequestDataManager $requestDataManager, Request $request)
    {
        try {
            $data = $requestDataManager->getData($request);

            if (!($validation = $requestDataManager->required($data, ['authorId', 'title', 'url', 'content', 'createdAt', 'updatedAt'], true))['valid']) {
                throw new InvalidParameterException($validation['message']);
            }

            $author = $em->getRepository('AppBundle:Author')->findOneById($data['authorId']);

            if (!$author) {
                throw new \Exception("Error: the referenced author with id {$data['authorId']} dose not exist");
            }

            $article = new Article();

            $article->setAuthor($author);
            $article->setTitle($data['title']);
            $article->setUrl($data['url']);
            $article->setContent($data['content']);
            $article->setCreatedAt($data['createdAt']);
            $article->setUpdatedAt($data['updatedAt']);

            $em->persist($article);
            $em->flush();

            /*
            $author = new Author();

            $author->setName($data['name']);

            $em->persist($author);
            $em->flush();
            */
            $this->responseArr['data'] = ['id' => $article->getId()];
        } catch (\Exception $e) {
            $this->responseArr['status']  = 'error';
            $this->responseArr['message'] = $e->getMessage();
        }

        return $this->json($this->responseArr);
    }
}
