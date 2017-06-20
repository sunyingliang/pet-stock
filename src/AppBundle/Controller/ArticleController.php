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
    private $responseArr = ['status' => 'success', 'statusCode' => 200];

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

            // Check existence of author
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

            $this->responseArr['data'] = ['id' => $article->getId()];
        } catch (\Exception $e) {
            $this->responseArr['status']  = 'error';
            $this->responseArr['statusCode'] = 500;
            $this->responseArr['message'] = $e->getMessage();
        }

        return $this->json($this->responseArr, $this->responseArr['statusCode']);
    }

    /**
    * @Route("/api/article/update")
    */
    public function updateAction(EntityManagerInterface $em, RequestDataManager $requestDataManager, Request $request)
    {
        try {
            $data = $requestDataManager->getData($request);

            if (!($validation = $requestDataManager->required($data, ['id', 'authorId', 'title', 'url', 'content', 'createdAt', 'updatedAt'], true))['valid']) {
                throw new InvalidParameterException($validation['message']);
            }

            // Check existence of article
            $article = $em->getRepository('AppBundle:Article')->findOneById($data['id']);

            if (!$article) {
                throw new \Exception("Error: the article with id {$data['id']} dose not exist");
            }
            
            // Check existence of author
            $author = $em->getRepository('AppBundle:Author')->findOneById($data['authorId']);

            if (!$author) {
                throw new \Exception("Error: the referenced author with id {$data['authorId']} dose not exist");
            }

            $article->setAuthor($author);
            $article->setTitle($data['title']);
            $article->setUrl($data['url']);
            $article->setContent($data['content']);
            $article->setCreatedAt($data['createdAt']);
            $article->setUpdatedAt($data['updatedAt']);

            $em->persist($article);
            $em->flush();
        } catch (\Exception $e) {
            $this->responseArr['status']  = 'error';
            $this->responseArr['statusCode'] = 500;
            $this->responseArr['message'] = $e->getMessage();
        }

        return $this->json($this->responseArr, $this->responseArr['statusCode']);
    }

    /**
    * @Route("/api/article/delete")
    */
    public function deleteAction(EntityManagerInterface $em, RequestDataManager $requestDataManager, Request $request)
    {
        try {
            $data = $requestDataManager->getData($request);

            if (!($validation = $requestDataManager->required($data, ['id'], true))['valid']) {
                throw new InvalidParameterException($validation['message']);
            }

            // Check existence of article
            $article = $em->getRepository('AppBundle:Article')->findOneById($data['id']);

            if (!$article) {
                throw new \Exception("Error: the article with id {$data['id']} dose not exist");
            }

            $em->remove($article);
            $em->flush();
        } catch (\Exception $e) {
            $this->responseArr['status']  = 'error';
            $this->responseArr['statusCode'] = 500;
            $this->responseArr['message'] = $e->getMessage();
        }

        return $this->json($this->responseArr, $this->responseArr['statusCode']);
    }

    /**
    * @Route("/api/article/list")
    */
    public function listAction(EntityManagerInterface $em, RequestDataManager $requestDataManager, Request $request)
    {
        try {
            $articles = $em->getRepository('AppBundle:Article')->findAll();

            $this->responseArr['data'] = [];

            foreach ($articles as $article) {
                $this->responseArr['data'][] = [
                    'id' => $article->getId(),
                    'title' => $article->getTitle(),
                    'author' => $article->getAuthor(),
                    'summary' => $article->getContent(),
                    'url' => $article->getUrl(),
                    'createdAt' => $article->getCreatedAt(),
                ];
            }

        } catch (\Exception $e) {
            $this->responseArr['status']  = 'error';
            $this->responseArr['statusCode'] = 500;
            $this->responseArr['message'] = $e->getMessage();
        }

        return $this->json($this->responseArr, $this->responseArr['statusCode']);
    }

    /**
    * @Route("/api/article/list/{id}", requirements={"id": "\d+"})
    */
    public function getOneAction(EntityManagerInterface $em, RequestDataManager $requestDataManager, Request $request, $id)
    {
        try {
            $article = $em->getRepository('AppBundle:Article')->findOneById($id);

            if (!$article) {
                throw new \Exception("Error: the article with id {$id} dose not exist");
            }

            $this->responseArr['data'] = [
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'author' => $article->getAuthor(),
                'content' => $article->getContent(),
                'url' => $article->getUrl(),
                'createdAt' => $article->getCreatedAt(),
            ];
        } catch (\Exception $e) {
            $this->responseArr['status']  = 'error';
            $this->responseArr['statusCode'] = 500;
            $this->responseArr['message'] = $e->getMessage();
        }

        return $this->json($this->responseArr, $this->responseArr['statusCode']);
    }
}
