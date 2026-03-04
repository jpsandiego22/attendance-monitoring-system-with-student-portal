
<div class="col-md-12 border mt-3"  v-if="users.length"  v-cloak>
    <div class="alert alert-default alert-dismissible fade show" role="alert">
        {{$slot}}
        <button @click="users=[]" type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span>&times;</span>
        </button>
        <hr>
        <!-- Table Responsive Wrapper -->
        <div class="table-responsive">
            <table id="usersDashboard" width="100%" class="table table-striped table-bordered w-100">
                <thead class="thead-dark text-center">
                    <tr>
                        <th style="width:10%;">Identification</th>
                        <th style="width:12%;">Photo</th>
                        <th style="width:20%;">Name</th>
                        <th style="width:8%;">Year</th>
                        <th style="width:8%;">Section</th>
                        <th style="width:15%;">User Type</th>
                        <th style="width:15%;">Bind</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td v-html="user.identification"></td>
                        <td>
                            <img 
                                :src="user.img ? '/'+user.img : '/img/faces/face0.jpg'"
                                class="rounded-circle border shadow-sm"
                                width="80"
                                height="80"
                                style="object-fit: cover;">
                        </td>
                        <td v-html="user.name"></td>
                        <td v-html="user.year"></td>
                        <td v-html="user.section"></td>
                        <td v-html="user.type_description"></td>
                        <td v-html="user.user_email"></td>
                    </tr>
                </tbody>
            </table>
            {{$slot}}
        </div>
    </div>
</div>