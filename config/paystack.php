<?php

/*
 * This file is part of the Laravel Paystack package.
 *
 * (c) Prosper Otemuyiwa <prosperotemuyiwa@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /**
     * Public Key From Paystack Dashboard
     *
     */
    'publicKey' => getenv('sk_test_7e0b9e608479132f4c5ab44425f1cf302a8f7fa0'),

    /**
     * Secret Key From Paystack Dashboard
     *
     */
    'secretKey' => getenv('pk_test_838e4264a4b100174ec6cd0f8063be143fc68f57'),

    /**
     * Paystack Payment URL
     *
     */
    'paymentUrl' => getenv('PAYSTACK_PAYMENT_URL'),

    /**
     * Optional email address of the merchant
     *
     */
    'merchantEmail' => getenv('firstheavBus@gmail.com'),

];
