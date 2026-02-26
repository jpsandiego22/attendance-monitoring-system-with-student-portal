<div class="modal fade mt-5" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div id="app_pass" class="modal-content">
            <form @submit.prevent="chngePassword">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="modal-title">CHANGE PASSWORD</h5>
                            <hr>
                        </div>
                        
                        <div class="col-md-12">
                             <div v-if="message.length" v-html="message" :class="['alert', 'alert-' + alertClass, 'alert-dismissible', 'fade', 'show']"role="alert">
                                <button type="button"  @click="message = ''" class="close" data-dismiss="alert" aria-label="Close">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="form-group">
                                <label>OLD PASSWORD <span class="text-danger">*</span></label>
                                <input type="password" v-model="vold" name="old" id="old" class="form-control" placeholder="OLD PASSWORD">
                            </div>
                            <hr>
                            <div class="form-group">
                                <label>NEW PASSWORD <span class="text-danger">*</span></label>
                                <input type="password" v-model="vnew" name="new" id="new" class="form-control" placeholder="NEW PASSWORD">
                            </div>
                            <div class="form-group">
                                <label>CONFIRM PASSWORD <span class="text-danger">*</span></label>
                                <input type="password" v-model="vconfirm" name="confirm" id="confirm" class="form-control" placeholder="CONFIRM PASSWORD">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">CHANGE PASSWORD</button>
                </div>
            </form>
        </div>
    </div>
</div>