<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Simple Tables</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Simple Tables</li>
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
                <h3 class="card-title">Bordered Table</h3>
                <div class="card-tools">
                    <button class="btn btn-info" @click="create()">
                        Add New
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <form class="mb-3">
                      <div class="row">
                          <div class="col-md-3">
                              Search By: 
                          </div>
                          <div class="col-md-3">
                              <select v-model="queryField" class="form-control">
                                  <option value="parent_id">Parent</option>
                                  <option value="name">Name</option>
                                  <option value="category_slug">Category Slug</option>
                              </select>
                          </div>
                          <div class="col-md-6">
                              <input type="text" v-model="query" class="form-control" placeholder="Search">
                          </div>
                      </div>
                  </form>
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                    <thead>                  
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Photo</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(category, index) in categories" :key="category.id">
                            <td>{{pagination.from+index}}</td>
                            <td>{{category.name}}</td>
                            <td> {{category.photo}}</td>
                            <td>
                                <button class="btn btn-primary"> 
                                    <i class="fas fa-eye"></i>
                                </button>

                                <button class="btn btn-info"> 
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button class="btn btn-danger"> 
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        
                    </tbody>
                    </table>

                    <pagination
                    :pagination='pagination'
                    :offset="5"
                    @paginate="getCategories()"
                    > </pagination>
                  </div>
              </div>
              <!-- /.card-body -->
              
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col -->

          </div>
          <!-- / .row  -->

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Create / Update Modal -->
    <div class="modal fade" id="CategoryModalLong" tabindex="-1" role="dialog" aria-labelledby="CategoryModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="CategoryModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="store()">
                <div class="modal-body"> 
                
                <div class="form-group">
                  <label>Parent Category</label>
                  <multiselect v-model="form.parent_id" :options="parent_options" @select="updateParent()" track-by="id" label="name"></multiselect>
                </div>

                <div class="form-group">
                    <label for="category_name">Category Name</label>
                    <input type="text" class="form-control" id="category_name" v-model="form.name" placeholder="Enter email" :class="{ 'is-invalid': form.errors.has('username') }">
                    <has-error :form="form" field="name"></has-error>
                </div>
                
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
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
    name: 'CategoryComponent',
    data(){
        return {
            categories: [],
            pagination: {
                current_page: 1,
                from: 1
            },
            form: new Form({
                'id': '',
                'parent_id': '',
                'name': '',
            }),
            query: '',
            queryField: 'name',
            parent_value: null,
            parent_options: []
        }
    },
    mounted(){        
        this.getCategories()
        this.getParentCategory()
    },
    watch:{
        query: function(queryNew, queryOld){
            if(queryNew ===''){
                this.getCategories()
            }else{
                this.searchdata()
            }
        }
    },
    methods: {
        getCategories(){
            this.$Progress.start()
            axios.get('/api/category?page='+ this.pagination.current_page)
            .then(response=> {
                // console.log(response)
                this.$Progress.finish()
                this.categories= response.data.data
                this.pagination= response.data.meta
            })
            .catch(error=> {
                this.$Progress.fail()
            })
        },
        searchdata(){
            this.$Progress.start()
            axios.get('/api/search/category/'+this.queryField+ '/'+this.query+ '?page='+ this.pagination.current_page)
            .then(response=> {
                console.log(response)
                this.$Progress.finish()
                this.categories= response.data.data
                this.pagination= response.data.meta
            })
            .catch(error=> {
                this.$Progress.fail()
            })
        },
        getParentCategory(){
            axios.get('/api/parentcategory')
            .then(response=> {
                console.log(response.data.data);
                this.parent_options= response.data.data
            })
            .catch(error=> {
                this.$Progress.fail()
            })
        },
        create(){
            $('#CategoryModalLong').modal('show')
        },
        store(){
            console.log(this.form);
        },
        updateParent(){
            console.log(this.form.parent_id.id)
        }
    }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>

</style>>
