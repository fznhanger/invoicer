<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FormController extends Controller
{
    public function allInvoices(Invoice $invoice) {
        $invoices = Invoice::get();
        return view('allForms', ['invoices' => $invoices]);
    }

    public function showForm(Request $request, Invoice $invoice) {
        if($request->method() === 'POST') {
            $invoice = new Invoice;
            $invoice->invoice_number = $request->invoice_number;
            $invoice->address = $request->address;
            $invoice->date = $request->date;
            $invoice->description = json_encode($request->description);
            $invoice->amount = json_encode($request->amount);
            $invoice->save();

            return redirect('/');
        }
        return view('form');
    }

    public function sendEmail(Request $request) {
        $to_name = 'John Doe';
        $to_email = 'JohnDoe@example.com';
        $data = array('name' => $request->name, 'body' => 'Find the attached file.');

        if (!empty($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
            $pdfBlob = file_get_contents($_FILES['pdf']['tmp_name']);
            $pdfName = $_FILES['pdf']['name'];
        } else {
            return response()->json(['error' => 'PDF file not received']);
        }

        Mail::send('invoiceEmail', ['data'=>$data], function($message) use($to_name, $to_email, $pdfBlob, $pdfName){
            $message->from(env('MAIL_USERNAME'),env('MAIL_FROM_NAME'));
            $message->to($to_email, $to_name)->subject('Invoice Email');
            $message->attachData($pdfBlob, $pdfName);
        });
 
        return response()->json(['success'=>'Email sent successfully']);
    }
}
