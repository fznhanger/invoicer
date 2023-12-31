<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class FormController extends Controller
{
    public function allInvoices() {
        return view('allForms', ['invoices' => Invoice::get(), 'products' => Product::get()]);
    }

    public function showForm(Request $request, Invoice $invoice) {
        if($request->method() === 'POST') {
            $invoice = new Invoice;
            $invoice->invoice_number = $request->invoice_number;
            $invoice->address = $request->address;
            $invoice->date = $request->date;
            $invoice->save();
            foreach ($request->products as $received_product) {
                $product = new Product;
                $product->invoice_id = $invoice->id;
                $product->title = $received_product['title'];
                $product->price = $received_product['price'];
                $product->amount = $received_product['amount'];
                $product->timestamps = false;
                $product->save();
            }

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

    public function createPdf(Invoice $invoice) {
        $products = $invoice->products()->select('title', 'price', 'amount')->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf', ['invoice' => $invoice, 'products' => $products]);
        return $pdf->stream();
    }
}
