<?php

namespace Giftery\Request;

enum Command: string
{
    case GET_BALANCE = 'getBalance';
    case GET_PRODUCTS = 'getProducts';
    case MAKE_ORDER = 'makeOrder';
    case GET_STATUS = 'getStatus';
    case GET_CERTIFICATE = 'getCertificate';
    case GET_CODE = 'getCode';
    case GET_LINKS = 'getLinks';
    case GET_CATEGORIES = 'getCategories';
    case GET_ADDRESS = 'getAddress';
    case TEST = 'test';
}
