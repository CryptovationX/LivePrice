<?php

namespace App\Http\Controllers\Line;

use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
use Line;
use App\Ticker;
use Illuminate\Http\Request;

class LINEController extends Controller
{
    public function test()
    {
        $this->usermanage('Ua2b3dd43fdfaf129015087ee98896a5a', 'user', '0');
    }
    public function receive(Request $request)
    {
        $json = $request->getContent();
        $info = json_decode($json, true);
        
        // Line::pushText('Ua2b3dd43fdfaf129015087ee98896a5a', 'hi');
    }
}
