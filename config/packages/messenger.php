<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Config\FrameworkConfig;

return static function(FrameworkConfig $framework) {

    /** Транспорты партнеров */

    //    $messenger = $framework->messenger();

    //    $profile = '4ee06b1b-87a2-7490-91be-9abb3b71c0ea'; // Идентификатор профиля пользователя
    //
    //    $messenger
    //        ->transport($profile)
    //        ->dsn('redis://%env(REDIS_PASSWORD)%@%env(REDIS_HOST)%:%env(REDIS_PORT)%?auto_setup=true')
    //        ->options(['stream' => $profile])
    //        ->retryStrategy()
    //        ->maxRetries(5)
    //        ->delay(1000)
    //        ->maxDelay(0)
    //        ->multiplier(2)
    //        ->service(null);


    // Перечисляем все идентификаторы бизнес-профилей

    $profiles = [
        '13fa3aea-fe51-7888-aac1-701303573bcd',
    ];

    $messenger = $framework->messenger();

    foreach($profiles as $profile)
    {
        $table_name = 'messenger_'.str_replace('-', '_', $profile);

        $messenger
            ->transport($profile)
            ->dsn('%env(MESSENGER_TRANSPORT_DSN)%')
            ->options(['table_name' => $table_name, 'queue_name' => 'high'])
            ->failureTransport($profile.'-failed')
            ->retryStrategy()
            ->maxRetries(3)
            ->delay(1000)
            ->maxDelay(1)
            ->multiplier(3)
            ->service(null);

        $messenger
            ->transport($profile.'-low')
            ->dsn('%env(MESSENGER_TRANSPORT_DSN)%')
            ->options(['table_name' => $table_name, 'queue_name' => 'low'])
            ->failureTransport($profile.'-failed')
            ->retryStrategy()
            ->maxRetries(3)
            ->delay(1000)
            ->maxDelay(1)
            ->multiplier(3)
            ->service(null);

        $messenger
            ->transport($profile.'-failed')
            ->dsn('%env(MESSENGER_TRANSPORT_DSN)%')
            ->options(['table_name' => $table_name, 'queue_name' => 'failed']);

    }

};

