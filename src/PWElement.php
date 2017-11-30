<?php

namespace PWGen;

/**
 * Port of the famous GNU/Linux Password Generator ("pwgen") to PHP.
 * This file may be distributed under the terms of the GNU Public License.
 * Copyright (C) 2001, 2002 by Theodore Ts'o <tytso@alum.mit.edu>
 * Copyright (C) 2009 by Superwayne <superwayne@superwayne.org>
 */

class PWElement
{
    public $str;
    public $flags;

    public function __construct($str, $flags)
    {
        $this->str = $str;
        $this->flags = $flags;
    }
}
