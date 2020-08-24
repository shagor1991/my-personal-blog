<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- <h1>Form Validation</h1> -->
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Validation</li>
                    </ol>
                </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tags</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-info" @click="create">
                                    Add New
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form class="mb-3">
                                <div class="row">
                                    <div class="col-md-2">
                                        Search By:
                                    </div>
                                    <div class="col-md-4">
                                        <select v-model="queryField" id="field" class="form-control">
                                            <option value="name">Name</option>
                                            <option value="slug">Slug</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" v-model="query" class="form-control" placeholder="Search">
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover ">
                                <thead>                  
                                    <tr>
                                    <th>#</th>
                                    <th>Tag Name</th>
                                    <th>Slug</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(tag, index) in tags" :key="tag.id">
                                        <td>{{pagination.from +index}}</td>
                                        <td>{{tag.name}}</td>
                                        <td>
                                            {{tag.slug}}
                                        </td>
                                        <td>
                                            <button class="btn btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <button class="btn btn-primary" @click="edit(tag)">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button type="button"  @click="destroy(tag)" class="btn btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                                                
                                </tbody>
                                </table>
                                <pagination
                                :pagination='pagination'
                                :offset="5"
                                @paginate="query==='' ? getData() : searchData()"
                                > </pagination>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        
                        </div>
                        <!-- /.card -->

                    </div>
                </div>
                <!-- /.row -->


            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        <!-- Modal -->
        <div class="modal fade" id="TagModalLong" tabindex="-1" role="dialog" aria-labelledby="TagModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="TagModalLongTitle">{{ editMode ? "Edit" : "Add"}} Tag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form role="form" @submit.prevent="editMode ? update(): store()" @keydown="form.onKeydown($event)">
                    <div class="modal-body">                
                        <div class="card-body">

                            <alert-error :form="form"></alert-error>

                            <div class="form-group">
                                <label for="name">Tag Name</label>
                                <input type="text" v-model="form.name" class="form-control" id="name" placeholder="Tag Name" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>                       
                        </div>
                        <!-- /.card-body -->                
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" :disabled="form.busy" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    
    <vue-progress-bar></vue-progress-bar>
    <vue-snotify></vue-snotify>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                tags: [],
                queryField:'name',
                query: '',
                editMode: false,
                pagination: {
                    current_page: 1,
                    from: 1
                },
                form: new Form({
                    id: '',
                    name: ''
                })
            }
        },
        watch: {
            query: function(query_new, query_old){
                if(query_new === ''){
                    this.getData();
                }else{
                    this.searchData();
                }
            }
        },
        mounted() {
            this.getData()
        },
        methods:{
            getData(){
                this.$Progress.start()
                axios.get('/api/tag?page='+ this.pagination.current_page)
                .then((response)=>{
                    console.log(response)
                    this.tags= response.data.data
                    this.pagination = response.data.meta;
                    this.$Progress.finish()
                })
                .catch((error)=>{
                    console.log(error)
                    this.$Progress.fail()
                })
            },
            searchData(){
                this.$Progress.start()
                axios.get('/api/search/tags/'+ this.queryField+ '/'+ this.query+ "?page="+ this.pagination.current_page)
                .then(response=>{
                    console.log(response)
                    this.tags= response.data.data
                    this.pagination = response.data.meta;
                    this.$Progress.finish()
                })
                .catch(error=> {
                    console.log(error)
                    this.$Progress.fail()
                })
            },
            create(){
                this.editMode= false
                this.form.reset()
                this.form.clear() 
                $('#TagModalLong').modal('show')
            },
            store(){
                this.$Progress.start()
                this.form.busy= true
                this.form.post('/api/tag')
                .then(response=>{
                    this.getData()
                    $('#TagModalLong').modal('hide')
                    
                    if(this.form.successful){
                        this.$Progress.finish()
                        this.$snotify.success("tag created successfully!", "Success")
                    }else{
                        this.$Progress.fail();
                        this.$snotify.error(
                        "Something went wrong try again later.",
                        "Error"
                        );
                    }
                })
                .catch(error=>{
                    console.log(error)
                    this.$Progress.fail();
                    // $('#TagModalLong').modal('hide')
                })
            },
            edit(tag){
                this.editMode= true
                this.form.reset()
                this.form.clear()
                this.form.fill(tag)
                $('#TagModalLong').modal('show');
            },
            update(){
                this.$Progress.start()
                this.form.busy= true
                this.form.put('/api/tag/'+ this.form.id)
                .then(response=>{
                    this.getData()
                    $('#TagModalLong').modal('hide')
                    
                    if(this.form.successful){
                        this.$Progress.finish()
                        this.$snotify.success("tag updated successfully!", "Success")
                    }else{
                        this.$Progress.fail();
                        this.$snotify.error(
                        "Something went wrong try again later.",
                        "Error"
                        );
                    }
                })
                .catch(error=>{
                    console.log(error)
                    // $('#TagModalLong').modal('hide')
                })
            },
            destroy(tag){
                // console.log(tag)
                this.$snotify.clear();

                this.$snotify.confirm('Are you sure to delete this?', 'Danger!', {
                showProgressBar: true,
                closeOnClick: false,
                pauseOnHover: true,
                buttons: [
                    {
                        text: 'Yes', 
                        action: (toast) => {
                            this.$snotify.remove(toast.id);
                            this.$Progress.start();
                            axios.delete('/api/tag/'+tag.id)
                            .then(response=> {
                                this.getData()
                                this.$Progress.finish()
                                this.$snotify.success("Deleted Successfully","Success")
                            })
                            .catch(error=> {
                                this.$Progress.fail()

                            })

                            },
                        bold: true
                    },
                    {
                        text: 'No',
                        action: (toast) => {
                            this.$snotify.remove(toast.id); 
                        },
                        bold: true
                    },
                ]
                });
            }
        }
    }
</script>