<?php
/*
 *  Copyright 2023.  Baks.dev <admin@baks.dev>
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is furnished
 *  to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in all
 *  copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NON INFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  THE SOFTWARE.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use BaksDev\Contacts\Region\Choice\ContactsRegionFieldChoice;
use BaksDev\Field\Country\Choice\CountryFieldChoice;
use BaksDev\Field\Tire\CarType\Choice\TireCarTypeFieldChoice;
use BaksDev\Field\Tire\Euro\Choice\TireEuroFieldChoice;
use BaksDev\Field\Tire\Profile\Choice\TireProfileFieldChoice;
use BaksDev\Field\Tire\Radius\Choice\TireRadiusFieldChoice;
use BaksDev\Field\Tire\Season\Choice\TireSeasonFieldChoice;
use BaksDev\Field\Tire\Studs\Choice\TireStudsFieldChoice;
use BaksDev\Field\Tire\Width\Choice\TireWidthFieldChoice;
use BaksDev\Reference\Clothing\Choice\ReferenceChoiceSizeClothing;
use BaksDev\Reference\Color\Choice\ReferenceChoiceColor;
use BaksDev\Reference\Region\Choice\RegionFieldChoice;
use Symfony\Config\TwigConfig;

return static function(TwigConfig $twig) {

    $twig->formThemes([
        //        '@field-tire-season/form.row.html.twig',
        //        '@field-tire-studs/form.row.html.twig',
        //        '@field-tire-cartype/form.row.html.twig',
        //        '@field-tire-euro/form.row.html.twig',
        //        '@field-tire-homologation/form.row.html.twig',
        //
        //        '@contacts-region/choice/form.row.html.twig',
        //        '@input_field/form.row.html.twig',
        //        '@phone_field/form.row.html.twig',
        //        '@account_email/form.row.html.twig',
        //        '@checkbox_field/form.row.html.twig',
        //
        //        '@inn_field/form.row.html.twig',
        //        '@kpp_field/form.row.html.twig',
        //
        //        '@okpo_field/form.row.html.twig',
        //        '@orgn_field/form.row.html.twig',
        //
        //        '@invoice_field/form.row.html.twig',
        //
        //
        //        '@users-address/choice/form.row.html.twig',
    ]);
};