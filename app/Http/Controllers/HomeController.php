<?php

namespace App\Http\Controllers;

use App\News;
use App\Page;
use App\Project;
use App\Report;
use App\ReportCategory;
use App\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public $lang = 'ru';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->lang = App::getLocale();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $rows['main_projects'] = Project::where('status', 1)
            ->with('in_projects')
            ->where('is_main', 1)
            ->whereNotNull('title_'.$this->lang)
            ->orderBy('sort', 'asc')
            ->get();
            
        return view('web.index', compact('rows'));
    }

    public function page($id)
    {
        $rows['page'] = Page::where('status', 1)
            ->with('categories')
            ->where('id', $id)
            ->first();
             if(is_null($rows['page']['title_'.$this->lang])) return redirect('/');
        return view('web.page', compact('rows'));
    }

    public function projects()
    {
        $rows['projects'] = Project::where('status', 1)
            ->with('in_projects')
            ->where('is_archive', 0)
            ->whereNotNull('title_'.$this->lang)
            ->orderBy('sort', 'asc')
            ->get();
        return view('web.projects', compact('rows'));
    }

    public function projects_archive(Request $request)
    {
        $query = Project::where('status', 1)
            ->with('in_projects')
            ->where('is_archive', 1)
            ->whereNotNull('title_'.$this->lang)
            ->orderBy('sort', 'asc');
        if ($request->has('query')) {
            $query->where('title_' . $this->lang, 'LIKE', '%' . $request['query'] . '%');
        }

        $rows['projects'] = $query->paginate(8);
        return view('web.projects_archive', compact('rows'));
    }

    public function in_project($id)
    {
        $rows['project'] = Project::where('status', 1)
            ->with('in_projects')
            ->where('id', $id)
            ->first();
            if(is_null($rows['project']['title_'.$this->lang])) return redirect('/');
        return view('web.in_project', compact('rows'));
    }

    public function report($id)
    {
        $rows['reports'] = ReportCategory::where('id', $id)->with('reports')->first();
        return view('web.report', compact('rows'));
    }

    public function news()
    {
        $rows['news'] = News::where('status', 1)
            ->whereNotNull('title_'.$this->lang)->where('is_archive', 0)->orderBy('id', 'desc')->paginate(9);
        return view('web.news', compact('rows'));
    }

    public function in_news($id)
    {
        $rows['news'] = News::findOrFail($id);
        $rows['latest_news'] = News::where('id', '!=', $id)->where('status', 1)
            ->whereNotNull('title_'.$this->lang)->orderBy('id', 'desc')->take(3)->get();
        return view('web.in_news', compact('rows'));
    }

    public function news_archive(Request $request)
    {
        $query = News::where('status', 1)
        
            ->whereNotNull('title_'.$this->lang)
            ->where('is_archive', 1);
        if ($request->has('query')) {
            $query->where('title_' . $this->lang, 'LIKE', '%' . $request['query'] . '%');
        }

        $rows['news_archive'] = $query->paginate(9);
        return view('web.news_archive', compact('rows'));
    }

    public function helped()
    {
        return view('web.helped');
    }

    public function search(Request $request)
    {
        $rows['result']['success'] = true;
        $rows['result']['data'] = [];
        if ($request->has("query")) {
            $query = $request['query'];
            $rows['result']['data'] = News::where("status", 1)->where("title_" . $this->lang, 'LIKE', '%' . $query . '%')->get();
            if (!count($rows['result']['data'])) {
                $rows['result']['success'] = false;
            }
        }
        return view('web.search', compact('rows'));
    }

    public function help_post(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
        ]);

        $q = $request->except('_token');
        Volunteer::create($q);
        $request->session()->flash('status', 'Успешно отправлено');
        return redirect()->back();
    }

    public function pay(Request $request)
    {
        $roles = [
            'sum' => 'required|min:1000|integer',
        ];
        $validator = Validator::make($request->all(), $roles);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            $result['message'] = $error[0];
            return response()->json($result);
        }
        $client = new \ProcessingKz\Client();
        $total = $request['sum'] * 100;
        $details = new \ProcessingKz\Objects\Entity\TransactionDetails();
        $details->setMerchantId("000000000000071")
            ->setTerminalId("TEST TID")
            ->setTotalAmount($total)
            ->setCurrencyCode(398)
            ->setDescription("Пожертвование на WAQYP")
            ->setReturnURL("http://waqyp.adekta.kz/transaction-result")
            ->setGoodsList([])
            ->setLanguageCode("ru")
            ->setMerchantLocalDateTime(date("d.m.Y H:i:s"))
            ->setOrderId(rand(1, 10000))
            ->setPurchaserName("Kalibayev Nursultan")
            ->setPurchaserEmail("goo.nursultan@gmail.com");

        $transaction = new \ProcessingKz\Objects\Request\StartTransaction();
        $transaction->setTransaction($details);

        $startResult = $client->startTransaction($transaction);

        if (true === $startResult->getReturn()->getSuccess()) {
            $reference = $startResult->getReturn()->getCustomerReference();
            return redirect($startResult->getReturn()->getRedirectURL());

//            // Commit payment transaction.
//            $complete = new \ProcessingKz\Objects\Request\CompleteTransaction();
//            $complete->setMerchantId("000000000000001")
//                ->setReferenceNr($reference)
//                ->setTransactionSuccess(true);
//            $completeResult = $client->completeTransaction($complete);
//            // Get status of transaction.
//            $status = new \ProcessingKz\Objects\Request\GetTransactionStatus();
//            $status->setMerchantId("000000000000001")
//                ->setReferenceNr($reference);
//            $statusResult = $client->getTransactionStatus($status);
        } else {
            die($startResult->getReturn()->getErrorDescription());
        }
    }

    public function pay_result()
    {
        dd('success');
    }
}
