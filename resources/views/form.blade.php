@extends('template')

@section('css')
    <style>

    </style>
@endsection

@section('content')
    <div class="container w-50">
        <h1>Add new Invoice</h1>
        <form method="post">
            @csrf
            <div class="mb-3">
                <label for="invoice_number" class="form-label">Invoice Number</label>
                <input type="number" id="invoice_number" class="form-control w-50" name="invoice_number">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <textarea id="address" class="form-control w-75" name="address"></textarea><br><br>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date:</label>
                <input type="date" id="invoice-date" class="form-control  w-50" id="date" name="date"><br><br>
            <div>
    
            <table class="table" id="item-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><textarea class="w-100" name="products[0][title]"></textarea></td>
                        <td><input type="number" name="products[0][price]"></td>
                        <td><input type="number" name="products[0][amount]"></td>
                        <td><button class="delete-row btn btn-danger btn-sm" onclick="deleteRow(event)">X</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-primary mb-5" onclick="addItem()">Add Item</button><br/>
            <button type="submit" class="btn btn-success">Save Invoice</button>
            <button type="button" class="btn btn-secondary" id="create-pdf" onclick="savePDF()">Generate PDF</button>
            <button type="button" class="btn btn-secondary float-end" id="email-pdf" onclick="emailPDF()">Email PDF</button>
        </form>
    </div>
@endsection

@section('javascript')
    <script>

        var product_index = 1;
        function addItem() {
            document.querySelector("tbody").insertAdjacentHTML("beforeend", `
                <tr>
                    <td><textarea class="w-100" name="products[${product_index}][title]"></textarea></td>
                    <td><input type="number" name="products[${product_index}][price]"></td>
                    <td><input type="number" name="products[${product_index}][amount]"></td>
                    <td><button class="delete-row btn btn-danger btn-sm" onclick="deleteRow(event)">X</button></td>
                </tr>
            `);
            product_index++;
        }

        function deleteRow(event) {
            const row = event.target.closest("tr");
            row.remove();
        }

        function createPDF() {
            const doc = new jsPDF();
            doc.text("Invoice Number: " + document.getElementById("invoice_number").value, 10, 10);
            doc.text("Address: " + document.getElementById("address").value, 10, 20);
            doc.text("Invoice Date: " + document.getElementById("invoice-date").value, 10, 30);

            var table = document.querySelector("table");
            var rows = table.querySelectorAll("tr");

            let data = [];

            for (let i = 1; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName('td');
                var title = cells[0].querySelector('textarea').value;
                var price = cells[1].querySelector('input').value;
                var amount = cells[2].querySelector('input').value;
                data.push([title, price, amount]);
            }

            doc.autoTable({
                head: [["Title", "Price", "Amount"]],
                body: data,
                startY: 40,
            });
            return doc;
        }

        function savePDF() {
            const doc = createPDF();
            const pdfUrl = doc.output('bloburl');
            window.open(pdfUrl, '_blank');

            // doc.save("invoice.pdf");     /* save funciotn */
        }

        function emailPDF() {
            const doc = createPDF();
            var pdfBlob = doc.output('blob');
            var pdfBlob = doc.output('blob');

            var formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('pdf', pdfBlob, 'invoice.pdf');

            jQuery.ajax({
                url: '/send-email',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    </script>
@endsection