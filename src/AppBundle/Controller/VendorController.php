<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Vendor;

/**
 * Vendor controller.
 *
 * @Route("/vendor")
 */
class VendorController extends Controller
{

    /**
     * Lists all Vendor entities.
     *
     * @Route("/", name="vendor")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Vendor')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Vendor entity.
     *
     * @Route("/{id}", name="vendor_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Vendor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vendor entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }
}
