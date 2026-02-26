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
        alertClass: null,
    },
    methods: {
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