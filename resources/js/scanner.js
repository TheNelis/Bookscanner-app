import Quagga from 'quagga';

const scannerContainer = document.getElementById('scanner-container');
const resultDiv = document.getElementById('result');
const boekButton = document.getElementById('boekButton');

function startCamera() {
    // Voorkom dat de pagina wordt gezoomed
    const viewport = document.querySelector('meta[name="viewport"]');
    viewport.setAttribute('content', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no');

    // Variabelen voor stabiele barcode detectie
    let lastValidCode = null;
    let consecutiveMatchCount = 0;
    const MATCH_THRESHOLD = 3;

    Quagga.init({
        inputStream: {
            name: "Live",
            type: "LiveStream",
            target: scannerContainer,
            constraints: {
                width: { min: 640 },
                height: { min: 480 },
                facingMode: { ideal: "environment" }, // Achtercamera bij voorkeur
                aspectRatio: { min: 1, max: 2 }
            }
        },
        locator: {
            patchSize: "large",
            halfSample: true
        },
        numOfWorkers: navigator.hardwareConcurrency || 4,
        decoder: {
            readers: ["ean_reader", "ean_8_reader", "code_128_reader"],
            multiple: false
        },
        locate: true
    }, function(err) {
        if (err) {
            console.error("Quagga initialisatie fout:", err);
            return;
        }
        Quagga.start();
    });

    Quagga.onDetected(function(result) {
        const scannedCode = result.codeResult.code;

        if (scannedCode.toString().length === 13){
        
            // Controleer of de code consistent is
            if (scannedCode === lastValidCode) {
                consecutiveMatchCount++;
                
                // Als de code genoeg keer herhaald is, toon dan de definitieve barcode
                if (consecutiveMatchCount >= MATCH_THRESHOLD) {
                    resultDiv.textContent = `ISBN: ${scannedCode}`;

                    boekButton.style.display = 'block';
                    boekButton.href = `book/${scannedCode}`;
                    
                    // Reset voor volgende scan
                    lastValidCode = null;
                    consecutiveMatchCount = 0;
                }
            } else {
                // Nieuwe code gedetecteerd, reset de teller
                lastValidCode = scannedCode;
                consecutiveMatchCount = 1;
            }
        }
    });
}


if (window.location.pathname == '/scannen') {
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ 
            video: { 
                facingMode: "environment",
                width: { ideal: 1280, max: 1920 },
                height: { ideal: 720, max: 1080 }
            } 
        })
        .then(function(stream) {
            startCamera();
        })
        .catch(function(err) {
            console.error("Cameratoegang mislukt:", err);
            resultDiv.textContent = `Camerafout: ${err.name} - ${err.message}`;
        });
    } else {
        resultDiv.textContent = "Camera wordt niet ondersteund";
        console.log("Camera wordt niet ondersteund");
    }
}
