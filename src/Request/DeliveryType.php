<?php

namespace Giftery\Request;

enum DeliveryType: string
{
    case EMAIL = 'email';
    case  SMS = 'sms';
    case DOWNLOAD = 'download';
    case CODE = 'code';
    case LINK = 'link';
}
