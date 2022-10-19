<div id="app">

<div class="modal fade" tabindex="-1" role="dialog" id="add_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{errors}}
        <form id="add_form">
            <div class="form-group">
                <label>Name</label>
                <input class="form-control" :class="{'is-invalid':errors.name}" name="name"></input>
                <div class="invalid-feedback">{{errors.name}}</div>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input class="form-control" :class="{'is-invalid':errors.email}" name="email"></input>
                <div class="invalid-feedback">{{errors.email}}</div>
            </div>
            <div class="form-group">
                <label>Race</label>
                <select name="race" class="form-control" :class="{'is-invalid':errors.race}">
                    <option value="">- Select Race -</option>
                    <option :value="r.code" v-for="r in race">{{r.race}}</option>
                </select>
                <div class="invalid-feedback">{{errors.race}}</div>
            </div>
            <div class="form-group">
                <label>Religion</label>
                <select name="religion" class="form-control" :class="{'is-invalid':errors.religion}">
                    <option value="">- Select Religion -</option>
                    <option :value="r.code" v-for="r in religion">{{r.religion}}</option>
                </select>
                <div class="invalid-feedback">{{errors.religion}}</div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button @click="insert_data()" type="button" class="btn btn-primary">Update changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="edit_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{errors}}
        {{selected}}
        <form id="edit_form">
            <div class="form-group">
                <label>Name</label>
                <input class="form-control" :class="{'is-invalid':errors.name}" name="name" :value="selected.name"></input>
                <div class="invalid-feedback">{{errors.name}}</div>
                <label>Email</label>
                <input class="form-control" :class="{'is-invalid':errors.email}" name="email" :value="selected.email"></input>
                <div class="invalid-feedback">{{errors.email}}</div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button @click="update_data()" type="button" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Example Data</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input v-model="search" type="text" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button @click="get_data()" type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <div class="input-group-append">
                                <button @click="show_add()" class="btn btn-sm btn-primary">Add</button>
                            </div>
                            
                        </div>
                        

                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search Name">
                                <div class="input-group-append">
                                    <button @click="get_data()" type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search Email">
                                <div class="input-group-append">
                                    <button @click="get_data()" type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select @change="get_data(page)" name="" id="" class="form-control" v-model="sel_race">
                                <option value="">- Select Race -</option>
                                <option v-for="r in race" :value="r.code">{{r.race}}</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select @change="get_data(page)" name="" id="" class="form-control" v-model="sel_religion">
                                <option value="">- Select Religion -</option>
                                <option v-for="r in religion" :value="r.code">{{r.religion}}</option>
                            </select>
                        </div>   
                    </div>
                    {{sel_race}} {{sel_religion}}
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Emel</th>
                            <th>Race</th>
                            <th>Religion</th>
                            <th width="100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(c, index) in contents">
                            <td>{{((page-1)*per_page)+index+1}}</td>
                            <td>{{c.name}}</td>
                            <td>{{c.email}}</td>
                            <td>{{c.race}}</td>
                            <td>{{c.religion}}</td>
                            <td class="text-right">
                                <div class="btn-group btn-group-sm">
                                    <a href="#" class="btn btn-primary"><i class="fas fa-eye"></i></a>
                                    <a @click="show_edit(c)" href="#" class="btn btn-info"><i class="fas fa-pencil-alt"></i></a>
                                    <a @click="delete_data(c)" href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    </table>
                </div>
                <div class="card-body">
                <nav aria-label="...">
                    <ul class="pagination pagination-md">
                        <li class="page-item" :class="{ active: index == page }" v-for="index in total_page">
                        <a @click="get_data(index)" class="page-link" href="#" tabindex="-1">{{index}}</a>
                        </li>
                    </ul>
                </nav>
                    Total Data {{total_data}}  {{total_page}}
                </div>
            <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="module">
  import { createApp } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'

  createApp({
    data() {
      return {
        message: 'Hello Eimiza',
        datenow: '',

        //dropdown data
        race: [],
        religion: [],

        sel_race: '',
        sel_religion: '',

        //employee data
        contents: [],
        search: '',
        page: 1,
        per_page: 10,
        total_data: 0,
        total_page: 0,
        errors: [],
        selected: [],
        selected_id: '',
      }
    },
    methods: {
        show_date(){
            this.datenow = moment().format('Y-M-d');  
        },
        show_add(){
            this.errors = [];
            $('#add_modal').modal('show');
        },
        show_edit(data){
            this.errors = [];
            this.selected = data;
            this.selected_id = data.id;
            $('#edit_modal').modal('show');
        },
        delete_data(data){
            var self = this;
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {

                    $.post('/api/employee/delete/'+data.id, function(res){
                        self.get_data(1);
                    });

                    Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                    )
                }
                })

            
            
        },
        update_data(){
            var self = this;
            var edit_data = $('#edit_form').serialize();
            $.post('/api/employee/update/'+self.selected_id, edit_data, function(res){
                if(res){
                    self.errors = res;
                }else{
                    Swal.fire('Success', 'Data Updated', 'success');
                    $('#edit_modal').modal('hide');
                    self.get_data(self.page);
                }
            });
            console.log(add_data);
        },
        insert_data(){
            var self = this;
            var add_data = $('#add_form').serialize();
            $.post('/api/employee/insert', add_data, function(res){
                if(res){
                    self.errors = res;
                }else{
                    Swal.fire('Success', 'Data Inserted', 'success');
                    $('#add_modal').modal('hide');
                    self.get_data(self.total_page);
                }
            });
            console.log(add_data);
        },
        get_dropdown_data(){
            var self = this;
            $.get('/api/race', function(res){self.race = res;});
            $.get('/api/religion', function(res){self.religion = res;});
        },
        get_data(page = 1) {
            var self = this;
            self.page = page;
            $.post('/api/employee/listing', {
                search: self.search,
                race: self.sel_race,
                religion: self.sel_religion,
                page: self.page,
            }, function(res){
                self.contents = res.data;
                self.total_data = res.total_data;
                self.total_page = res.total_page;
            });
        },
    },
    mounted(){
        this.show_date();
        this.get_data();
        this.get_dropdown_data();

    },
  }).mount('#app')
</script>
