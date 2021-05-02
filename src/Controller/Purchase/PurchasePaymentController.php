<?php

namespace App\Controller\Purchase;

use App\Repository\PurchaseRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


 class PurchasePaymentController extends AbstractController
 {
     /**
      * @Route("/purchase/pay/{id}", name="purchase_payment_form")
      */
      public function showCardForm($id, PurchaseRepository $purchaseRepository)
      {
        $purchase = $purchaseRepository->find($id);
        
        if(!$purchase){
            return $this->redirectToRoute('cart_show');
        }

        \Stripe\Stripe::setApiKey('sk_test_51Imb55Lex9wWUtdVxVviISzFvn8ufBRGUZvYby2mO2wMCrXV90fJHwCGLqjzUb92bLC8TICuS14t7Sv6HTjzQ6eF00YJdhOQy8');

        $intent = \Stripe\PaymentIntent::create([
            'amount' => $purchase->getTotal(),
            'currency' => 'eur'
        ]);
          return $this->render('purchase/payment.html.twig', [
              'clientSecret' => $intent->client_secret,
              'purchase' => $purchase
          ]);
      }
 }