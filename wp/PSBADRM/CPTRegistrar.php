<?php

namespace Inggo\WordPress\PSBADRM;

use Inggo\WordPress\PSBADRM\CPT\Fellows;

class CPTRegistrar
{
    protected $cpts;

    public function __construct()
    {
        $this->cpts[] = new Fellows();
    }
}
