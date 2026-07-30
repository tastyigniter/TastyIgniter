<?php

namespace CoreInterfaces\Core\Request;

interface RequestMethod
{
    public const GET = "Get";
    public const POST = "Post";
    public const PUT = "Put";
    public const PATCH = "Patch";
    public const DELETE = "Delete";
    public const HEAD = "Head";
}
