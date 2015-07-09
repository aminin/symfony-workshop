<?php

namespace AppBundle\Controller;


use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Good;
use AppBundle\Entity\Vendor;
use AppBundle\Entity\Category;

/**
 * Good controller.
 *
 * @Route("/good")
 */
class GoodController extends Controller
{

    /**
     * Lists all Good entities.
     *
     * @Route("/", name="good")
     * @Method("GET")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        /** @var Vendor $vendor */
        $vendor = $this->getCurrentVendor($request);
        /** @var Category $category */
        $category = $this->getCurrentCategory($request);

        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:Category')->findAll();
        $vendors = $em->getRepository('AppBundle:Vendor')->findAll();

        $q = $request->query->get('q');

        if (!empty($category)) {
            /** @var \Doctrine\ORM\PersistentCollection $goods */
            $goods = $category->getGoods();
        } elseif (!empty($vendor)) {
            /** @var \Doctrine\ORM\PersistentCollection $goods */
            $goods = $vendor->getGoods();
        } else {
            $repo = $em->getRepository('AppBundle:Good');
            $goods = $repo->createQueryBuilder('g');
            if (!empty($q)) {
                /** @var \Doctrine\ORM\QueryBuilder $goods */
                $goods->where($goods->expr()->like('g.name', $goods->expr()->literal("%$q%")));
            }
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $goods,
            $request->query->get('page', 1),
            12
        );

        return array(
            'pagination' => $pagination,
            'goods' => $goods,
            'categories' => $categories,
            'vendors' => $vendors,
            'currentCategory' => $category,
            'currentVendor' => $vendor,
        );
    }

    /**
     * Finds and displays a Good entity.
     *
     * @Route("/{id}", name="good_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Good')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Good entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

    private function getCurrentVendor(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $vendor = $request->request->has('vendor') ?
            $request->request->get('vendor') :
            $request->query->get('vendor');

        return $em->getRepository('AppBundle:Vendor')->findOneById($vendor);
    }

    private function getCurrentCategory(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $request->request->has('category') ?
            $request->request->get('category') :
            $request->query->get('category');

        return $em->getRepository('AppBundle:Category')->findOneById($category);
    }
}
