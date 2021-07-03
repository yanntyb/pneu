<?php

namespace Plugin\Traits;

use PDO;
use Plugin\Classes\DB;

trait GlobalManager
{
    private ?PDO $db;

    /**
     * ArticleManager constructor.
     */
    public function __construct()
    {
        $this->db = DB::getInstance();
    }

}