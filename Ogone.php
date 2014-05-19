<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Admin webservices 
 * 
 * @api
 */
class Controller_Ogone extends Controller {
    
    public function action_index() 
    {
        \Ogone\Ogone::instance( $this->ogoneConfig );
        $this->couch->useDatabase( $this->config[ 'FBM_DB_COSTUMERS' ] );
        
        $order = new stdClass();
        $order->owner_id    = $this->userDoc->_id;
        $order->owner       = $this->userDoc->name;
        $order->createdAt   = time();
        $order->type        = 'ogoneSubscription';
        $order->status      = 'created';
        
        $orderDoc = $this->couch->storeDoc( $order );
        
        $form = \Ogone\Ogone::order( $orderDoc->id )
                ->currency('EUR')
                ->amount(100)
                ->method('CreditCard')
                ->contact(
                            array( 
                                'name' => $this->userDoc->firstname . ' ' . $this->userDoc->lastname
                            ,   'email' =>  $this->userDoc->name 
                            )
                        )
                ->build();
        
        header( 'Content-Type: text/html; charset=utf-8');
        $this->response->body( $form );
    }
    
    public function action_accepted() 
    {
        $orderDoc = $this->storeOrderStatus( 'accepted' );
        $this->json_response( $orderDoc );
    }
    
    public function action_declined() 
    {
        $orderDoc = $this->storeOrderStatus( 'declined' );
        $this->json_response( $orderDoc );
    }
    
    public function action_exception() 
    {
        $orderDoc = $this->storeOrderStatus( 'exception' );
        $this->json_response( $orderDoc );
    }
    
    public function action_canceled() 
    {
        $orderDoc = $this->storeOrderStatus( 'canceled' );
        $this->json_response( $orderDoc );
    }
    
    private function storeOrderStatus( $status ) 
    {
        if ( !isset( $status ) ) 
        {
            throw new Exception( 'Order status is required' );
        }
        
        $this->couch->useDatabase( $this->config[ 'FBM_DB_COSTUMERS' ] );
        $orderDoc = $this->couch->getDoc( $this->request->query( 'orderid' ) ); 
        $orderDoc->status = $status;
        $this->couch->storeDoc( $orderDoc );
        
        return $orderDoc;
    }
    
}
