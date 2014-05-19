kohana Ogone lib
================

PHP library.

Library which allow you to work with Ogone payment system using Kohana swift framework.

Instalation: 

Add Ogene.php to libraries dir of kohana project.

Add ogoneConfig.php to configuration dir of your kohana project

\Ogone\Ogone::instance( $this->ogoneConfig );

\Ogone\Ogone::order( $orderDoc->id )
                ->currency('EUR')
                ->amount($amount)
                ->method('CreditCard')
                ->contact(
                            array( 
                                'name' => $this->userDoc->firstname . ' ' . $this->userDoc->lastname
                            ,   'email' =>  $this->userDoc->name 
                            )
                        )
                ->build();
                
Enjoy. 
