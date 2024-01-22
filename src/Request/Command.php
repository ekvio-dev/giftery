<?php

namespace Giftery\Request;

enum Command: string
{
    case GET_PRODUCTS = 'getProducts';
    case GET_BALANCE = 'getBalance';
    case MAKE_ORDER = 'makeOrder';
    case GET_STATUS = 'getStatus';
    case TEST = 'test';
}
