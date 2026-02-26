<div class="modal fade mt-5" id="staticBackdrop" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="modal-title">MY PROFILE</h5>
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>IDENTIFICATION <span class="text-danger">*</span></label>
                            <input type="text" value="{{ Auth::user()->detail->identification }}" name="identification" id="identification" class="form-control" placeholder="Identification" readonly>
                        </div>
                        <div class="form-group">
                            <label>NAME <span class="text-danger">*</span></label>
                            <input type="text" value="{{ Auth::user()->detail->name }}" name="name" id="name" class="form-control" placeholder="Name" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label class="">YEAR <span class="text-danger year-section-label"></span></label>
                        <input type="text" value="{{ Auth::user()->detail->year }}" name="year" id="year" class="form-control" placeholder="Year" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label>SECTION <span class="text-danger year-section-label"></span></label>
                        <input type="text" value="{{ Auth::user()->detail->section }}" name="section" id="section" class="form-control" placeholder="Section" readonly>
                        </div>
                    </div>
                    <div class="col-md-12"><hr></div>
                    <div class="col-md-12">
                        <h5 class="modal-title">USER CREDENTIAL</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>EMAIL <span class="text-danger">*</span></label>
                            <input type="text" value="{{ Auth::user()->email }}" name="user_email" id="user_email" class="form-control" placeholder="Email" readonly>
                        </div>
                        <div class="form-group">
                            <label>USER TYPE <span class="text-danger">*</span></label>
                            <input type="text" value="{{ Auth::user()->detail->type->description }}" name="name" id="name" class="form-control" placeholder="Name" readonly>
                        </div>
                    </div>
                    <div class="col-md-6  d-flex justify-content-center">
                        {!! QrCode::size(200)->generate(Auth::user()->detail->qr->qr_code) !!}
                     </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success font-weight-bold">SAVE CHANGES</button>
            </div>
        </div>
    </div>
</div>