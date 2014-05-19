kohana_ogone_lib
================

Kohana library to work with ogone payment.

Add this library to lib directory.

\Ogone\Ogone::instance( $this->ogoneConfig );

\Ogone\Ogone::order( $orderDoc->id )
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
                
Enjoy. 
