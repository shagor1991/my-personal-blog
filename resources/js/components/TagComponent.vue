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
                            <table class="table table-bordered table-hover">
                            <thead>                  
                                <tr>
                                <th>#</th>
                                <th>Tag Name</th>
                                <th>Slug</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(customer, index) in customers" :key="customer.id">
                                    <td>{{index+1}}</td>
                                    <td>{{customer.name}}</td>
                                    <td>
                                        {{customer.slug}}
                                    </td>
                                    <td>
                                        <button class="btn btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button class="btn btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <button class="btn btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                                              
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                            </ul>
                        </div>
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
                <form role="form" @submit.prevent="store()">
                    <div class="modal-body">                
                        <div class="card-body">
                        <div class="form-group">
                            <label for="tag_name">Tag Name</label>
                            <input type="text" v-model="form.name" class="form-control" id="tag_name" placeholder="Tag Name">
                        </div>                       
                        </div>
                        <!-- /.card-body -->                
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data(){
            return {
                customers: [],
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
                axios.get('/api/tag')
                .then((response)=>{
                    this.customers= response.data.tags.data
                })
                .catch((error)=>{
                    console.log(error)
                })
            },
            create(){
                $('#TagModalLong').modal('show')
            },
            store(){
                this.form.post('/api/tag')
                .then(response=>{
                    this.getData()
                    $('#TagModalLong').modal('hide')
                })
                .catch(error=>{
                    console.log(error)
                })
            }
        }
    }
</script>
