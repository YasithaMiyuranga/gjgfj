@extends('layouts.events')
@section('page-title', __('Ticket Mark'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.ticket.mark') }}">{{ __('Mark') }}</a>
    </li>
@endsection
@section('content')

    <style>
        #qr-reader {
            width: 100%;
            max-width: 400px;
            margin: auto;
        }
    </style>
    <h2>Scan QR or Barcode</h2>

    <!-- Camera Output -->
    <div id="qr-reader"></div>

    <!-- Input + Button -->
    <input type="text" id="qrdata" class="form-control mt-3" placeholder="Scanned Code" readonly>
    <button onclick="mark()" class="btn btn-primary col-12 mt-2 mb-2">Mark Ticket</button>

    <!-- Message Box -->

    <div id="messageBox" class="alert d-none alert-dismissible fade show mt-3" role="alert">
        <span id="messageContent"></span>
        <button type="button" class="btn-close" aria-label="Close"
            style="filter: invert(1) grayscale(1) brightness(0) contrast(100%);" onclick="hideMessageBox()">
        </button>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            document.getElementById('qrdata').value = decodedText;
            // showMessage('success', 'Scanned: ' + decodedText);

            // Optionally stop the scanner after a successful scan
            // scanner.clear();
        }

        function onScanFailure(error) {
            // Optional: handle scan errors
            console.warn(`Scan failed: ${error}`);
        }

        const scanner = new Html5QrcodeScanner("qr-reader", {
            fps: 10,
            qrbox: {
                width: 350,
                height: 150
            },
            aspectRatio: 1.75,
            supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA],
            formatsToSupport: [
                Html5QrcodeSupportedFormats.QR_CODE,
                Html5QrcodeSupportedFormats.CODE_128,
                Html5QrcodeSupportedFormats.CODE_39,
                Html5QrcodeSupportedFormats.EAN_13,
                Html5QrcodeSupportedFormats.EAN_8,
                Html5QrcodeSupportedFormats.UPC_A,
                Html5QrcodeSupportedFormats.UPC_E
            ]
        }, false);

        scanner.render(onScanSuccess, onScanFailure);



        function showMessage(type, message) {
            const box = document.getElementById('messageBox');
            const content = document.getElementById('messageContent');

            // Set the alert type and message
            box.className = 'alert alert-' + type + ' alert-dismissible fade show';
            content.textContent = message;

            // Show the alert
            box.classList.remove('d-none');
        }

        function hideMessageBox() {
            const box = document.getElementById('messageBox');
            box.classList.add('d-none');
        }

        function mark() {
            const id = document.getElementById('qrdata').value;
            // const id = value;
            if (id) {
                fetch('/useradmin/ticket/mark-ticket', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            id: id
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showMessage('success', data.success);
                        } else {
                            showMessage('danger', data.error || 'Something went wrong.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showMessage('danger', 'Unexpected error occurred.');
                    });
            }
        }
    </script>

@endsection
