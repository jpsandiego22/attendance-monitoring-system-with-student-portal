<?php

namespace App\Http\Controllers;

use App\Models\UserDetail;
use App\Models\UserQR;
use App\Models\UserType;
use App\Support\HelperRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    protected $helper;

    public function __construct(HelperRepository $helper)
    {
        $this->middleware('auth');
        $this->helper = $helper;
    }

    public function register()
    {
        $page = $this->helper->page(
            'Create User Account',
            'Use this form to register a new user in the system.'
        );

        // $page['user_types'] = UserType::all(['type','description']);

        return view('admin.users.register', $page);
        
    }
    public function user_create(Request $request)
    {
        $request->merge([
            'contact' => str_replace('-', '', $request->contact),
        ]);


        $validator = Validator::make($request->all(), [
            'identification' => 'required|string|max:100|unique:user_details,identification',
            'name' => 'required|string|max:100',
            'contact' => 'required|string|size:13',
            'year' => 'required_if:user_type,2|nullable|string|max:10',
            'section' => 'required_if:user_type,2|nullable|string|max:100',
            'user_type' => 'required|integer|between:0,2',
        ]);
        

        if ($validator->fails()) 
        {
            $errors = $validator->errors()->all(); // array of error messages
            $responses = $this->helper->handler('error', 'danger', implode('<br>', $errors));

            return back()->with($responses);
        }

        $userType = $request->input('user_type');

        try {

            $user = UserDetail::create([
                'identification' => $request->input('identification'),
                'name'           => $request->input('name'),
                'contact'           => $request->input('contact'),
                'year'           => $userType === '0' ? null : $request->input('year'),
                'section'        => $userType === '0' ? null : $request->input('section'),
                'user_type'      => $userType,
            ]);

            $qrcode = $this->helper->GenerateQrCode($user);
            UserQR::create($qrcode);

            $responses = $this->helper->handler('success','success','New Record has been successfully saved.');

            return back()->with($responses);

        } catch (\Exception $e) {
            
            $responses = $this->helper->handler('error', 'error', 'Failed to create user: ' . $e->getMessage());
            return response()->json($responses,500);
        }

        
    }
    public function list()
    {
        $page = $this->helper->page(
            'List of Users Account',
            'View and manage all user accounts registered in the system.');

        $userType = Auth::user()->user_type;
        $userSection = Auth::user()->detail->section;
        $userYear= Auth::user()->detail->year;

        $data = $userType === 0 
        ? UserDetail::with('type')->with('user')->get() 
        : UserDetail::with('type')->whereNotIn('user_type', [0, 1])->where('section',$userSection)->where('year',$userYear)->with('user')->get();



        $page['users']= $data;
        

        return view('admin.users.list', $page);
        
    }
    public function user_update(Request $request,$id)
    {
        try {
            $record = UserDetail::findOrFail($id);
            // Toggle lock
            $record->lock = $record->lock == 0 ? 1 : 0;
            $record->save();

            $responses = $this->helper->handler('success',$record->lock == 0 ? 'success'  : 'warning', $record->lock == 0 ? 'User Details Unlocked.' : 'User Details Locked.');

            return back()->with($responses);
        } catch (\Exception $e) {
            
            $responses = $this->helper->handler('error', 'error', 'Failed to update user: ' . $e->getMessage());
            return response()->json($responses,500);
        }
    }
    public function csv_import(Request $request)
    {
        $page = $this->helper->page(
            'USERS - Import CSV File',
            'Use this form to add multiple data using template. <small class="text-danger"><i>[ Note : Only Faculty and Student Account can make in this Import ]</i></small>'
        );

        // $page['user_types'] = UserType::all(['type','description']);

        return view('admin.users.import-csv', $page);
        
    }
    public function csvImportNow(Request $request)
    {
        // Validate uploaded file
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');

        // Read file content
        $contents = file_get_contents($file->getRealPath());

        // Split into lines and remove empty lines
        $lines = array_filter(array_map('trim', explode("\n", $contents)));

        if (count($lines) < 2) {
            return response()->json(['message' => 'CSV file is empty or missing rows.'], 422);
        }

        $allowedHeaders = ['identification','name','contact','year','section','user_type'];
       
        // Map CSV rows
        $rows = [];
        foreach (array_slice($lines, 1) as $line) {
            $data = str_getcsv($line);

            // Combine headers with values
            $row = $data;
            $row = array_combine($allowedHeaders, $data);

            // Optional: skip empty rows
            if (empty(array_filter($row))) continue;

            $rows[] = $row;
        }

        // At this point, $rows contains all CSV rows as associative arrays
        // Example: save them to database
        $data = [];
        $list_exist = [];
        $list_invalid_type = [];

        // Get all identification values from CSV
        $incomingIds = array_column($rows, 'identification');

        // Get existing IDs in ONE query
        $existingIds = UserDetail::whereIn('identification', $incomingIds)
            ->pluck('identification')
            ->toArray();

        foreach ($rows as $row) {

             if (!in_array($row['user_type'], [1, 2])) {
                $list_invalid_type[] = [
                    'identification' => $row['identification'],
                    'name'           => $row['name'],
                    'user_type'      => $row['user_type'],
                ];
                continue; // skip this row
            }
            else
            {
                if (!in_array($row['identification'], $existingIds)) {

                $data[] = [
                    'identification' => $row['identification'],
                    'name'           => $row['name'],
                    'contact'           => $row['contact'],
                    'year'           => $row['year'],
                    'section'        => $row['section'],
                    'user_type'      => $row['user_type'],
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];

                } else {

                    $list_exist[] = [
                        'identification' => $row['identification'],
                        'name'           => $row['name'],
                    ];
                }
            }

            
        }

        try {

            if (!empty($data)) {
                foreach ($data as $row) {
                    $user = UserDetail::create($row);
                    $qrcode = $this->helper->GenerateQrCode($user);
                    UserQR::create($qrcode);
                }
                // $user = UserDetail::insert($data);
                // $qrcode = $this->helper->GenerateQrCode($user);
                // UserQR::create($qrcode);
            }

            $invalidUsers = array_map(function ($user) {
                return  '<u>'.
                    $user['identification'] . ' - ' . $user['name'] . ' (Type: '.$user['user_type'].')'
                    . '</u>';
            }, $list_invalid_type);

            $existingUsers = array_map(function ($user) {
                 return '<u>'
                    . $user['identification'] . ' - ' . $user['name']
                    . '</u>';
            }, $list_exist);

            $merge_message = '<b>Insert Count: </b>'.count($data) .
            '<br> <b>Existing Record:</b> '. count($list_exist) .
            '<br><b> Invalid User Type:</b> '. count($invalidUsers) .
            (!empty($invalidUsers)
                ? '<br><br><b> Invalid Type List:</b><br>' . implode('<br>', $invalidUsers)
                : ''
            ) .

            (!empty($existingUsers)
                ? '<br><br> <b>List of Existing Identification:</b><br>' . implode('<br class="border-bottom">', $existingUsers)
                : ''
            );
            return response()->json($merge_message);


 } catch (\Exception $e) {
            
            $responses = $this->helper->handler('error', 'error', 'Failed to update user: ' . $e->getMessage());
            return response()->json($responses);
        }

    }
    
}
