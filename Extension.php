<?php namespace DineAByte\SumUp;

use DineAByte\SumUp\Payments\SumUp;
use System\Classes\BaseExtension;

class Extension extends BaseExtension
{
    public function registerPaymentGateways(): array
    {
        return [
            SumUp::class => [
                'code' => 'sumup',
                'name' => 'SumUp',
                'description' => 'SumUp',
            ],
        ];
    }
}
