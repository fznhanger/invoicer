@extends('template')

@section('css')
    <style>

    </style>
@endsection

@section('content')
    <div class="container w-50">
        <h1>All Invoices</h1>
        <div class="container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Invoice Number</th>
                        <th>Address</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Generate PDF</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->invoice_number }}</td>
                            <td>{{ $invoice->address }}</td>
                            <td>{{ $invoice->date }}</td>
                            <td>
                                <ul>
                                    @foreach(json_decode($invoice->description) as $item)
                                    <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    @foreach(json_decode($invoice->amount) as $item)
                                    <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <button class="btn btn-primary" onclick="generatePDF({{ json_encode($invoice) }})">Generate PDF</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        function generatePDF(data) {
            const doc = createPDF(data);
            const pdfUrl = doc.output('bloburl');
            window.open(pdfUrl, '_blank');
        }

        function createPDF(data) {
            const doc = new jsPDF();
            doc.text("Invoice Number: " + data.invoice_number, 10, 10);
            doc.text("Address: " + data.address, 10, 20);
            doc.text("Invoice Date: " + data.date, 10, 30);

            var descriptions = JSON.parse(data["description"]);
            var amounts = JSON.parse(data["amount"]);

            const tableData = [];
            for (let i = 0; i < amounts.length; i++) {
                tableData.push([descriptions[i], amounts[i]]);
            }

            doc.autoTable({
                head: [["Description", "Amount"]],
                body: tableData,
                startY: 40,
            });

            return doc;
        }
    </script>
@endsection