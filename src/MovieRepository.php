<?php

namespace Mattsmithdev;

use Mattsmithdev\PdoCrudRepo\DatabaseTableRepository;

class MovieRepository extends DatabaseTableRepository
{
    public function __construct()
    {
        parent::__construct(__NAMESPACE__, 'Movie', 'movie');
    }

}