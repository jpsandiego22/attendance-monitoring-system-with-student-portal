new Vue({
  el: '#appAll',
  data: {
    img: '',
    name: '',
    type: '',
    t: '',
    scannedCode: '',
    lastScanned: '',
    qrScanner: null,
    scannedHistory: [],
    isProcessing: false,
    time: new Date(),
    theme: 'dark',
  },
  mounted() {
    this.initQrScanner();
    setInterval(() => {
            this.time = new Date();
        }, 1000);
  },
computed: {
        formattedTime() {
            let hours = this.time.getHours();
            let minutes = this.time.getMinutes();
            let seconds = this.time.getSeconds();

            const ampm = hours >= 12 ? 'PM' : 'AM';

            hours = hours % 12;
            hours = hours ? hours : 12; // 0 becomes 12

            hours = hours < 10 ? "0" + hours : hours;
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            return `${hours}:${minutes}:${seconds} ${ampm}`;
        }
    },
  methods: {
  toggleTheme() {
            this.theme = this.theme === 'dark' ? 'light' : 'dark';
        },
    initQrScanner() {

      const onScanSuccess = (decodedText) => {

        // 🔹 Prevent duplicate scan of SAME QR immediately
        if (this.isProcessing || this.lastScanned === decodedText) return;

        this.isProcessing = true;
        this.lastScanned = decodedText;
       
        if (this.qrScanner) {
          try {
            this.qrScanner.pause(true);
          } catch (e) {
            console.warn("Pause failed", e);
          }
        }

        axios.post(qrurl, { qr_code: decodedText })
          .then(response => {

            if (response.data.status === 'success') {
              console.log(response.data);
              this.img  = response.data.message.img;
              this.name = response.data.message.name;
              this.type = response.data.message.logType;
              this.t    = response.data.message.t;

              this.scannedHistory.unshift(
                `${this.name} - ${this.type} (${this.t})`
              );
              this.scannedCode = `${this.name} - ${this.type} (${this.t})`;
            } else {
              response.data
              this.img  = '';
              this.name = response.data.message;
              this.type = '';
              this.t    = '';

              this.scannedHistory.unshift(response.data.message);
            }

            this.resumeScanner();

          })
          .catch(error => {
            console.log(error);
            this.resumeScanner();
          });
      };

      this.qrScanner = new Html5QrcodeScanner(
        "qr-reader",
        { fps: 10, qrbox: 250 }
      );

      this.qrScanner.render(onScanSuccess);
    },

    resumeScanner() {
      setTimeout(() => {

        // Clear displayed info after 3 seconds
        // this.img = '';
        // this.name = '';
        // this.type = '';
        // this.t = '';

        if (this.qrScanner) {
          try {
            this.qrScanner.resume();
          } catch (e) {
            console.warn("Resume failed", e);
          }
        }

        this.isProcessing = false;
        this.lastScanned = '';

      }, 2000);
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

