<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Balance;
use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT b FROM AppBundle:Balance b ORDER BY b.balanceDate DESC";
        $query = $em->createQuery($dql);
        $lastBalance = $query->setMaxResults(1)->getResult()[0];

        return $this->render('default/index.html.twig', [
            'lastBalance' => $lastBalance,
            'participants' => $this->getDoctrine()->getRepository(User::class)->findParticipants(),
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/balances", name="balances")
     */
    public function balanceListAction(Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT b FROM AppBundle:Balance b";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('default/balances.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/participants", name="participants")
     */
    public function participantListAction(Request $request)
    {
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $this->getDoctrine()->getRepository(User::class)->findParticipants(true), // The query
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('default/participants.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/transactions", name="transactions")
     */
    public function transactionListAction(Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT t FROM AppBundle:TransactionHistory t ORDER BY t.transactionDate";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            20
        );


        return $this->render('default/transactions.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/terms", name="terms")
     */
    public function termsAndConditionsAction()
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT b FROM AppBundle:Balance b ORDER BY b.balanceDate DESC";
        $query = $em->createQuery($dql);
        $lastBalance = $query->setMaxResults(1)->getResult()[0];

        return $this->render('default/termsandconditions.html.twig', [
            'lastBalance' => $lastBalance,
            'participants' => $this->getDoctrine()->getRepository(User::class)->findParticipants(),
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/charts", name="charts")
     */
    public function chartsAction()
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT b FROM AppBundle:Balance b ORDER BY b.balanceDate DESC";
        $query = $em->createQuery($dql);
        $lastBalance = $query->setMaxResults(1)->getResult()[0];


        return $this->render('default/charts.html.twig', [
            'prices' => $this->getPrices(),
            'lastBalance' => $lastBalance,
            'participants' => $this->getDoctrine()->getRepository(User::class)->findParticipants(),
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    private function getPrices()
    {
        $prices = file_get_contents('https://min-api.cryptocompare.com/data/pricemultifull?fsyms=BTC,ETH,XMR,ZEC,LTC,EUR&tsyms=BTC,ETH,XMR,ZEC,LTC,EUR,USD');
        return json_decode($prices, true);
    }
}
