
new Vue({
  el: '#app_qr_scanner',
  data: {
    scannedCode: '',  // <-- reactive property
    qrScanner: null,
    scannedHistory: [],
  },
  mounted() {
    this.initQrScanner();
  },
  methods: {
    initQrScanner() {
      const onScanSuccess = (decodedText, decodedResult) => {
        this.scannedCode = decodedText;
console.log(decodedText)
        // Send QR code to Laravel backend using Axios
        axios.post(qrurl, { qr_code: decodedText })
        .then(response => {
          console.log(response.data);
          alert(response.data);
        })
        .catch(error => {
          console.error(error);
          alert('Failed to send QR code');
        });
      };

      // Initialize Html5QrcodeScanner
      this.qrScanner = new Html5QrcodeScanner(
        "qr-reader",
        { fps: 10, qrbox: 250 }
      );

      this.qrScanner.render(onScanSuccess);
    },
    stopScanner() {
      if (this.qrScanner) {
        this.qrScanner.clear().catch(err => console.error(err));
      }
    }
  },
  beforeDestroy() {
    this.stopScanner();
  }
});

