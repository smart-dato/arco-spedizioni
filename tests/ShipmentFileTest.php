<?php


use SmartDato\ArcoSpedizioni\Generators\TxtFileGenerator;

it('can create a shipment file', function () {
    $content = (new TxtFileGenerator())

        ->setField('client_code', '053696') // 1
        ->setField('authorization_code', '') // 2
        ->setField('recipient_name', 'xxBALAN') // 3
        ->setField('address', 'VIA S. AMBROGIO, 107') // 4
        ->setField('city', 'TREBASELEGHE') // 5
        ->setField('postal_code', '35010') // 6
        ->setField('ddt_client_reference_number', '335') // 7
//        ->setField('pre_call', '') // 8
//        ->setField('recipient_phone', '') // 9
//        ->setField('packages', '') // 10
//        ->setField('weight_kg', '') // 11
//        ->setField('volume_m3', '') // 12
//        ->setField('length_over_200', '') // 13
//        ->setField('cash_on_delivery', '') // 14
//        ->setField('collection_type', '') // 15
//        ->setField('goods_value', '') // 16
//        ->setField('disposition_2', '') // 17
//        ->setField('notes', '') // 18
//        ->setField('agreed_delivery', '') // 19
//        ->setField('delivery_date', '') // 20
//        ->setField('monday_closure', '') // 21
//        ->setField('tuesday_closure', '') // 22
//        ->setField('wednesday_closure', '') // 23
//        ->setField('thursday_closure', '') // 24
//        ->setField('friday_closure', '') // 25
//        ->setField('returnable_pallets', '') // 26
//        ->setField('email', '') // 27
//        ->setField('original_sender_name', '') // 28
//        ->setField('original_sender_address', '') // 29
//        ->setField('original_sender_city', '') // 30
//        ->setField('original_sender_postal_code', '') // 31
//        ->setField('un_number_1', '') // 32
//        ->setField('un_number_2', '') // 33
//        ->setField('un_number_3', '') // 34
//        ->setField('un_number_4', '') // 35
//        ->setField('un_number_5', '') // 36
//        ->setField('un_number_6', '') // 37
//        ->setField('un_number_7', '') // 38
//        ->setField('un_number_8', '') // 39
//        ->setField('un_number_9', '') // 40
//        ->setField('un_number_10', '') // 41
//        ->setField('un_number_11', '') // 42
//        ->setField('un_number_12', '') // 43
//        ->setField('morning_opening_time', '') // 44
//        ->setField('morning_closing_time', '') // 45
//        ->setField('afternoon_opening_time', '') // 46
//        ->setField('afternoon_closing_time', '') // 47
//        ->setField('historic_center', '') // 48
//        ->setField('additional_services', '') // 49
//        ->setField('delivery_floor', '') // 50
        ->addRecord() // add record

        ->content();

    $result = "053696                          BALAN                              VIA S. AMBROGIO, 107          35010TREBASELEGHE                  PD   B-2025-F-75320250221                       30105335       LA LOCANDA DEI CANTONIERI DI LA CANTONIERA SR                                   VIA ARETINA, 49/D                  50066   REGGELLO                      FII   000060060000000000423001200000000 0000000000000000000                      0000000000000000                                                                                                                                                                                                                                                                2025999060019430000001AR AR        /AR       2025999060019430000001AR           000006                                                       00000                                                                                                                                                                                                                                                            E";
    ray($content, $result);
    expect($content)
        ->toBeString()
        ->toHaveLength(676)
        ->toBe($result)
    ;


});
