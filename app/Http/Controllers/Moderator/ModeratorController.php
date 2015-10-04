<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;

class ModeratorController extends Controller
{

    public $baseview = 'moderator::layout.page';

    /**
     * Constructor
     */
    public function __construct()
    {
        // auth check
        $this->middleware('auth');

        // access check
        $this->middleware('access');
    }

}
