new Vue({
    el: '#app_img',
    data: {
        img: null,
    },
    methods: {
            handleFile(event) {
            this.img = event.target.files[0];
            this.img_upload(); // auto upload after select
        },

        img_upload() {
            let formData = new FormData();
            formData.append('img', this.img);

            axios.post(imgUrl, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                console.log(response.data);
                if (response.data.status === 'success') {
                    location.reload();
                }
            })
            .catch(error => {
                console.error(error);
            });
        },
    }
});
new Vue({
    el: '#app_pass',
    data: {
        vold: null,
        vnew: null,
        vconfirm: null,
        message: '',
        alertClass: '',
    },
    methods: {
        clearForm() {
            this.message = '';
            this.vold = '';
            this.vnew = '';
            this.vconfirm = '';
            this.alertClass = '';
        },
        chngePassword() {
           console.log(chngePass)
            axios.post(chngePass,{ old: this.vold,
                new: this.vnew,
                confirm: this.vconfirm
            })
            .then(response => {
                console.log(response.data);
                this.alertClass = response.data.class 
                this.message = response.data.message 
            })
            .catch(error => {
                console.error(error);
            });
        },
    }
});
new Vue({
  el: '#app_qr_scanner',
    data: {
        vold: null,
        vnew: null,
        vconfirm: null,
        message: '',
        alertClass: '',
    },
    mounted() {
    this.initQrScanner();
  },
  methods: {
    initQrScanner() {
      const onScanSuccess = (decodedText, decodedResult) => {
        this.scannedCode = decodedText;

        // Send QR code to Laravel backend using Axios
        axios.post('/qr-scan', { qr_code: decodedText }, {
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        })
        .then(response => {
          console.log(response.data);
          alert(response.data.message);
        })
        .catch(error => {
          console.error(error);
          alert('Failed to send QR code');
        });
      };

      // Initialize Html5QrcodeScanner
      this.qrScanner = new Html5QrcodeScanner(
        this.$refs.qrReader, 
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