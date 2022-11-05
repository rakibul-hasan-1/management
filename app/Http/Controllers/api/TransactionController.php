<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index(){
        $data=Transaction::orderBy('id','DESC')->paginate(50);
        return TransactionResource::collection($data);
    }
}
