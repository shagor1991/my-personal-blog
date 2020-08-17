<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Form Validation</h1>
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
                            <h3 class="card-title">All Tags</h3>
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

                                            <button class="btn btn-primary">
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
                                @paginate="getData()"
                                > </pagination>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <!-- <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                            </ul>
                        </div> -->
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
                <h5 class="modal-title" id="TagModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form role="form" @submit.prevent="store()" @keydown="form.onKeydown($event)">
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
                pagination: {
                    current_page: 1,
                    from: 1
                },
                form: new Form({
                    name: ''
                })
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
            create(){
                this.form.reset()
                this.form.clear()
                this.$snotify.success("tag created successfully!", "Success"); 
                $('#TagModalLong').modal('show')
            },
            store(){
                this.form.busy= true
                this.form.post('/api/tag')
                .then(response=>{
                    this.getData()
                    $('#TagModalLong').modal('hide')
                    this.$snotify.success("tag created successfully!", "Success")
                })
                .catch(error=>{
                    console.log(error)
                })
            },
            destroy(tag){
                // console.log(tag)
                this.$snotify.success("Are you sure to delete this?");
            }
        }
    }
</script>
