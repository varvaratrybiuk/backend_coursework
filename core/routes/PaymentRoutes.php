<?php
use core\Router;

$paymentRouter = new Router();


$paymentRouter->get('/payment', 'PaymentController_showPaymentPage');
$paymentRouter->post('/payment', 'PaymentController_actionPayment');

return $paymentRouter;